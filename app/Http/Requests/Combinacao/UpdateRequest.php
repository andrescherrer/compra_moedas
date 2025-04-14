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
        ];
    }
}
