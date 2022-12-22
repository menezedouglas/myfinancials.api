<?php

namespace App\Services;

use App\Exceptions\Bank\BankNotFoundException;
use App\Models\Bank;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class BankService extends AbstractService
{
    public function all(): Collection
    {
        return $this->getAuthenticatedUser()->banks()->get();
    }

    /**
     * @param int $id
     * @return Collection|Model|HasMany|HasMany[]
     * @throws BankNotFoundException
     */
    public function show(int $id)
    {
        $bank = $this->getAuthenticatedUser()
            ->banks()
            ->with([
                'transactions:id,bank_id,payer_id,description,type,currency,amount',
                'transactions.payer:id,name'
            ])
            ->find($id);

        if(!$bank)
            throw new BankNotFoundException();

        return $bank;
    }

    /**
     * @param string $name
     * @param string|null $pix
     * @return Bank|Model
     */
    public function create(string $name, ?string $pix = null): Bank
    {
        $bank = new Bank();

        $bank->name = $name;
        $bank->pix = $pix;

        $bank->user()->associate($this->getAuthenticatedUser());

        $bank->save();

        return $bank;
    }

    /**
     * @param int $id
     * @param string|null $name
     * @param string|null $pix
     * @return void
     * @throws BankNotFoundException
     */
    public function update(int $id, ?string $name = null, ?string $pix = null)
    {
        /**
         * @var Bank|null $bank
         */
        if(!$bank = $this->getAuthenticatedUser()->banks()->find($id))
            throw new BankNotFoundException();

        if($name)
            $bank->name = $name;

        if($pix)
            $bank->pix = $pix;

        $bank->save();
    }

    /**
     * @param int $id
     * @return void
     * @throws BankNotFoundException
     */
    public function delete(int $id)
    {
        /**
         * @var Bank|null $bank
         */
        if(!$bank = $this->getAuthenticatedUser()->banks()->find($id))
            throw new BankNotFoundException();

        $bank->transactions()->delete();
        $bank->delete();
    }
}
