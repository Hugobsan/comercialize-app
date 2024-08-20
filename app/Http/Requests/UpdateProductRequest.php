<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user()->can('update', $this->product)) {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'quantity' => 'required|integer|min:0',
        ];
    }

    /**
     * Converte os nomes dos inputs para português.
     * 
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'photo' => 'foto',
            'price' => 'preço',
            'category_id' => 'categoria',
            'quantity' => 'quantidade',
        ];
    }
}
