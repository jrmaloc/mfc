<?php

namespace App\Models;

use App\Models\HouseholdServant;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    protected $table = 'members';

    public static array $status = ['Inactive', 'Active'];
    public static array $area = ['North', 'Central', 'South', 'East'];

    public static array $chapter = ['Chapter 1', 'Chapter 2', 'Chapter 3'];

    public static array $gender = ['Brother', 'Sister'];

    use HasFactory, HasRelationships;

    protected $fillable = [
        'user_id',
        'household_servant_id',
    ];

    public function household_servant(): BelongsTo
    {
        return $this->belongsTo(HouseholdServant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Sections::class);
    }
}
