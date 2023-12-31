<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\UserSwaggerInterface;
use App\Contracts\UserHelperInterface;
use App\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Traits\CheckErrorCode;

class UserController extends Controller implements UserSwaggerInterface
{
    use CheckErrorCode;
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

            $this->userHelper->validateStoreRequest($request);

            DB::beginTransaction();

            $response['data']['token'] = $this->userService->store($request);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $response['message'] = $e->getMessage();

            $code = $this->checkErrorCode($e->getCode());
        }

        return response()->json($response, $code);
    }
}
