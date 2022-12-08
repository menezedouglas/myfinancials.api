<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Transaction
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property int $bank_id
 * @property int $payer_id
 * @property string $description
 * @property string $type
 * @property string $currency
 * @property float $amount
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property User $user
 * @property Bank $bank
 * @property Payer $payer
 */
class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_DEBT = 'debt';

    const TYPE_CREDIT = 'credit';

    protected $table = 'transactions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'bank_id',
        'payer_id',
        'description',
        'type',
        'currency',
        'amount'
    ];

    protected $casts = [
        'amount' => MoneyCast::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function payer(): BelongsTo
    {
        return $this->belongsTo(Payer::class);
    }
}
