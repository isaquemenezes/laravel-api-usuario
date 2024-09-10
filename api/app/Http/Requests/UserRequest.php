<?php

namespace App\Http\Requests;

use App\Rules\CPFvalidacao;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

     /**
     * Prepare the data for validation.
     *
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'cpf' => preg_replace('/\D/', '', $this->cpf),
            'telefone' => preg_replace('/\D/', '', $this->telefone),
            'cep' => preg_replace('/\D/', '', $this->cep),
        ]);

        // dd($this->all());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'nome' => 'required|string|max:55',
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($this->user),
            ],
            'cpf' => [
                'required',
                'string',
                'size:11',
                Rule::unique('users', 'cpf')->ignore($this->user),
                new CPFvalidacao(),
            ],

            'data_nascimento' => 'nullable|date',
            'telefone' => 'nullable|string|max:12',
            'cep' => 'required|string|max:12',
            'estado' => 'nullable|string|max:25',
            'cidade' => 'nullable|string|max:55',
            'bairro' => 'nullable|string|max:255',
            'endereco' => 'nullable|string|max:255',
            'status' => 'in:ativo,inativo',
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Por favor, insira um e-mail válido.',
            'email.unique' => 'O e-mail informado já está em uso.',
            'cpf.unique' => 'O CPF informado já está em uso.',
            'cpf.size' => 'O CPF deve conter exatamente 11 dígitos.',
        ];
    }

}
