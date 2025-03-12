<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CharacterStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'level' => 'required|integer',
            'exp' => 'required|integer',
            'gold' => 'required|integer',
            'health' => 'required|integer',
            'inventory' => 'json',
            'skills' => 'json',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Это поле необходимо заполнить',
            'name.string' => 'Это поле должно быть строкой',
            'surname.required' => 'Это поле необходимо заполнить',
            'surname.string' => 'Это поле должно быть строкой',
            'email.required' => 'Это поле необходимо заполнить',
            'email.email' => 'Это поле должно быть типа email',
            'age.integer' => 'Это поле должно быть целочисленного типа',
            'description.string' => 'Это поле должно быть строкой',
        ];
    }
}
