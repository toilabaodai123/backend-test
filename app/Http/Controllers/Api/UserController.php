<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\UserSwaggerInterface;
use App\Contracts\UserHelperInterface;
use App\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class UserController extends Controller implements UserSwaggerInterface
{
    private $userHelper;
    private $userService;

    public function __construct(UserHelperInterface $userHelper, UserServiceInterface $userService)
    {
        $this->userHelper = $userHelper;
        $this->userService = $userService;
    }

    public function store(Request $request)
    {
        $response = [
            'message' => __('user.create.success'),
            'data' => [],
        ];

        $code = 200;

        try {
            DB::beginTransaction();

            $this->userHelper->validateStoreRequest($request);

            $response['data']['token'] = $this->userService->store($request);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $e->getCode();
        }

        return response()->json($response, $code);
    }
}
