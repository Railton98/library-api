<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class JWTController extends Controller
{
    /**
     * @var JWTAuth
     */
    private $jwtAuth;

    public function __construct(JWTAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            $token = $this->jwtAuth->attempt($credentials);

            if (!$token) {
            return response()->json([
                'error' => 'invalid_credentials'
            ], Response::HTTP_UNAUTHORIZED); //Status code: 401
            }
        }
        catch (JWTException $e) {
            return response()->json([
                'error' => 'could_not_create_token'
            ], Response::HTTP_INTERNAL_SERVER_ERROR); //Status code: 500
        }

        $user = $this->jwtAuth->authenticate($token);

        return response()->json(compact('token', 'user'));
    }

    public function refresh()
    {
        try {
            $token = $this->jwtAuth->getToken();

            $newToken = $this->jwtAuth->refresh($token);

            return response()->json(compact('newToken'));
        } catch (JWTException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getStatusCode());
        }
    }

    public function logout()
    {
        try {
            $token = $this->jwtAuth->getToken();

            $this->jwtAuth->invalidate($token);

            return response()->json(['logout_successfully']);
        } catch (JWTException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getStatusCode());
        }
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return $this->login($request);
    }

    public function me()
    {
        $user = $this->jwtAuth->parseToken()->authenticate();

        if (!$user) {
            return response()->json([
                'error' => 'user_not_found'
            ], Response::HTTP_NOT_FOUND); // Status code 404
        }

        return response()->json(compact('user'));
    }
}
