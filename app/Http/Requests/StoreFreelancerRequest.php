<?php

namespace App\Http\Requests;

use App\Rules\NoOffensiveWords;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFreelancerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() &&
        auth()->user()->role === 'freelancer' &&
        !auth()->user()->freelancer;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('phone_number')) {
            $this->merge([
                'phone_number' => preg_replace('/\D/', '', $this->phone_number),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bio' => [
                'required',
                'string',
                'min:20',
                new NoOffensiveWords()
            ],
            'price_per_hour' => 'required|numeric|min:0|max:999999.99',
            'phone_number' => 'required|string|max:20',
            'status' => 'required|in:available,busy,not_available',
            'portfolio_links' => 'nullable|array',
            'portfolio_links.*' => 'url',
            'skills' => 'required|array|min:1',
            'skills.*.id' => 'required|exists:skills,id',
            'skills.*.experience' => 'required|integer|min:0|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
