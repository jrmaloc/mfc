<?php

namespace App\Models;

use App\Models\Tithe;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasRelationships, CanResetPassword;

    protected $table = 'users';

    public static array $status = ['Inactive', 'Active'];
    public static array $area = ['North', 'Central', 'South', 'East'];

    public static array $chapter = ['Chapter 1', 'Chapter 2', 'Chapter 3'];

    public static array $gender = ['Brother', 'Sister'];

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array<int, string>
    //  */
    protected $fillable = [
        'name',
        'email',
        'username',
        'contact_number',
        'area',
        'chapter',
        'gender',
        'password',
        'status',
        'user_id',
        'section_id',
        'role_id',
        'bio',
        'avatar',
    ];

    // /**
    //  * The attributes that should be hidden for serialization.
    //  *
    //  * @var array<int, string>
    //  */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // /**
    //  * The attributes that should be cast.
    //  *
    //  * @var array<string, string>
    //  */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function member(): HasOne
    {
        return $this->hasOne(Member::class, 'user_id');
    }

    public function household_servant(): HasOne
    {
        return $this->hasOne(HouseholdServant::class, 'user_id');
    }

    public function unit_servant(): HasOne
    {
        return $this->hasOne(UnitServant::class, 'user_id');
    }

    public function chapter_servant(): HasOne
    {
        return $this->hasOne(ChapterServant::class, 'user_id');
    }

    public function area_servant(): HasOne
    {
        return $this->hasOne(AreaServant::class, 'user_id');
    }
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'registrations')
            ->withPivot('name', 'email', 'contact_number', 'area', 'chapter', 'paid');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Activity::class, 'user_ids');
    }

    public function tithes(): HasMany
    {
        return $this->hasMany(Tithe::class);
    }

    public function isAdmin()
    {
        // Logic to check if the user has the admin role
        return $this->role === 'Admin'; // Replace 'role' with your actual column name for roles
    }

    public function isSuperAdmin()
    {
        // Logic to check if the user has the super admin role
        return $this->role === 'Super Admin'; // Replace 'role' with your actual column name for roles
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'model_has_permissions', 'model_id');
    }
}
