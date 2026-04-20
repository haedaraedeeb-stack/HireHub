<?php
namespace App\Http\Controllers;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        $token = $user->createToken($request->name);
        return $this->success(['user' => new UserResource($user) ,
        'token' => $token->plainTextToken,
        ], 'User is registered .',201);
    }
    public function login(LoginUserRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email' , $data['email'])->first();
        if(!$user || !Hash::check($data['password'] , $user->password))
        {
            return $this->failed(
            'Fields not correct .'
            ,401);
        }
        else{
        $token = $user->createToken($user->name);
            return $this->success([
            'user' => new UserResource($user),
            'token' => $token->plainTextToken,
            'is_verified' => (bool) $user->is_verified,
        ],  "$user->name . loged in " , 200);
    }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success (null, 'you are logout .', 200);
    }
}

