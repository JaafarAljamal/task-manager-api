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
            'priority' => 'required|in:high,medium,low',
        ];
    }

    /**
     * Function to customize validation messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The task you try to add needs a title',
            'title.max' => 'The entered title exceeds the allowed length, which is 40 characters',
            'priority.required' => 'Set a priority level to the task you entered, in high, medium, and low',
        ];
    }
}
