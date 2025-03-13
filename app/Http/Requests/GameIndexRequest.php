<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameIndexRequest extends FormRequest
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
            'character_id' => 'required|integer|exists:characters,id',
        ];
    }

    public function messages(): array
    {
        return [
            'character_id.required' => 'Это поле необходимо заполнить',
            'character_id.integer' => 'Это поле должно быть строкой',
        ];
    }
}
