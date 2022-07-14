<?php

namespace App\Helpers\Master;

use App\Repository\DetailInterface;
use App\Models\Master\ItemModel;
use App\Models\Master\ItemDetModel;

/**
 * Helper untuk manajemen item / menu / produk
 * Mengambil data, menambah, mengubah, & menghapus ke tabel m_item
 *
 * @author Wahyu Agung <wahyuagung26@gmail.com>
 */
class ItemDetHelper implements DetailInterface
{
    private $model;
    private $parent;

    public function __construct(ItemModel $item)
    {
        $this->parent = $item;
        $this->model = new ItemDetModel();
    }

    /**
     * Mempersiapkan data baru untuk diinput ke tabel m_item_det
     *
     * @param  array $detail
     * $detail['id']
     * $detail['m_item_id']
     * $detail['keterangan']
     * $detail['tipe']
     * $detail['harga']
     * @param  int $itemId id dari tabel m_item
     *
     * @return object
     */
    public function prepare(array $detail): array
    {
        $arrDetail = [];
        foreach ($detail as $key => $val) {
            $arrDetail[$key]['id'] = $val['id'] > 0 ? $val['id'] : null;
            $arrDetail[$key]['m_item_id'] = $this->parent->id;
            $arrDetail[$key]['keterangan'] = $val['keterangan'];
            $arrDetail[$key]['tipe'] = $val['tipe'];
            $arrDetail[$key]['harga'] = $val['harga'];
        }

        return $arrDetail;
    }

    /**
     * Fungsi untuk mengambil detail item berdasarkan item id
     *
     * @author Wahyu Agung <email@email.com>
     *
     * @param  int $itemId
     *
     * @return object
     */
    public function getAll(): object
    {
        return $this->model->getAll($this->parent->id);
    }

    /**
     * Fungsi untuk melakukan grouping detail item berdasarkan id tabel m_item_det
     *
     * @author Wahyu Agung <email@email.com>
     *
     * @return array
     */
    public function groupById(): array
    {
        $detailItems = $this->getAll();
        $arrDetail = [];
        foreach ($detailItems as $val) {
            $arrDetail[$val->id] = [
                'id' => $val['id'],
                'm_item_id' => $val['m_item_id'],
                'keterangan' => $val['keterangan'],
                'harga' => $val['harga'],
                'tipe' => $val['tipe']
            ];
        }

        return $arrDetail;
    }

    /**
     * Fungsi untuk mengecek jika ada perubahan data detail
     *
     * @author Wahyu Agung <email@email.com>
     *
     * @param  array $oldDetail
     * $oldDetail['keterangan']
     * $oldDetail['tipe']
     * $oldDetail['harga']
     * @param  array $newDetail
     * $newDetail['keterangan']
     * $newDetail['tipe']
     * $newDetail['harga']
     *
     * @return boolean
     */
    public function isChanged(array $oldDetail, array $newDetail): bool
    {
        // Siapkan array detail yang lama (di database)
        $old = collect([
            'keterangan' => $oldDetail['keterangan'] ?? '',
            'harga' => $oldDetail['harga'] ?? '',
            'tipe' => $oldDetail['tipe'] ?? '',
        ]);

        // Cari perbedaan detail lama dg detail baru (dari payload angular)
        $diff = $old->diffAssoc([
            'keterangan' => $newDetail['keterangan'] ?? '',
            'harga' => $newDetail['harga'] ?? '',
            'tipe' => $newDetail['tipe'] ?? '',
        ]);

        return (count($diff->all()) > 0) ? true : false;
    }

    /**
     * Proses mass input data detail ke tabel m_user_det
     *
     * @author Wahyu Agung <email@email.com>
     *
     * @param array $newDetail array multidimensi
     * $newDetail[x]['m_item_id']
     * $newDetail[x]['keterangan']
     * $newDetail[x]['tipe']
     * $newDetail[x]['harga']
     *
     * @return boolean
     */
    public function create(array $detail): bool
    {
        if (isset($detail[0]['m_item_id'])) {
            $newDetail = $this->prepare($detail);
            $this->model->store((array) $newDetail);
            return true;
        }

        return false;
    }

    /**
     * Fungsi untuk melakukan update detail item
     *
     * @author Wahyu Agung <email@email.com>
     *
     * @param array $newDetail
     * $newDetail[x]['id']
     * $newDetail[x]['m_item_id']
     * $newDetail[x]['keterangan']
     * $newDetail[x]['tipe']
     * $newDetail[x]['harga']
     *
     * @return boolean
     */
    public function update(array $newDetail): bool
    {
        try {
            $arrOldDet = $this->groupById();
            $tmpCreateDetail = [];
            foreach ($newDetail as $arrNewDet) {
                /**
                 * Jika tidak ada data atau id dari payload tidak terdaftar di db, maka tampung di array $tmpCreateDetail untuk selanjutnya diinput,
                 * Jika id sudah terdaftar di DB, maka Update jika ada perubahan
                 */
                if (!isset($arrOldDet[$arrNewDet['id']])) {
                    $tmpCreateDetail[] = $arrNewDet;
                } elseif ($this->isChanged($arrOldDet[$arrNewDet['id']], $arrNewDet)) {
                    $this->model->edit($arrNewDet, $arrNewDet['id']);
                }

                // Seleksi detail yang masih digunakan, sisakan detail lama yang akan dihapus
                if (isset($arrOldDet[$arrNewDet['id']])) {
                    unset($arrOldDet[$arrNewDet['id']]);
                }
            }

            // Hapus detail yang tidak digunakan
            if (!empty($arrOldDet)) {
                $this->deleteUnUsed($arrOldDet);
            }

            // Mass Insert jika ada detail baru
            if (!empty($tmpCreateDetail)) {
                $this->create($tmpCreateDetail);
            }

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
    * Hapus detail item yang tidak digunakan
    *
    * @author Wahyu Agung <agung@landa.co.id>
    *
    * @param  array $usedDetailId id detail yang tetap digunakan / disimpan
    * @return void
    */
    public function deleteUnUsed(array $arrOldDet): void
    {
        $unUsedId = [];
        foreach ($arrOldDet as $val) {
            $unUsedId[] = $val['id'];
        }

        if (!empty($unUsedId)) {
            $this->model->deleteUnUsed($unUsedId, $this->parent->id);
        }
    }
}
