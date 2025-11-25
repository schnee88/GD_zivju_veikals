<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'phone' => ['required', 'regex:/^(\+371|371)?[2-3]\d{7}$/'],
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'Telefona numurs ir obligāts',
            'phone.regex' => 'Lūdzu, ievadiet derīgu Latvijas telefona numuru (piemēram: +371 20123456 vai 20123456)',
            'notes.max' => 'Piezīmes nedrīkst būt garākas par 500 rakstzīmēm',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Normalize phone number
        if ($this->has('phone')) {
            $phone = preg_replace('/\s+/', '', $this->phone);
            $this->merge(['phone' => $phone]);
        }
    }
}