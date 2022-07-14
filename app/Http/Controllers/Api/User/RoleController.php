<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\User\RoleHelper;
use App\Http\Requests\Role\RoleRequest;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Role\RoleCollection;

class RoleController extends Controller
{
    private $role;

    public function __construct()
    {
        $this->role = new RoleHelper();
    }

    /**
     * Mengambil data hak akses dilengkapi dengan pagination
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function index(Request $request)
    {
        $filter = ['nama' => $request->nama ?? ''];
        $roles = $this->role->getAll($filter, 5, $request->sort ?? '');

        return response()->success(new RoleCollection($roles));
    }

    /**
     * Membuat data hak akses baru & disimpan ke tabel m_role
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function store(RoleRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/Role/RoleRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors(), 422);
        }
        
        $dataInput = $request->only(['nama', 'akses']);
        $dataRole = $this->role->create($dataInput);
        
        if(!$dataRole['status']) {
            return response()->failed($dataRole['error'], 422);
        }

        return response()->success(new RoleResource($dataRole['data']), 'Data hak akses berhasil disimpan');
    }

    /**
     * Menampilkan hak akses secara spesifik dari tabel m_role
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function show($id)
    {
        $dataRole = $this->role->getById($id);

        if(empty($dataRole)) {
            return response()->failed(['Data hak akses tidak ditemukan']);
        }

        return response()->success(new RoleResource($dataRole));
    }

    /**
     * Mengubah data hak akses di tabel m_role
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function update(RoleRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/Role/RoleRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $dataInput = $request->only(['nama', 'akses', 'id']);
        $dataRole = $this->role->update($dataInput, $dataInput['id']);
        
        if(!$dataRole['status']) {
            return response()->failed($dataRole['error']);
        }

        return response()->success(new RoleResource($dataRole['data']), 'Data hak akses berhasil disimpan');
    }

    /**
     * Soft delete data hak akses
     * 
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function destroy($id)
    {
        $dataRole = $this->role->delete($id);

        if(!$dataRole){
            return response()->failed(['Mohon maaf data hak akses tidak ditemukan']);
        }

        return response()->success($dataRole);
    }
}
