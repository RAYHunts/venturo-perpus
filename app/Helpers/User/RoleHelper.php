<?php

namespace App\Helpers\User;

use App\Models\User\RoleModel;
use App\Repository\CrudInterface;
use Illuminate\Support\Facades\Cache;

/**
 * Helper untuk manajemen hak akses
 * Mengambil data, menambah, mengubah, & menghapus ke tabel user_roles
 *
 * @author Wahyu Agung <wahyuagung26@gmail.com>
 */
class RoleHelper implements CrudInterface
{
    private $role;

    public function __construct()
    {
        $this->role = new RoleModel();
    }

    /**
     * Mengambil data hak akses dari tabel user_roles & Test sistem caching menggunakan redis 
     *          
     * Dengan cara ini request ke database akan dilewati jika cache dengan key 'listRole'
     * telah terdaftar pada redis, namun jika tidak terdaftar maka sistem akan mengambil data
     * di database lalu disimpan ke dalam cache redis dengan key 'listRole'
     * 
     * Tujuan menggunakan cara ini adalah : 
     * - Kinerja server akan lebih ringan karena tidak perlu membuka koneksi ke database
     * - Cocok digunakan untuk data master yang jarang berubah
     * - Cocok digunakan pada endpoint dengan trafik tinggi
     * - TIDAK DISARANKAN untuk proses yang membutuhkan data real time dari database
     * 
     * Jika ingin mengubah sistem cache dari "Redis" ke "File" maka :
     * - Ganti kode "Cache::store('redis')->has('listRole')" dengan "Cache::has('listRole')"
     * 
     * Secara otomatis laravel akan generate file cache pada folder "storage/framwork/cache/"
     *
     * @author Wahyu Agung <wahyuagung26@gmail.com>
     *
     * @param  array $filter
     * $filter['nama'] = string
     * $filter['email'] = string
     * @param integer $itemPerPage jumlah data yang tampil dalam 1 halaman, kosongi jika ingin menampilkan semua data
     * @param string $sort nama kolom untuk melakukan sorting mysql beserta tipenya DESC / ASC
     *
     * @return object
     */
    public function getAll(array $filter, int $itemPerPage = 0, string $sort = ''): object
    {
        // Cek apakah data sudah terdaftar di cache, jika sudah maka ambil dari cache redis
        // if (Cache::store('redis')->has('listRole')) {
        //     return Cache::store('redis')->get('listRole');
        // }

        $return = $this->role->getAll($filter, $itemPerPage, $sort);

        // Simpan object hasil query ke dalam cache redis selama 10 menit (600 detik)
        // Cache::store('redis')->put('listRole', $return, 600);
        return $return;
    }

    /**
     * Mengambil 1 data hak akses dari tabel user_roles
     *
     * @param  integer $id id dari tabel user_roles
     * 
     * @return object
     */
    public function getById(int $id): object
    {
        return $this->role->getById($id);
    }

    /**
     * method untuk menginput data baru ke tabel user_roles
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     *
     * @param array $payload
     * $payload['nama'] = string
     * $payload['akses] = array
     *
     * @return array
     */
    public function create(array $payload): array
    {
        try {
            $payload['akses'] = json_encode($payload['akses']);
            $roles = $this->role->store($payload);

            /**
             * Hapus cache dari redist agar generate cache yang terbaru ketika ada request dari pengguna
             * Jika tidak ada query select yang masuk ke dalam sistem Cache, maka cara ini TIDAK PERLU dilakukan
             */
            // if (Cache::store('redis')->has('listRole')) {
            //     Cache::store('redis')->forget('listRole');
            // }

            return [
                'status' => true,
                'data' => $roles
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    /**
     * method untuk mengubah hak akses pada tabel user_roles
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     *
     * @param array $payload
     * $payload['nama'] = string
     * $payload['email] = string
     * $payload['password] = string
     *
     * @return array
     */
    public function update(array $payload, int $id): array
    {
        try {
            $payload['akses'] = json_encode($payload['akses']);
            $this->role->edit($payload, $id);

            /**
             * Hapus cache dari redist agar generate cache yang terbaru ketika ada request dari pengguna
             * Jika tidak ada query select yang masuk ke dalam sistem Cache, maka cara ini TIDAK PERLU dilakukan
             */
            // if (Cache::store('redis')->has('listRole')) {
            //     Cache::store('redis')->forget('listRole');
            // }

            return [
                'status' => true,
                'data' => $this->getById($payload['id'])
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    /**
     * Menghapus data hak akses dengan sistem "Soft Delete"
     * yaitu mengisi kolom deleted_at agar data tsb tidak
     * keselect waktu menggunakan Query
     *
     * @param  integer $id id dari tabel user_roles
     * 
     * @return bool
     */
    public function delete(int $id): bool
    {
        try {
            $this->role->drop($id);

            /**
             * Hapus cache dari redist agar generate cache yang terbaru ketika ada request dari pengguna
             * Jika tidak ada query select yang masuk ke dalam sistem Cache, maka cara ini TIDAK PERLU dilakukan
             */
            // if (Cache::store('redis')->has('listRole')) {
            //     Cache::store('redis')->forget('listRole');
            // }

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}