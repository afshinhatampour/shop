<?php

namespace App\Repositories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;

class PermissionRepository extends BaseRepository
{
    public function __construct(protected Permission $permission = new Permission())
    {
        parent::__construct($this->permission);
    }
}
