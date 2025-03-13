<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'level' => 'required|integer|min:1',
            'exp' => 'required|integer|min:0',
            'gold' => 'required|integer|min:0',
            'health' => 'required|integer|min:1',
            'inventory' => 'json',
            'skills' => 'json',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Это поле необходимо заполнить',
            'name.string' => 'Это поле должно быть строкой',
            'level.required' => 'Это поле необходимо заполнить',
            'level.string' => 'Это поле должно быть строкой',
            'exp.required' => 'Это поле необходимо заполнить',
            'exp.integer' => 'Это поле должно быть целочисленного типа',
            'gold.required' => 'Это поле необходимо заполнить',
            'gold.integer' => 'Это поле должно быть типа целочисленного типа',
            'health.required' => 'Это поле необходимо заполнить',
            'health.integer' => 'Это поле должно быть типа целочисленного типа',
            'inventory.json' => 'Это поле должно быть типа json',
            'skills.json' => 'Это поле должно быть типа json',
        ];
    }
}
