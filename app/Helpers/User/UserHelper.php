<?php

namespace App\Helpers\User;

use App\Models\User\UserModel;
use App\Repository\CrudInterface;
use Illuminate\Support\Facades\Hash;

/**
 * Helper untuk manajemen user
 * Mengambil data, menambah, mengubah, & menghapus ke tabel user_auth
 *
 * @author Wahyu Agung <wahyuagung26@gmail.com>
 */
class UserHelper implements CrudInterface
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Mengambil data user dari tabel user_auth
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
        return $this->userModel->getAll($filter, $itemPerPage, $sort);
    }

    /**
     * Mengambil 1 data user dari tabel user_auth
     *
     * @param  integer $id id dari tabel user_auth
     *
     * @return object
     */
    public function getById(int $id): object
    {
        return $this->userModel->getById($id);
    }

    /**
     * method untuk menginput data baru ke tabel user_auth
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
    public function create(array $payload): array
    {
        try {
            $payload['password'] = Hash::make($payload['password']);
            
            /**
             * Jika dalam payload terdapat base64 foto, maka Upload foto ke folder storage/app/upload/fotoUser
             */
            if (!empty($payload['foto'])) {
                /**
                 * Parameter kedua ("gcs") digunakan untuk upload ke Google Cloud Service
                 * jika mau upload di server local, maka tidak usah pakai parameter kedua
                 */
                $foto = $payload['foto']->store('upload/fotoUser', 'gcs');
                $payload['foto'] = $foto;
            }
            
            $user = $this->userModel->store($payload);
            return [
                'status' => true,
                'data' => $user
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    /**
     * method untuk mengubah user pada tabel user_auth
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
            if (isset($payload['password']) && !empty($payload['password'])) {
                $payload['password'] = Hash::make($payload['password']) ?: '';
            } else {
                unset($payload['password']);
            }
            /**
             * Jika dalam payload terdapat base64 foto, maka Upload foto ke folder storage/app/upload/fotoUser
             */
            if (!empty($payload['foto'])) {
                /**
                 * Parameter kedua ("gcs") digunakan untuk upload ke Google Cloud Service, jika mau upload di server local, maka tidak usah pakai parameter kedua
                 */
                $foto = $payload['foto']->store('upload/fotoUser', 'gcs');
                $payload['foto'] = $foto;
            } else {
                unset($payload['foto']); // Jika foto kosong, hapus dari array agar tidak diupdate
            }

            $this->userModel->edit($payload, $id);
            return [
                'status' => true,
                'data' => $this->getById($id)
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    /**
     * Menghapus data user dengan sistem "Soft Delete"
     * yaitu mengisi kolom deleted_at agar data tsb tidak
     * keselect waktu menggunakan Query
     *
     * @param  integer $id id dari tabel user_auth
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        try {
            $this->userModel->drop($id);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
