<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HouseholdServant extends Model
{
    protected $fillable = [
        'user_id',
        'unit_servant_id',
    ];

    use HasFactory, HasRelationships;

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function unit_servant(): BelongsTo
    {
        return $this->belongsTo(UnitServant::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}