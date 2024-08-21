<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('update', Category::class);
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
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|size:7|regex:/^#[0-9a-fA-F]{6}$/',
            'description' => 'nullable|string',
        ];
    }

    public function attributes() : array
    {
        return [
            'name' => 'nome',
            'icon' => 'ícone',
            'color' => 'cor',
            'description' => 'descrição',
        ];
    }
}
