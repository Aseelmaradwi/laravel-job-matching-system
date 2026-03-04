<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class CompanyUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

 public function rules(): array
{
$company = $this->route('company');
$companyId = $company?->id ?? auth::user()->company->id;
    return [
        'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('companies', 'name')->ignore($companyId),
        ],

        'industry' => ['nullable', 'string', 'max:255'],
        'address'  => ['nullable', 'string', 'max:255'],

        'website' => [
            'nullable',
            'url',
            Rule::unique('companies', 'website')->ignore($companyId),
        ],

        'ownerId' => [
            'nullable',
            'exists:users,id',
        ],
    ];
}

    public function messages(): array
    {
        return [
            'name.required' => 'Company name is required',
            'name.unique'   => 'Company name already exists',

            'website.url'   => 'Website must be a valid URL',
            'website.unique'=> 'Website already exists',

            'ownerId.exists'=> 'Selected owner does not exist',
            
        ];
    }
}