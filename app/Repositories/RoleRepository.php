<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class RoleRepository extends BaseRepository
{
    public function __construct(protected  Role $role = new Role())
    {
        parent::__construct($this->role);
    }
}
