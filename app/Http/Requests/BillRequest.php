<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillRequest extends FormRequest
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
        return [
            'client_id' => 'required|integer|exists:clients,id',
            'number' => 'required|integer',
            'date' => 'required|date',
            'due_date' => 'required|date',
            'status' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'amount' => 'required|integer',
            'notes' => 'nullable|string',
            'items' => 'string',
        ];
    }
}
