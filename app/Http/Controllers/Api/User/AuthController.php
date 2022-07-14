<?php
namespace App\Http\Controllers\Api\User;

use App\Helpers\User\AuthHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AuthRequest;
use App\Http\Resources\User\UserResource;

class AuthController extends Controller
{
    
    /**
     * Method untuk handle proses login & generate token JWT
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     *
     * @return void
     */
    public function login(AuthRequest $request)
    {
         /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/User/UpdateRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors(), 422);
        }
        
        $credentials = $request->only('email', 'password');
        $login = AuthHelper::login($credentials['email'], $credentials['password']);
        
        if(!$login['status']) {
            return response()->failed($login['error'], 422);
        }

        return response()->success($login['data']);
    }
   
    /**
     * Method untuk handle proses logout dan menghapus token JWT
     * 
     * @author Wahyu Agung <wahyuagung26@email.com>
     *
     * @return void
     */
    public function logout()
    {
        auth()->logout();
        return response()->success();
    }

    /**
     * Generate token baru untuk disimpan pada frontend 
     * dan digunakan pada request selanjutnya, karena token JWT memiliki masa aktif
     *
     * @return void
     */
    public function refresh()
    {
        return response()->success(auth()->user());
    }

     /**
     * Mengambil profile user yang sedang login
     *
     * @return void
     */
    public function profile()
    {
        return response()->success(new UserResource(auth()->user()));
    }

     /**
     * Generate token 
     *
     * @return void
     */
    public function csrf()
    {
        return response()->success(csrf_token());
    }
}


