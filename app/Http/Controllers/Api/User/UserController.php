<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\User\UserHelper;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\User\DetailResource;

class UserController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new UserHelper();
    }

    /**
     * Mengambil data user dilengkapi dengan pagination
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function index(Request $request)
    {
        $filter = [
            'nama' => $request->nama ?? '',
            'email' => $request->email ?? '',
        ];
        $users = $this->user->getAll($filter, 5, $request->sort ?? '');

        return response()->success(new UserCollection($users));
    }

    /**
     * Membuat data user baru & disimpan ke tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function store(CreateRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/User/CreateRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $dataInput = $request->only(['email', 'nama', 'password', 'foto']);
        $dataUser = $this->user->create($dataInput);
        
        if (!$dataUser['status']) {
            return response()->failed($dataUser['error']);
        }

        return response()->success(new UserResource($dataUser['data']), 'Data user berhasil disimpan');
    }

    /**
     * Menampilkan user secara spesifik dari tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function show($id)
    {
        $dataUser = $this->user->getById($id);

        if (empty($dataUser)) {
            return response()->failed(['Data user tidak ditemukan']);
        }

        return response()->success(new DetailResource($dataUser));
    }

    /**
     * Mengubah data user di tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function update(UpdateRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/User/UpdateRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $dataInput = $request->only(['email', 'nama', 'password', 'id', 'foto']);
        $dataUser = $this->user->update($dataInput, $dataInput['id']);

        if (!$dataUser['status']) {
            return response()->failed($dataUser['error']);
        }

        return response()->success(new UserResource($dataUser['data']), 'Data user berhasil disimpan');
    }

    /**
     * Soft delete data user
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function destroy($id)
    {
        $dataUser = $this->user->delete($id);

        if (!$dataUser) {
            return response()->failed(['Mohon maaf data pengguna tidak ditemukan']);
        }

        return response()->success($dataUser, 'Data user telah dihapus');
    }
}
