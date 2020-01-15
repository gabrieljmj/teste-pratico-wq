<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PropertyRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $pictureNecessity = $this->route('property') ? 'sometimes' : 'required';

        return [
            // Property
            'property.title' => 'required|string',
            'property.description' => 'required|string',
            'property.rent' => 'required|min:0',
            'property.picture' => $pictureNecessity.'|file|image',
            'property.latitude' => 'required',
            'property.longitude' => 'required',

            // Address
            'address.address' => 'required',
            'address.number' => 'required',
            'address.city' => 'required',
            'address.state' => ['required', Rule::in($this->getStates())],
            'address.zip_code' => 'required|formato_cep',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'property.title.required' => 'É necessário informar o título do imóvel.',
            'property.description.required' => 'É necessário informar a descrição do imóvel.',
            'property.rent.required' => 'É necessário informar o valor do aluguel do imóvel.',
            'property.picture.required' => 'É necessário enviar uma imagem do imóvel.',
            'property.picture.image' => 'Formato inválido de imagem.',

            'address.address.required' => 'É necessário informar a rua do imóvel.',
            'address.number.required' => 'É necessário informar o número do imóvel.',
            'address.city.required' => 'É necessário informar a cidade do imóvel.',
            'address.state.required' => 'É necessário informar o estado do imóvel.',
            'address.state.in' => 'Informe uma sigla de estado brasileiro válida.',
            'address.zip_code.required' => 'É necessário informar o CEP do imóvel.',
            'address.zip_code.formato_cep' => 'O CEP informado é inválido.',
        ];
    }

    private function getStates(): array
    {
        return [
            'AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RO', 'RS', 'RR', 'SC', 'SE', 'SP', 'TO',
        ];
    }
}
