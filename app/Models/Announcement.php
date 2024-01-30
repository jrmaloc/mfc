<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory, HasRelationships;

    protected $fillable = [
        'title',
        'description',
        'creator',
        'audience',
        'timestamp',
    ];
}
