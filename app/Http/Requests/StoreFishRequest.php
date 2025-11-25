<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFishRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->is_admin;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'is_orderable' => 'boolean',
            'stock_quantity' => 'nullable|numeric|min:0',
            'stock_unit' => 'nullable|in:kg,pieces',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nosaukums ir obligāts',
            'price.required' => 'Cena ir obligāta',
            'price.min' => 'Cenai jābūt lielākai par 0',
            'image.image' => 'Failam jābūt attēlam',
            'image.max' => 'Attēla izmērs nedrīkst pārsniegt 5MB',
            'stock_unit.in' => 'Mērvienībai jābūt kg vai pieces',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Convert checkbox to boolean
        $this->merge([
            'is_orderable' => $this->has('is_orderable') ? true : false,
        ]);

        // If not orderable, set stock to 0
        if (!$this->is_orderable) {
            $this->merge([
                'stock_quantity' => 0,
                'stock_unit' => 'pieces',
            ]);
        }
    }
}