<?php

namespace App\Helpers\Master;

use App\Models\Master\ItemModel;
use App\Repository\CrudInterface;

/**
 * Helper untuk manajemen item / menu / produk
 * Mengambil data, menambah, mengubah, & menghapus ke tabel m_item
 *
 * @author Wahyu Agung <wahyuagung26@gmail.com>
 */
class ItemHelper implements CrudInterface
{
    protected $itemModel;

    public function __construct()
    {
        $this->itemModel = new ItemModel();
    }

    /**
     * Mengambil data item dari tabel m_item
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
        return $this->itemModel->getAll($filter, $itemPerPage, $sort);
    }

    /**
     * Mengambil 1 data item dari tabel m_item
     *
     * @param  integer $id id dari tabel m_item
     * @return object
     */
    public function getById(int $id): object
    {
        return $this->itemModel->getById(($id));
    }

    /**
     * method untuk menginput data baru ke tabel m_item
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     *
     * @param array $payload
     * $payload['nama'] = string
     * $payload['email] = string
     * $payload['is_verified] = string
     *
     * @return void
     */
    public function create(array $payload): array
    {
        try {
            // Hapus detail dari payload karena tabel m_item tidak memiliki kolom "detail"
            $detailItem = $payload['detail'] ?? [];
            unset($payload['detail']);

            $newItem = $this->itemModel->store($payload);
            
            // Simpan detail item
            if (!empty($detailItem)) {
                $detail = new ItemDetHelper($newItem);
                $detail->create($detailItem);
            }

            return [
                'status' => true,
                'data' => $newItem
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    /**
     * method untuk mengubah item pada tabel m_item
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
            // Hapus detail dari payload karena tabel m_item tidak memiliki kolom "detail"
            $detailItem = $payload['detail'] ?? [];
            unset($payload['detail']);
        
            $updateItem = $this->itemModel->edit($payload, $id);
            $dataItem = $this->getById($updateItem);

            // Simpan detail item
            if (!empty($detailItem)) {
                $detail = new ItemDetHelper($dataItem);
                $detail->update($detailItem);
            }

            return [
                'status' => true,
                'data' => $dataItem
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    /**
     * Menghapus data item dengan sistem "Soft Delete"
     * yaitu mengisi kolom deleted_at agar data tsb tidak
     * keselect waktu menggunakan Query
     *
     * @param  integer $id id dari tabel m_item
     * 
     * @return bool
     */
    public function delete(int $id): bool
    {
        try {
            $this->itemModel->drop($id);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
