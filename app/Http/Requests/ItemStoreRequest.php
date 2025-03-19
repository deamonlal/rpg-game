<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ItemStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:weapon,armor', // только допустимые типы
            'tier' => 'required|string|max:255',
            'damage' => 'nullable|integer|min:1', // только для типа weapon
            'armor' => 'nullable|integer|min:1',  // только для типа armor
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Это поле необходимо заполнить',
            'name.string' => 'Это поле должно быть строкой',
            'description.required' => 'Это поле необходимо заполнить',
            'description.string' => 'Это поле должно быть строкой',
            'type.required' => 'Это поле необходимо заполнить',
            'type.string' => 'Это поле должно быть строкой',
            'tier.required' => 'Это поле необходимо заполнить',
            'tier.integer' => 'Это поле должно быть целочисленного типа',
            'damage.integer' => 'Это поле должно быть целочисленного типа',
            'armor.integer' => 'Это поле должно быть целочисленного типа',
        ];
    }
}
