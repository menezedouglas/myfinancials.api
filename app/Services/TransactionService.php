<?php

namespace App\Services;

use App\Exceptions\Bank\BankNotFoundException;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\Payer\PayerNotFoundException;
use App\Exceptions\Transactions\TransactionNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransactionService extends AbstractService
{
    public function all(?string $initDate = null, ?string $endDate = null): Collection
    {
        $query = $this->getAuthenticatedUser()
            ->transactions()
            ->with(['bank:id,name', 'payer:id,name'])
            ->select(['id', 'bank_id', 'payer_id', 'transaction_date', 'description', 'type', 'currency', 'amount']);

        if ($initDate || $endDate) {
            $data = self::validDates($initDate, $endDate);

            $query->where([
                ['transaction_date', '>=', $data['init']],
                ['transaction_date', '<=', $data['end']],
            ]);
        }

        return $query->get();
    }

    /**
     * @param int $transactionId
     * @return Model|HasMany|object
     * @throws TransactionNotFoundException
     */
    public function show(int $transactionId)
    {
        $transaction = $this->getAuthenticatedUser()
            ->transactions()
            ->with(['bank:id,name', 'payer:id,name'])
            ->select(['id', 'bank_id', 'payer_id', 'transaction_date', 'description', 'type', 'currency', 'amount'])
            ->where('id', $transactionId)
            ->first();

        if (!$transaction) {
            throw new TransactionNotFoundException();
        }

        return $transaction;
    }

    /**
     * @param int $bankId
     * @param int $payerId
     * @param string $type
     * @param float $amount
     * @param string $date
     * @param string|null $description
     * @return void
     * @throws BankNotFoundException
     * @throws PayerNotFoundException
     */
    public function create(int $bankId, int $payerId, string $type, float $amount, string $date, ?string $description): void
    {
        $transaction = new Transaction();

        if(!$payer = $this->getAuthenticatedUser()->payers()->find($payerId))
            throw new PayerNotFoundException();

        if(!$bank = $this->getAuthenticatedUser()->banks()->find($bankId))
            throw new BankNotFoundException();

        switch ($type) {
            case 'debt':
                $transaction->type = Transaction::TYPE_DEBT;
                break;
            case 'credit':
                $transaction->type = Transaction::TYPE_CREDIT;
                break;
        }

        $transaction['amount'] = $amount;
        $transaction['description'] = $description;
        $transaction['transaction_date'] = Carbon::parse($date);
        $transaction['currency'] = $bank['currency'];
        $transaction->user()->associate($this->getAuthenticatedUser());
        $transaction->bank()->associate($bank);
        $transaction->payer()->associate($payer);
        $transaction->save();
    }

    /**
     * @param int $transactionId
     * @param int|null $bankId
     * @param int|null $payerId
     * @param string|null $date
     * @param string|null $type
     * @param float|null $amount
     * @param string|null $description
     * @return void
     * @throws BankNotFoundException
     * @throws PayerNotFoundException
     * @throws TransactionNotFoundException
     */
    public function update(int $transactionId, ?int $bankId = null, ?int $payerId = null, ?string $date = null, ?string $type = null, ?float $amount = null, ?string $description = null): void
    {
        /**
         * @var Transaction|null $transaction
         */
        if(!$transaction = $this->getAuthenticatedUser()->transactions()->find($transactionId))
            throw new TransactionNotFoundException();

        if($bankId) {
            if(!$bank = $this->getAuthenticatedUser()->banks()->find($bankId))
                throw new BankNotFoundException();

            $transaction->bank()->associate($bank);
        }

        if($payerId) {
            if(!$payer = $this->getAuthenticatedUser()->payers()->find($payerId))
                throw new PayerNotFoundException();

            $transaction->payer()->associate($payer);
        }

        if($type) {
            switch ($type) {
                case 'debt':
                    $transaction->type = Transaction::TYPE_DEBT;
                    break;
                case 'credit':
                    $transaction->type = Transaction::TYPE_CREDIT;
                    break;
            }
        }

        if($amount)
            $transaction['amount'] = $amount;

        if($description)
            $transaction['description'] = $description;

        if($date)
            $transaction['transaction_date'] = Carbon::parse($date);

        $transaction->save();
    }

    /**
     * @param int $transactionId
     * @return void
     * @throws TransactionNotFoundException
     */
    public function delete(int $transactionId): void
    {
        /**
         * @var Transaction|null $transaction
         */
        if(!$transaction = $this->getAuthenticatedUser()->transactions()->find($transactionId))
            throw new TransactionNotFoundException();

        $transaction->delete();
    }

    public static function validDates(?string $initDate = null, ?string $endDate = null): array
    {
        if (!$initDate && !$endDate) {
            $initDate = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        if (!$initDate && $endDate) {
            $initDate = Carbon::parse($endDate)->startOfMonth()->format('Y-m-d');
        }

        if($initDate && !$endDate) {
            $endDate = Carbon::parse($initDate)->endOfMonth()->format('Y-m-d');
        }

        return ['init' => $initDate, 'end' => $endDate];
    }
}
