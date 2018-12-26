<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RouletteStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'meals' => 'required|array',
            // 'meals.*.date' => 'required|date',
            // 'meals.*.recipe_id' => 'required'
        ];
    }
}
