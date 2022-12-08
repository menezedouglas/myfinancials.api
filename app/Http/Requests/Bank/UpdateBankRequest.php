<?php

namespace App\Http\Requests\Bank;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateBankRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
        return [
            'name' => 'required|string',
            'pix' => 'required|string'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nome',
            'pix' => 'Chave Pix'
        ];
    }

    /**
     * Errors detected are returned
     *
     * @param Validator $validator
     * @return JsonResponse
     */
    public function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'message' => $validator->errors(),
                    'code' => 422
                ],
                422
            )
        );
    }
}
