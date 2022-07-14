<?php

namespace App\Models\User;

use App\Repository\ModelInterface;
use App\Http\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleModel extends Model implements ModelInterface
{
    use SoftDeletes, RecordSignature;

    /**
    * Menentukan nama tabel yang terhubung dengan Class ini
    *
    * @var string
    */
   protected $table = 'user_roles';

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

    /**
     * Mendeklarasikan nilai default dari setiap kolom pada tabel m_user
     * jika suatu kolom tidak membutuhkan nilai default atau sudah diatur ketika membuat tabel
     * maka deklarasi ini bisa dilewati
     *
     * @var array
     */
    protected $attributes = [];

    protected $fillable = [
        'nama',
        'akses',
    ];

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = ''): object
    {
        $role = $this->query();

        if (!empty($filter['nama'])) {
            $role->where('nama', 'LIKE', '%'.$filter['nama'].'%');
        }

        $sort = $sort ?: 'id DESC';
        $role->orderByRaw($sort ?: 'id DESC');

        // Gunakan fitur "Laravel Pagination"
        $itemPerPage = ($itemPerPage > 0) ? $itemPerPage : false;        
        return $role->paginate($itemPerPage)->appends('sort', $sort);
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

    public function drop(int $id) {
        return $this->find($id)->delete();
    }
}
