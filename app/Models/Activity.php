<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class Activity extends Model
{
    use Notifiable;
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'recurring',
        'daysOfWeek',
        'location',
        'description',
        'reg_fee',
        'user_ids',
        'role_ids',
    ];

    use HasFactory, HasRelationships, HasRoles;

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function members(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendance(): HasOne
    {
        return $this->hasOne(Attendance::class);
    }
}
