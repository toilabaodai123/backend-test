<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface {
    
    public function __construct(User $user)
    {
        $this->setModel($user);
    }

    public function findWithEmail(string $email)
    {
        return $this->model->where('email',$email)->first();
    }
}