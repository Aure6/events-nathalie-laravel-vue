<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:registrations', 'email'],
            'phone' => ['max:255'],
            'company_name' => ['max:255'],
            'event_id' => ['required', 'integer', 'exists:App\Models\Event,id'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Un prénom et un nom sont requis',
            'email.required' => 'Une adresse email est requises',
        ];
    }
}
