namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get user information
     * 
     * @OA\Post(
     *      path="/api/user/info",
     *      tags={"User"},
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error",
     *          @OA\JsonContent()
     *      )
     * )
     * @param Request $request
     */
    public function showUserInfo(Request $request)
    {
        return response()->json([
            'message' => "",
            'data' => [
                'data' => $request->user()
            ]
        ], 200);
    }
}
