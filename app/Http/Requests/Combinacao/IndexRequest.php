<?php

namespace App\Http\Requests\Combinacao;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'codigo' => 'nullable|string',
            'codigo_moeda_base' => 'nullable|string',
            'descricao' => 'nullable|string',
            'per_page' => 'nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'per_page.min' => 'O número de itens por página deve ser maior que 0.',
        ];
    }
}