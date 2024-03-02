<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }


    /**
     * Get the token array structure.
     *
     * @param string $token
     * @param int|null $expirationTime
     * @return JsonResponse
     */
    protected function respondWithToken(string $token, int $expirationTime = null): JsonResponse
    {
        // Set the default expiration time if not provided
        $expirationTime = $expirationTime ?? auth()->factory()->getTTL() * 60;

        return $this->me()
            ->header('Authorization', 'Bearer ' . $token)
            ->withHeaders(['expires_in' => $expirationTime]);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);

    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        $response = [
            'user_id' => auth()->id(),
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ];
        return response()->json($response);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

}
