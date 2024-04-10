<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'price' => ['required', 'max:255'],
            'event_id' => ['required', 'integer', 'exists:App\Models\Event,id'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Un nom de ticket est requis',
            'price.required' => 'Un prix est requis',
        ];
    }
}
