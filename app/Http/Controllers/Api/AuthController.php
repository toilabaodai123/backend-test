<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Contracts\AuthSwaggerInterface;
use App\Contracts\AuthHelperInterface;
use App\Contracts\AuthServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Traits\CheckErrorCode;

class AuthController extends Controller implements AuthSwaggerInterface
{
    use CheckErrorCode;

    private $authHelper;
    private $authService;

    public function __construct(AuthHelperInterface $authHelper, AuthServiceInterface $authService)
    {
        $this->authHelper = $authHelper;
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $response = [
            'message' => __('auth.login.success'),
            'data' => [],
        ];

        $code = 200;
        
        try {
            $this->authHelper->validateLoginRequest($request);
            
            $response['data']['token'] = $this->authService->login($request);
        } catch (Exception $e) {
            $response['message'] = $e->getTrace();

            $code = $this->checkErrorCode($e->getCode());
        }

        return response()->json($response, $code);
    }


    public function logout(Request $request)
    {
        $response = [
            'message' => __('auth.logout.success'),
            'data' => [],
        ];

        $code = 200;

        try {
            DB::beginTransaction();

            $response['data'] = $this->authService->logout($request);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            
            $response['message'] = $e->getMessage();

            $code = $this->checkErrorCode($e->getCode());
        }

        return response()->json($response, $code);
    }
}
