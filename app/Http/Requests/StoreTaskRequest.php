<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:40',
            'description' => 'nullable|string',
            'priority' => 'required|integer|min:1|max:5',
        ];
    }

    /**
     * Function to customize validation messages.
     * 
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The task you try to add needs a title',
            'title.max' => 'The entered title exceeds the allowed length, which is 40 characters',
            'priority.required' => 'Set a priority level to the task you entered, between 1 and 5',
            'priority.integer' => 'Priority must be an integer between 1 and 5',
            'priority.min' => 'The priority level must be from 1 to 5',
            'priority.max' => 'The priority level must be from 1 to 5',
        ];
    }
}
