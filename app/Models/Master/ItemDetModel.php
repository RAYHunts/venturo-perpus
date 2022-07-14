<?php

namespace App\Models\Master;

use App\Http\Traits\RecordSignature;
use App\Repository\ModelDetInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;

class ItemDetModel extends Model implements ModelDetInterface
{
    use SoftDeletes, RecordSignature, HasRelationships, HasFactory;

    /**
     * Menentukan nama tabel yang terhubung dengan Class ini
     *
     * @var string
     */
    protected $table = 'm_item_det';

    /**
     * Menentukan primary key, jika nama kolom primary key adalah "id",
     * langkah deklarasi ini bisa dilewati
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Akan mengisi kolom "created_at" dan "updated_at" secara otomatis,
     *
     * @var bool
     */
    public $timestamps = true;

    protected $attributes = [

    ];

    protected $fillable = [
        'm_item_id',
        'tipe',
        'keterangan',
        'harga'
    ];

    /**
     * Relasi ke ItemModel / tabel m_item sebagai item parentnya
     *
     * @return void
     */
    public function item()
    {
        return $this->hasOne(ItemModel::class, 'id', 'm_item_id');
    }

    public function getAll(int $id): object
    {
        return $this->where('m_item_id', $id)->get();
    }

    public function getById(int $id): object
    {
        return $this->find($id);
    }

    public function store(array $payload) {
        return $this->insert($payload);
    }

    public function edit(array $payload, int $id) {
        return $this->find($id)->update($payload);
    }

    public function drop(int $id) {
        return $this->find($id)->delete();
    }

    public function deleteUnUsed(array $unUsedId, int $parentId) {
        return $this->whereIn('id', $unUsedId)->where('m_item_id', '=', $parentId)->delete();
    }
}
