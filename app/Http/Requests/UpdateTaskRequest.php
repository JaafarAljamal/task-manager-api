<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'title' => 'sometimes|string|max:40',
            'description' => 'sometimes|nullable|string',
            'priority' => 'sometimes|in:high,medium,low',
        ];
    }

    /**
     * Function to customize validation messages.
     */
    public function messages(): array
    {
        return [
            'title.max' => 'The entered title exceeds the allowed length, which is 40 characters',
            'priority.integer' => 'Priority must be an integer in high, medium, and low',
        ];
    }
}
