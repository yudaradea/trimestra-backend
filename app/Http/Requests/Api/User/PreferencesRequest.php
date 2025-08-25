<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class PreferencesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'diet_type' => 'required|in:vegetarian,keto,vegan,paleo,gluten-free,no_preference',
            'allergies' => 'required|array',
            'allergies.*' => 'string',
            'preferred_meal_times' => 'required|array|min:1',
            'preferred_meal_times.*' => 'in:breakfast,lunch,dinner,snack',
            'calorie_target' => 'required|in:<1500,1500-2000,>2000,not_sure',
            'cooking_time_preference' => 'required|in:<15,15-30,>30',
            'serving_preference' => 'required|in:3,4,5,>5',
        ];
    }

    public function messages()
    {
        return [
            'diet_type.required' => 'Diet type is required.',
            'diet_type.in' => 'Please select a valid diet type.',
            'allergies.required' => 'Allergies information is required.',
            'allergies.array' => 'Allergies must be an array.',
            'preferred_meal_times.required' => 'Preferred meal times are required.',
            'preferred_meal_times.array' => 'Preferred meal times must be an array.',
            'preferred_meal_times.min' => 'At least one meal time must be selected.',
            'preferred_meal_times.*.in' => 'Please select valid meal times.',
            'calorie_target.required' => 'Calorie target is required.',
            'calorie_target.in' => 'Please select a valid calorie target.',
            'cooking_time_preference.required' => 'Cooking time preference is required.',
            'cooking_time_preference.in' => 'Please select a valid cooking time preference.',
            'serving_preference.required' => 'Serving preference is required.',
            'serving_preference.in' => 'Please select a valid serving preference.',
        ];
    }
}
