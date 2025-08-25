<?php

namespace App\Http\Requests\Api\Favorite;

use Illuminate\Foundation\Http\FormRequest;

class FavoriteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => 'required|in:food,recipe,fruit,drink',
            'food_id' => 'required_if:type,food,fruit,drink|exists:foods,id',
            'recipe_id' => 'required_if:type,recipe|exists:recipes,id',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Favorite type is required.',
            'type.in' => 'Please select a valid favorite type.',
            'food_id.required_if' => 'Food is required for this favorite type.',
            'food_id.exists' => 'Selected food does not exist.',
            'recipe_id.required_if' => 'Recipe is required for this favorite type.',
            'recipe_id.exists' => 'Selected recipe does not exist.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->validated();

            // Ensure only one ID is provided
            if (isset($data['food_id']) && isset($data['recipe_id'])) {
                $validator->errors()->add('food_or_recipe', 'Please select either a food or a recipe, not both.');
            }

            if (!isset($data['food_id']) && !isset($data['recipe_id'])) {
                $validator->errors()->add('food_or_recipe', 'Please select either a food or a recipe.');
            }
        });
    }
}
