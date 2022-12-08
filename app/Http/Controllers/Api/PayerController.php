<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payer\NewPayerRequest;
use App\Http\Requests\Payer\UpdatePayerRequest;
use App\Http\Resources\DefaultResource;
use App\Services\PayerService;
use Throwable;

class PayerController extends Controller
{
    private $payerService;

    public function __construct(PayerService $payerService)
    {
        $this->payerService = $payerService;
    }

    /**
     * @return DefaultResource
     * @throws Exception
     */
    public function index(): DefaultResource
    {
        try {
            return new DefaultResource(
                $this->payerService->all()
            );
        } catch (Throwable $exception) {
            throw new Exception($exception);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewPayerRequest $request
     * @return DefaultResource
     * @throws Exception
     */
    public function store(NewPayerRequest $request): DefaultResource
    {
        try {
            $this->payerService->create(
                $request->input('name'),
                $request->input('email')
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
                $this->payerService->show($id)
            );
        } catch (Throwable $exception) {
            throw new Exception($exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePayerRequest $request
     * @param int $id
     * @return DefaultResource
     * @throws Exception
     */
    public function update(UpdatePayerRequest $request, int $id): DefaultResource
    {
        try {
            $this->payerService->update(
                $id,
                $request->input('name'),
                $request->input('email')
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
            $this->payerService->delete($id);
            return new DefaultResource([]);
        } catch (Throwable $exception) {
            throw new Exception($exception);
        }
    }
}
