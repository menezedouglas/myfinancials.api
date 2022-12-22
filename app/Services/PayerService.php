<?php

namespace App\Services;

use App\Exceptions\Payer\PayerNotFoundException;
use App\Models\Payer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PayerService extends AbstractService
{

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->getAuthenticatedUser()
            ->payers()
            ->select(['id', 'name', 'email'])
            ->get();
    }

    /**
     * @param int $id
     * @return Collection|Model|HasMany|HasMany[]
     * @throws PayerNotFoundException
     */
    public function show(int $id)
    {
        $payer = $this->getAuthenticatedUser()
            ->payers()
            ->with([
                'transactions:id,bank_id,payer_id,description,type,currency,amount',
                'transactions.bank:id,name'
            ])
            ->select(['id', 'name', 'email'])
            ->find($id);

        if(!$payer)
            throw new PayerNotFoundException();

        return $payer;
    }

    /**
     * @param string $name
     * @param string $email
     * @return void
     */
    public function create(string $name, string $email)
    {
        $payer = new Payer();

        $payer->name = $name;
        $payer->email = $email;

        $payer->user()->associate($this->getAuthenticatedUser());

        $payer->save();
    }

    /**
     * @param int $id
     * @param string|null $name
     * @param string|null $email
     * @return void
     * @throws PayerNotFoundException
     */
    public function update(int $id, ?string $name = null, ?string $email = null)
    {
        /**
         * @var Payer|null $payer
         */
        $payer = $this->getAuthenticatedUser()
            ->payers()
            ->find($id);

        if(!$payer)
            throw new PayerNotFoundException();

        if($name)
            $payer->name = $name;

        if($email)
            $payer->email = $email;

        $payer->save();
    }

    /**
     * @param int $id
     * @return void
     * @throws PayerNotFoundException
     */
    public function delete(int $id)
    {
        /**
         * @var Payer|null $payer
         */
        $payer = $this->getAuthenticatedUser()
            ->payers()
            ->find($id);

        if(!$payer)
            throw new PayerNotFoundException();

        $payer->delete();
    }

}
