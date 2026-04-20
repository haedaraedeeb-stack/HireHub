<?php

namespace App\Http\Requests;

use App\Rules\NoOffensiveWords;
use Illuminate\Validation\Rule;
// use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role === 'client';
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => trim($this->title),
            'description' => trim($this->description),
        ]);
        if ($this->has('tags')){
            $tags = $this->tags;
            if(is_string($tags)){
            $tags = explode(',', $tags);
            }if (is_array($tags)) {
            $this->merge([
                'tags' => array_map('trim', $tags),
            ]); }
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
            'title' => ['required','string','max:255','min:30',
            new NoOffensiveWords],
            'description' => ['required', 'string', 'max:2000', 'min:200', new NoOffensiveWords],
            'budget_type' => ['required', 'in:fixed,hourly'],
            'budget' => [
                'required',
                'numeric',
                Rule::when($this->budget_type === 'hourly', ['min:5', 'max:100']),
                Rule::when($this->budget_type === 'fixed', ['min:100']),
            ],
            'deadline' => 'required|date|after:today',
            'tags' => 'nullable|array|max:5',
            'tags.*' => 'string|max:20',
            'files' => 'nullable|array|max:3',
            'files.*' => 'file|mimes:jpg,jpeg,png,zip,docs,pdf|max:5120'
        ];
    }

    public function messages(): array
    {
        return [
        'title.required' => 'لا يمكن نشر مشروع بدون عنوان، يرجى كتابة عنوان معبر.',
        'title.min' => 'عنوان المشروع قصير جداً، يرجى توضيح الفكرة في 30 حرفاً على الأقل.',
        'description.min' => 'وصف المشروع غير كافٍ، المستقلون يحتاجون لتفاصيل أكثر لتقديم عروض دقيقة.',
        'budget.required' => 'يرجى تحديد الميزانية المتوقعة للمشروع.',
        'budget.min' => 'الميزانية المدخلة منخفضة جداً، يرجى وضع قيمة واقعية.',
        'deadline.after' => 'تاريخ التسليم يجب أن يكون في المستقبل، لا يمكن اختيار تاريخ قديم.',
        'tags.max' => 'لقد تجاوزت الحد المسموح للوسوم، يمكنك اختيار 5 وسوم فقط.',
        'budget_type.in' => 'يرجى اختيار نوع ميزانية صحيح (سعر ثابت أو بالساعة).',
        'files.max' => ' يرجى التقيد بالحجم المسموح وعو 5 MB'
        ];
    }
    public function attributes() {
    return [
        'title' => 'عنوان المشروع',
        'description' => 'وصف المشروع',
        'deadline' => 'تاريخ التسليم'
        ];
    }
}
