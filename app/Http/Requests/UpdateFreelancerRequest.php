<?php

namespace App\Http\Requests;

// use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Freelancer;
use App\Rules\NoOffensiveWords;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFreelancerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();

    if ($user->role !== 'freelancer') {
        return false;
    }

    return Freelancer::withoutGlobalScopes()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'bio' => ['sometimes', 'string', 'min:20', new NoOffensiveWords()],
        'price_per_hour' => 'sometimes|numeric|min:0',
        'phone_number' => 'sometimes|string|max:20',
        'status' => 'sometimes|in:available,busy,not_available',
        'portfolio_links' => 'nullable|array',
        'skills' => 'sometimes|array',
        'skills.*.id' => 'required_with:skills|exists:skills,id',
        'skills.*.experience' => 'required_with:skills|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
