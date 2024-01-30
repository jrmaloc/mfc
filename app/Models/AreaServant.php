<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AreaServant extends Model
{
    protected $table = 'area_servants';

    protected $fillable = [
        'user_id',
    ];

    use HasFactory, HasRelationships;

    public function chapter_servants(): HasMany
    {
        return $this->hasMany(ChapterServant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
