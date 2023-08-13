<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface {
    
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function findWithEmail(string $email)
    {
        return $this->model->where('email',$email)->first();
    }
}