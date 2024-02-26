<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tithe extends Model
{
    protected $fillable = [
        'transaction_id',
        'amount',
        'user_id',
        'receipt_number',
    ];

    use HasFactory;

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
