<?php

namespace App\Models;

use App\Enums\RoleEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status'
    ];

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return HasMany
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }

    /**
     * @return string[]
     */
    public static function superAdminRoleId(): array
    {
        return Role::whereIn('name', RoleEnums::ADMIN_ROLES_NAME['SUPER_ADMIN'])
            ->get()->pluck('id')->toArray();
    }

    /**
     * @return string[]
     */
    public static function adminRolesId(): array
    {
        return Role::whereIn('name', array_values(RoleEnums::ADMIN_ROLES_NAME))
            ->get()->pluck('id')->toArray();
    }

    /**
     * @return string[]
     */
    public static function staffRolesId(): array
    {
        return Role::whereIn('name', array_values(RoleEnums::STAFF_ROLES_NAME))
            ->get()->pluck('id')->toArray();
    }

    /**
     * @return string[]
     */
    public function thirdPartiesId(): array
    {
        return Role::whereId('name', array_values(RoleEnums::THIRD_PARTY_ROLES_NAME))
            ->get()->pluck('id')->toArray();
    }
}
