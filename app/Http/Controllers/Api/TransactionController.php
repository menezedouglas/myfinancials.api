<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bank\NewBankRequest;
use App\Http\Requests\Bank\UpdateBankRequest;
use App\Http\Requests\Transaction\NewTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Http\Resources\DefaultResource;
use App\Services\TransactionService;
use Throwable;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * @return DefaultResource
     * @throws Exception
     */
    public function index(): DefaultResource
    {
        try {
            return new DefaultResource(
                $this->transactionService->all()
            );
        } catch (Throwable $exception) {
            throw new Exception($exception);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewTransactionRequest $request
     * @return DefaultResource
     * @throws Exception
     */
    public function store(NewTransactionRequest $request): DefaultResource
    {
        try {
            $this->transactionService->create(
                $request->input('bank_id'),
                $request->input('payer_id'),
                $request->input('type'),
                $request->input('amount'),
                $request->input('description')
            );

            return new DefaultResource([]);
        } catch (Throwable $exception) {
            throw new Exception($exception);
        }
    }

    /**
     * @param int $id
     * @return DefaultResource
     * @throws Exception
     */
    public function show(int $id): DefaultResource
    {
        try {
            return new DefaultResource(
                $this->transactionService->show($id)
            );
        } catch (Throwable $exception) {
            throw new Exception($exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTransactionRequest $request
     * @param int $id
     * @return DefaultResource
     * @throws Exception
     */
    public function update(UpdateTransactionRequest $request, int $id): DefaultResource
    {
        try {
            $this->transactionService->update(
                $id,
                $request->input('bank_id'),
                $request->input('payer_id'),
                $request->input('type'),
                $request->input('amount'),
                $request->input('description')
            );

            return new DefaultResource([]);
        } catch (Throwable $exception) {
            throw new Exception($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return DefaultResource
     * @throws Exception
     */
    public function destroy(int $id): DefaultResource
    {
        try {
            $this->transactionService->delete($id);
            return new DefaultResource([]);
        } catch (Throwable $exception) {
            throw new Exception($exception);
        }
    }
}
