<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateTransactionRequest extends FormRequest
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
            'bank_id' => 'nullable|integer|exists:App\Models\Bank,id',
            'payer_id' => 'nullable|integer|exists:App\Models\Payer,id',
            'type' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'description' => 'nullable|string'
        ];
    }

    public function attributes(): array
    {
        return [
            'bank_id' => 'ID do Banco',
            'type' => 'Tipo de Transação',
            'amount' => 'Quantia',
            'description' => 'Descrição'
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
