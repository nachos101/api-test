<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    // autorizar 
    public function authorize(): bool
    {
        return true;
    }

    // reglas de validacion
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ];
    }

    // mensajes de error
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del producto es obligatorio',
            'price.min' => 'El precio debe ser mayor a 0',
            'category.required' => 'La categoría es obligatoria',
            'price.numeric' => 'El precio debe ser un número',
            'stock.integer' => 'El stock debe ser un número entero'
        ];
    }
}
