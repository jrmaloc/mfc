<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Permission;

class ModelHasPermissions extends Model
{
    use HasFactory;

    protected $table = 'model_has_permissions';

    protected $fillable = [
        'model_type',
        'model_id',
        'permission_id',
    ];

    public function permission():BelongsToMany{
        return $this->belongsToMany(Permission::class);
    }
}
