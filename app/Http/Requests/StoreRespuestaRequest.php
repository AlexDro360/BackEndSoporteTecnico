<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRespuestaRequest extends FormRequest
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
            'asunto' => 'required|string|max:500',
            'descripcion' => 'required|string|max:3000',
            'nombreVerifico' => 'required|string|max:150',
            'idCentroComputoJefe' => 'required|exists:centro_computo_jefes,id',
            'idTipoMantenimiento' => 'sometimes|exists:tipo_mantenimientos,id',
            'idTipoServicio' => 'sometimes|exists:tipo_servicios,id',
            'idSolicitud' => 'required|exists:solicituds,id',
        ];
    }
}
