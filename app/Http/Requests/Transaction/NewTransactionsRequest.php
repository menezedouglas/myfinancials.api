<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class NewTransactionsRequest extends FormRequest
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
            'transactions' => 'required|array',
            'transactions.*.bank_id' => 'required|integer|exists:App\Models\Bank,id',
            'transactions.*.payer_id' => 'required|integer|exists:App\Models\Payer,id',
            'transactions.*.date' => 'required|date',
            'transactions.*.type' => 'required|string',
            'transactions.*.amount' => 'required|numeric',
            'transactions.*.description' => 'nullable|string'
        ];
    }

    public function attributes(): array
    {
        return [
            'transactions' => 'Dados',
            'transactions.*.bank_id' => 'Banco',
            'transactions.*.payer_id' => 'Pagador',
            'transactions.*.date' => 'Data da Transação',
            'transactions.*.type' => 'Tipo de Transação',
            'transactions.*.amount' => 'Quantia',
            'transactions.*.description' => 'Descrição'
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
