<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use PHPUnit\Framework\Constraint\IsEmpty;
use function PHPUnit\Framework\isEmpty;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
}
