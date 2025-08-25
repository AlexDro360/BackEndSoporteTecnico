<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBitacoraRequest extends FormRequest
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
            'descFalla' => 'sometimes|string|max:200',
            'descSolucion' => 'sometimes|string|max:200',
            'materialReq' => 'sometimes|string|max:200',
            'duracion' => 'sometimes|integer|min:1',
            'idSolicitud' => 'sometimes|exists:solicituds,id',
        ];
    }
}
