<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FightRequest extends FormRequest
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
            'location_tier' => 'required|integer',
            'character_id' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'location_tier.required' => 'Это поле необходимо заполнить',
            'location_tier.integer' => 'Это поле должно быть целочисленным типом',
            'character_id.required' => 'Это поле необходимо заполнить',
            'character_id.integer' => 'Это поле должно быть целочисленным типом',
        ];
    }
}
