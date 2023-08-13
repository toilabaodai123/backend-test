<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findWithEmail(string $email);
}
