<?php

namespace App\Http\Requests\Api\Device;

use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];

        if ($this->route()->getName() === 'api.v1.device.connect') {
            $rules = [
                'device_uuid' => 'required|string|unique:devices,device_uuid',
            ];
        } elseif ($this->route()->getName() === 'api.v1.device.sync-exercise') {
            $rules = [
                'exercise_type' => 'required|string|max:100',
                'duration' => 'required|integer|min:1|max:300',
                'calories_burned' => 'required|numeric|min:0|max:2000',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'device_uuid.required' => 'Device UUID is required.',
            'device_uuid.unique' => 'This device is already connected.',

            'exercise_type.required' => 'Exercise type is required.',
            'exercise_type.max' => 'Exercise type must not exceed 100 characters.',
            'duration.required' => 'Duration is required.',
            'duration.integer' => 'Duration must be a whole number.',
            'duration.min' => 'Duration must be at least 1 minute.',
            'duration.max' => 'Duration must not exceed 300 minutes.',
            'calories_burned.required' => 'Calories burned is required.',
            'calories_burned.numeric' => 'Calories burned must be a number.',
            'calories_burned.min' => 'Calories burned must be at least 0.',
            'calories_burned.max' => 'Calories burned must not exceed 2000.',
            'start_time.required' => 'Start time is required.',
            'start_time.date' => 'Please provide a valid start time.',
            'end_time.required' => 'End time is required.',
            'end_time.date' => 'Please provide a valid end time.',
            'end_time.after' => 'End time must be after start time.',
        ];
    }
}
