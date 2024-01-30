<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitServant extends Model
{
    protected $table = 'unit_servants';
    use HasFactory, HasRelationships;
    protected $fillable = [
        'user_id',
        'chapter_servant_id',
    ];

    public function household_servants(): HasMany
    {
        return $this->hasMany(HouseholdServant::class);
    }

    public function chapter_servant(): BelongsTo
    {
        return $this->belongsTo(ChapterServant::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
