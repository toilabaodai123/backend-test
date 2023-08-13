<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use App\Contracts\UserRepositoryInterface;

class AuthService implements AuthServiceInterface{

    /**
     * @var undefined
     */
    private $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * 
     * @return void
     */
    public function login(Request $request)
    {
        $response = null;

        if (!Auth::attempt($request->only(['email', 'password']))) {
            throw new Exception(__('auth.wrong_credential'),401);
        }

        $user = $this->userRepository->findWithEmail($request->email);

        $response = $user->createToken("API TOKEN")->plainTextToken;

        return $response;
    }

    /**
     * @param Request $request
     * 
     * @return void
     */
    public function logout(Request $request)
    {
        $response = null;

        $request->user()->currentAccessToken()->delete();

        return $response;
    }    
}