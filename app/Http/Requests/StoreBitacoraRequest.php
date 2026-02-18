<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBitacoraRequest extends FormRequest
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
            'descFalla' => 'required|string|max:3000',
            'descSolucion' => 'required|string|max:3000',
            'materialReq' => 'required|string|max:3000',
            'duracion' => 'required|integer|min:1',
            'idSolicitud' => 'required|exists:solicituds,id',
        ];
    }
}
