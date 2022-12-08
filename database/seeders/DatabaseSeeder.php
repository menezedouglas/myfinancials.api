<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Payer;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory()->count(3)->create();

         User::all()->map(function (User $user) {

             /**
              * @var Bank $bank
              */
             $banks = Bank::factory()->count(rand(2,5))->make();

             $banks->map(function (Bank $bank) use ($user) {
                 $bank->user()->associate($user);
                 $bank->save();
             });

             Payer::factory()->count(3)->create([
                 'user_id' => $user->id
             ]);

             $banks->map(function (Bank $bank) use ($user) {
                 Transaction::factory()->count(20)->make()->map(function (Transaction $transaction) use ($bank, $user) {
                     $transaction->user()->associate($user);
                     $transaction->bank()->associate($bank);
                     $transaction->payer()->associate($user->payers()->inRandomOrder()->first());
                     $transaction->save();
                 });
             });

         });

    }
}
