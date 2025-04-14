<?php

namespace App\Http\Requests\Combinacao;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return  [
            'codigo' => [
                'required',
                'string',
                'max:9',
                Rule::unique('combinacoes', 'codigo'),
            ],
            'codigo_moeda_base' => [
                'required',
                'string',
                'max:5',
            ],
            'descricao' => [
                'required',
                'string',
                'max:255',
                Rule::unique('combinacoes', 'descricao'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.unique' => 'O código já está em uso.',
            'codigo.required' => 'O código é obrigatório.',
            'codigo.string' => 'O código deve ser uma string.',
            'codigo.max' => 'O código deve ter no máximo 9 caracteres.',

            'codigo_moeda_base.required' => 'O código da moeda base é obrigatório.',
            'codigo_moeda_base.string' => 'O código da moeda base deve ser uma string.',
            'codigo_moeda_base.max' => 'O código da moeda base deve ter no máximo 5 caracteres.',
            
            'descricao.unique' => 'A descrição já está em uso.',
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.string' => 'A descrição deve ser uma string.',
            'descricao.max' => 'A descrição deve ter no máximo 255 caracteres.',            
        ];
    }
}
