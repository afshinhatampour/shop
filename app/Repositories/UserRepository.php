<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository
{
    public function __construct(protected User $user = new User())
    {
        parent::__construct($this->user);
    }
}
