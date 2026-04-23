<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);

        if ($user->role === 'freelancer') {
            $code = rand(100000, 999999);
            $user->update([
                'verification_code' => $code,
                'verification_code_expires_at' => now()->addMinutes(60),
            ]);
            Mail::to($user->email)->send(new VerificationCodeMail($code));
        }

        $token = $user->createToken($user->name);

        return $this->success([
            'user'  => new UserResource($user),
            'token' => $token->plainTextToken,
        ], $user->name . ' registered. Check your email.', 201);
    }

    public function login(LoginUserRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return $this->failed('Fields not correct.', 401);
        }

        $token = $user->createToken($user->name);

        return $this->success([
            'user'        => new UserResource($user),
            'token'       => $token->plainTextToken,
            'is_verified' => (bool) $user->is_verified,
        ], $user->name . ' logged in.', 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success(null, 'Logged out.', 200);
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|integer']);
        $user = $request->user();
        if ($user->role !== 'freelancer') {
                return $this->failed('Only freelancers need verification.', 403);
            }
        if ($user->is_verified) {
            return $this->failed('Already verified.', 400);
        }

        if (!$user->verification_code_expires_at || now()->isAfter($user->verification_code_expires_at)) {
        return $this->failed('Code expired. Request a new one.', 422);
        }

        if ($user->verification_code !== $request->code) {
            return $this->failed('Invalid verification code.', 422);
        }

        $user->update([
            'verification_code'            => null,
            'verification_code_expires_at' => null,
            'is_verified'                  => true,
            'email_verified_at'            => now(),
        ]);

        return $this->success(null, 'Account verified successfully.');
    }

    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user->is_verified) {
            return $this->failed('Already verified.', 400);
        }

        $code = rand(100000, 999999);
        $user->update([
            'verification_code'            => $code,
            'verification_code_expires_at' => now()->addMinutes(60),
        ]);

        Mail::to($user->email)->send(new VerificationCodeMail($code));

        return $this->success(null, 'New code sent.');
    }
}
