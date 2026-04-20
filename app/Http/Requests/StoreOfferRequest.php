<?php

namespace App\Http\Requests;

use App\Models\Project;
use App\Rules\NoOffensiveWords;
use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $projectId = $this->input('project_id');
        $project = Project::find($projectId);
        if (!$project) return false;
        return auth()->id() !== $project->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'price' => 'required|numeric|min:1',
            'letter' => [
                'required',
                'min:100',
                'max:2000',
                new NoOffensiveWords
            ],
            'delivery_days' => 'required|integer|min:1',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,zip,jpg,png|max:5120',
            ];
    }

    public function attributes(): array
    {
        return [
            'price' => 'السعر المعروض',
            'letter' => 'خطاب التقديم',
            'delivery_days' => 'مدة التسليم',
        ];
    }
}
