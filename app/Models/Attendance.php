<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory, HasRelationships;

    protected $fillable = [
        'activity_id',
        'attendee_ids',
    ];


    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
}
