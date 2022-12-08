<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bank\NewBankRequest;
use App\Http\Requests\Bank\UpdateBankRequest;
use App\Http\Resources\DefaultResource;
use App\Services\BankService;
use Throwable;

class BankController extends Controller
{
    private $bankService;

    public function __construct(BankService $bankService)
    {
        $this->bankService = $bankService;
    }

    /**
     * @return DefaultResource
     * @throws Exception
     */
    public function index(): DefaultResource
    {
        try {
            return new DefaultResource(
                $this->bankService->all()
            );
        } catch (Throwable $exception) {
            throw new Exception($exception);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewBankRequest $request
     * @return DefaultResource
     * @throws Exception
     */
    public function store(NewBankRequest $request): DefaultResource
    {
        try {
            return new DefaultResource(
                $this->bankService->create(
                    $request->input('name'),
                    $request->input('pix')
                )
            );
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
                $this->bankService->show($id)
            );
        } catch (Throwable $exception) {
            throw new Exception($exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBankRequest $request
     * @param int $id
     * @return DefaultResource
     * @throws Exception
     */
    public function update(UpdateBankRequest $request, int $id): DefaultResource
    {
        try {
            $this->bankService->update(
                $id,
                $request->input('name'),
                $request->input('pix')
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
            $this->bankService->delete($id);
            return new DefaultResource([]);
        } catch (Throwable $exception) {
            throw new Exception($exception);
        }
    }
}
