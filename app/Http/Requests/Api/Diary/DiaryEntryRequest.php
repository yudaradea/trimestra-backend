<?php

namespace App\Http\Requests\Api\Diary;

use Illuminate\Foundation\Http\FormRequest;

class DiaryEntryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => 'required|date',
            'meal_type' => 'required|in:breakfast,lunch,dinner,snack',
            'food_id' => 'nullable|exists:food,id',
            'recipe_id' => 'nullable|exists:recipes,id',
            'quantity' => 'nullable|numeric|min:0.1|max:10',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'Date is required.',
            'date.date' => 'Please provide a valid date.',
            'meal_type.required' => 'Meal type is required.',
            'meal_type.in' => 'Please select a valid meal type.',
            'food_id.exists' => 'Selected food does not exist.',
            'recipe_id.exists' => 'Selected recipe does not exist.',
            'quantity.numeric' => 'Quantity must be a number.',
            'quantity.min' => 'Quantity must be at least 0.1.',
            'quantity.max' => 'Quantity must not exceed 10.',
        ];
    }

    // Validasi tambahan akan dilakukan di controller
}
