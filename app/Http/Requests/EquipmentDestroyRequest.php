<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EquipmentDestroyRequest extends FormRequest
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
            'character_id' => 'required|integer|exists:characters,id',
            'slot' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'character_id.required' => 'Это поле необходимо заполнить',
            'character_id.integer' => 'Это поле должно быть целочисленного типа',
            'slot.required' => 'Это поле необходимо заполнить',
            'slot.integer' => 'Это поле должно быть строкой',
        ];
    }
}
