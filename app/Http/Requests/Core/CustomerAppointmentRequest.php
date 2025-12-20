<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class CustomerAppointmentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'appointmentTypeId' => ['required', 'integer'],
            'appointmentStart' => ['required', 'date'],
            'duration' => ['required', 'integer', 'min:15'],
            'trainerId' => ['nullable', 'integer'],
            'appointmentStatus' => ['nullable', 'string'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];

        return $rules;
    }
}
