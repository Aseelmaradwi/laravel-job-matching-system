<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'salary' => ['required', 'numeric', 'min:0'],
            'type' => ['required', 'in:full-time,contract,hybrid,remote'],
            'companyId' => ['required', 'exists:companies,id'],
            'categoryId' => ['required', 'exists:job_categories,id'],
            'description' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The job title is required.',
            'location.required' => 'The job location is required.',
            'salary.required' => 'The job salary is required.',
            'description.required' => 'The job description is required.',
        ];
    }
}