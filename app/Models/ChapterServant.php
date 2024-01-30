<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChapterServant extends Model
{
    use HasFactory, HasRelationships;

    protected $fillable = [
        'user_id',
        'area_servant_id',
    ];

    public function unit_servants(): HasMany
    {
        return $this->hasMany(UnitServant::class);
    }

    public function area_servant(): BelongsTo
    {
        return $this->belongsTo(AreaServant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
