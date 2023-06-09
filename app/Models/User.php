<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ACCESS_METHODS_CACHE_PREFIX = 'user_access_methods_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return (bool)array_intersect($this->roles->pluck('id')->toArray(),
            Role::superAdminRoleId());
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return (bool)array_intersect($this->roles->pluck('id')->toArray(),
            Role::adminRolesId());
    }

    /**
     * @return bool
     */
    public function isStaff(): bool
    {
        return (bool)array_intersect($this->roles->pluck('id')->toArray(),
            Role::staffRolesId());
    }


    /**
     * @param int $userId
     * @return Collection
     */
    public static function userRolesAndPermissionsById(int $userId): Collection
    {
        return User::find($userId)->roles()->with('permissions')->get();
    }

    /**
     * @return Collection
     */
    public function authUserRolesAndPermissions(): Collection
    {
        return self::userRolesAndPermissionsById(auth()->user()->id);
    }

    /**
     * @return array
     */
    public function userAccessMethodsList(): array
    {
        if (Cache::has(self::ACCESS_METHODS_CACHE_PREFIX . auth()->user()->id)) {
            return Cache::get(self::ACCESS_METHODS_CACHE_PREFIX . auth()->user()->id);
        } else {
            foreach ($this->authUserRolesAndPermissions() as $roleWithPermissions) {
                foreach ($roleWithPermissions->permissions as $permission) {
                    $userAccessMethodsList[] = [
                        'method'     => $permission->method,
                        'controller' => $permission->controller
                    ];
                };
            }
            Cache::set(self::ACCESS_METHODS_CACHE_PREFIX . auth()->user()->id,
                $userAccessMethodsList ?? []);
            return $userAccessMethodsList;
        }
    }
}
