<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

   public function rules(): array
{
    $companyId = $this->route('company');

    return [
        'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('companies', 'name')->ignore($companyId),
        ],

        'industry' => ['required', 'string', 'max:255'],
        'address'  => ['nullable', 'string', 'max:255'],

        'website' => [
            'nullable',
            'url',
            Rule::unique('companies', 'website')->ignore($companyId),
        ],

        'owner_type' => ['required', 'in:existing,new'],

        'ownerId' => [
            'required_if:owner_type,existing',
            'nullable',
            'exists:users,id',
        ],

        'new_owner_name' => [
            'required_if:owner_type,new',
            'nullable',
            'string',
            'max:255'
        ],

        'new_owner_email' => [
            'required_if:owner_type,new',
            'nullable',
            'email',
            'unique:users,email'
        ],

        'new_owner_password' => [
            'required_if:owner_type,new',
            'nullable',
            'min:6'
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