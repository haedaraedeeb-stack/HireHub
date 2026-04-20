<?php

namespace App\Http\Requests;

use App\Models\Offer;
use App\Models\Project;
use App\Rules\NoOffensiveWords;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $projectId = $this->route('project') ?? $this->project_id;
        $project = Project::findOrFail($projectId);
        $user = $this->user();
        if (!$user->freelancer) {
            abort(403, 'Please complete your freelancer profile first.');
        }

        if ($user->role !== 'freelancer') {
            abort (403, 'Sorry only freelancers can make an offer');
        }
        if ($project->user_id === $user->id) {
            abort (403, 'You can not make an offer on your personal project .');
        }
        if ($project->status !== 'open') {
            abort (403, 'the project is not avaiable .');
        }
        $alreadyOffered = Offer::where('project_id', $project->id)
        ->where('freelancer_id', $user->freelancer->id)->exists();
        if($alreadyOffered) {
            abort (403, 'You have already offered for this project.');
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'price' => 'required|numeric|min:1',
            'letter' => [
                'required',
                'min:100',
                'max:2000',
                new NoOffensiveWords
            ],
            'delivery_days' => 'required|integer|min:1',
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
