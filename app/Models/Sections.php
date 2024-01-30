<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sections extends Model
{
    use HasFactory, HasRelationships;

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
