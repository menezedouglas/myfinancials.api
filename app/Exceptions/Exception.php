<?php

namespace App\Exceptions;

use Exception as BaseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Throwable;

class Exception extends BaseException
{

    public function __construct(?Throwable $previous = null, string $message = "", int $code = 0)
    {
        DB::rollBack();
        parent::__construct(Lang::get($this->message), $this->code, $previous);
    }

    /**
     * Define if this exception is reportable
     *
     * @return bool
     */
    private function reportable(): bool
    {
        foreach (config('exceptions.reportable') as $class) {
            if($this instanceof $class)
                return true;

            if($this->getPrevious() instanceof $class)
                return true;
        }

        return false;
    }

    /**
     * Generate JSON Response
     *
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    private function response (string $message, int $status): JsonResponse
    {
        return response()->json([
            'message' => $message
        ], $status);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        if($this->reportable()) {
            return $this->response(
                $this->getMessage() <> "" ?  $this->getMessage() : $this->getPrevious()->getMessage(),
                !!$this->getCode() ? $this->getCode() : $this->getPrevious()->getCode()
            );
        }

        $defaultException = new DefaultException();

        return $this->response(
            Lang::get($defaultException->getMessage()),
            $defaultException->getCode()
        );
    }

}
