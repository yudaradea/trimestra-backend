<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'birth_date' => 'required|date|before:today',
            'height' => 'required|numeric|min:100|max:250',
            'weight' => 'required|numeric|min:30|max:200',
            'is_pregnant' => 'required|boolean',
            'pregnancy_weeks' => 'nullable|integer|min:1|max:40|required_if:is_pregnant,1',
            'is_first_pregnancy' => 'nullable|boolean',
            'diet_preference' => 'required|in:normal,vegetarian',
            'health_goals' => 'required|array|min:1',
            'health_goals.*' => 'string',
        ];
    }

    public function messages()
    {
        return [
            'birth_date.required' => 'Birth date is required.',
            'birth_date.date' => 'Please provide a valid date.',
            'birth_date.before' => 'Birth date must be in the past.',
            'height.required' => 'Height is required.',
            'height.numeric' => 'Height must be a number.',
            'height.min' => 'Height must be at least 100 cm.',
            'height.max' => 'Height must not exceed 250 cm.',
            'weight.required' => 'Weight is required.',
            'weight.numeric' => 'Weight must be a number.',
            'weight.min' => 'Weight must be at least 30 kg.',
            'weight.max' => 'Weight must not exceed 200 kg.',
            'is_pregnant.required' => 'Please indicate pregnancy status.',
            'pregnancy_weeks.required_if' => 'Pregnancy weeks is required when pregnant.',
            'pregnancy_weeks.integer' => 'Pregnancy weeks must be a number.',
            'pregnancy_weeks.min' => 'Pregnancy weeks must be at least 1.',
            'pregnancy_weeks.max' => 'Pregnancy weeks must not exceed 40.',
            'diet_preference.required' => 'Diet preference is required.',
            'health_goals.required' => 'At least one health goal is required.',
            'health_goals.array' => 'Health goals must be an array.',
        ];
    }
}
