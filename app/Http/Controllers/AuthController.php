<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

use App\Models\User_t;

class AuthController extends Controller
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }


    /**
 * @OA\Post(
 *     path="/v1/register",
 *     summary="Sign up a user",
 *     operationId="registerUser",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", format="email"),
 *             @OA\Property(property="password", type="string"),
 *             @OA\Property(property="first_name", type="string"),
 *             @OA\Property(property="last_name", type="string"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful response"
 *     ),
 *     @OA\Header(
 *         header="Authorization",
 *         description="Bearer {access_token}",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     )
 * )
 */

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:user_t,email',
            'password' => 'required|min:6',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }else{
            $user = new User_t();
            $user->id         = Str::uuid(); // Generate a UUID
            $user->email      = $request->email;
            $user->password   = bcrypt($request->password);
            $user->first_name = $request->first_name;
            $user->last_name  = $request->last_name;

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Successfully Registered'
            ], 200);
        }
    }

    protected function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
 * @OA\Post(
 *     path="/v1/login",
 *     summary="Get access & refresh token",
 *     operationId="loginUser",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", format="email"),
 *             @OA\Property(property="password", type="string"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful response"
 *     ),
 *     @OA\Header(
 *         header="Authorization",
 *         description="Bearer {access_token}",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     )
 * )
 */

    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->respondWithToken($token);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Successfully logged in'
        // ], 200);
    }

    /**
 * @OA\Post(
 *     path="/v1/token/refresh",
 *     summary="Get new access token",
 *     operationId="refreshToken",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="refresh_token", type="string"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful response"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Header(
 *         header="Authorization",
 *         description="Bearer {access_token}",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     )
 * )
 */


    public function refresh(){
        return $this->respondWithToken(auth()->refresh());
    }

    /**
 * @OA\Post(
 *     path="/v1/logout",
 *     summary="Invalidate refresh token",
 *     operationId="logoutUser",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="refresh_token", type="string"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful response"
 *     ),
 *     @OA\Header(
 *         header="Authorization",
 *         description="Bearer {access_token}",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     )
 * )
 */


    public function logout(){
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me(){
        return response()->json(auth()->user());
    }
}
