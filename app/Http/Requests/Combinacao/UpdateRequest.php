<?php

namespace App\Http\Requests\Combinacao;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'codigo' => [
                'string',
                'max:9',
                Rule::unique('combinacoes', 'codigo')->ignore($this->route('combinacao')->id),
            ],
            'codigo_moeda_base' => [
                'string',
                'max:5',
            ],
            'descricao' => [
                'string',
                'max:255',
                Rule::unique('combinacoes', 'descricao')->ignore($this->route('combinacao')->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.unique' => 'O código já está em uso.',
            'codigo_moeda_base.unique' => 'O código da moeda base já está em uso.',
            'descricao.unique' => 'A descrição já está em uso.',
            'codigo.max' => 'O código deve ter no máximo 9 caracteres.',
            'codigo_moeda_base.max' => 'O código da moeda base deve ter no máximo 5 caracteres.',
            'descricao.max' => 'A descrição deve ter no máximo 255 caracteres.',
            'codigo.string' => 'O código deve ser uma string.',
            'codigo_moeda_base.string' => 'O código da moeda base deve ser uma string.',
            'descricao.string' => 'A descrição deve ser uma string.',
        ];
    }
}
