<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    public const PERMISSION_INDEX = 'permission-index';
    public const PERMISSION_ASSIGN = 'permission-assign';
    public const PROFILE_INDEX = 'profile-index';
    public const PROFILE_EDIT = 'profile-edit';

    protected $fillable = [
        'name',
        'title',
    ];

    // ---------- Relations ---------- //

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }
}
