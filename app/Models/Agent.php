<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customerTransactions(): HasMany
    {
        return $this->hasMany(CustomerTransaction::class);
    }

    public function validatedCustomerTransaction(): HasMany
    {
        return $this->hasMany(CustomerTransaction::class)->where('validated', '=', '1');
    }

    public function customers(): HasMany {
        return $this->hasMany(Customer::class);
    }
}
