<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePluginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required',
            'domain' => 'required|min:3|max:50|unique:plugins,domain,NULL,id,deleted_at,NULL',
            'api_token' => 'required|min:3|max:255',
            'license_code' => 'required|min:3|max:255|unique:plugins,license_code,NULL,id,deleted_at,NULL',
        ];
    }

    public function messages(): array
    {
        return [
            'license_code.unique' => 'This license code is already registered. Please use a different license code.',
            'domain.unique' => 'This domain is already registered.',
        ];
    }
}
