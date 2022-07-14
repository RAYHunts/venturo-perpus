<?php

namespace App\Models\Master;

use App\Repository\ModelInterface;
use App\Http\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;

class CustomerModel extends Model implements ModelInterface
{
    use SoftDeletes, RecordSignature, HasRelationships, HasFactory;

     /**
     * Menentukan nama tabel yang terhubung dengan Class ini
     *
     * @var string
     */
    protected $table = 'm_customer';

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
        'nama',
        'email',
        'is_verified'
    ];

    public function isVerified() {
        return ($this->is_verified == 1) ? 'Sudah Verifikasi' : 'Belum Verifikasi';
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = ''): object
    {
        $customer = $this->query();

        if (!empty($filter['nama'])) {
            $customer->where('nama', 'LIKE', '%'.$filter['nama'].'%');
        }

        if (!empty($filter['email'])) {
            $customer->where('email', 'LIKE', '%'.$filter['email'].'%');
        }

        $sort = $sort ?: 'id DESC';
        $customer->orderByRaw($sort);
        $itemPerPage = $itemPerPage > 0 ? $itemPerPage : false;
        
        return $customer->paginate($itemPerPage)->appends('sort', $sort);
    }

    public function getById(int $id): object
    {
        return $this->find($id);
    }

    public function store(array $payload) {
        return $this->create($payload);
    }

    public function edit(array $payload, int $id) {
        return $this->find($id)->update($payload);
    }

    public function drop($id) {
        return $this->find($id)->delete();
    }
}
