<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Contracts\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function store(Request $request)
    {
        $response = null;

        $userStoreData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        $user = $this->userRepository->create($userStoreData);

        $response = $user->createToken("API TOKEN")->plainTextToken;

        return $response;
    }

    public function show(int $id,Request $request){}
    public function index(Request $request){}
    public function update(int $id,Request $request){}
    public function delete(int $id,Request $request){}  
}
