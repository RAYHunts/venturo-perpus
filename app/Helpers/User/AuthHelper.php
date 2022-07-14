<?php

namespace App\Helpers\User;

use App\Http\Resources\User\UserResource;
use App\Models\User\UserModel;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Helper khusus untuk authentifikasi pengguna
 *
 * @author Wahyu Agung <wahyuagung26@gmail.com>
 */
class AuthHelper extends UserModel
{
    /**
     * Proses validasi email dan password
     * jika terdaftar pada database dilanjutkan generate token JWT
     *
     * @param  string $email
     * @param  string $password
     *
     * @return void
     */
    public static function login($email, $password)
    {
        try {
            $credentials = ['email' => $email, 'password' => $password];
            if (!$token = JWTAuth::attempt($credentials)) {
                return [
                    'status' => false,
                    'error' => ['Kombinasi email dan password yang kamu masukkan salah']
                ];
            }
        } catch (JWTException $e) {
            return [
                'status' => false,
                'error' => ['Could not create token.']
            ];        
        }
        
        return [
            'status' => true,
            'data' => self::createNewToken($token)
        ];
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected static function createNewToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => new UserResource(auth()->user())
        ];
    }
}
