<?php

namespace App\Models\Master;

use App\Repository\ModelInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksModel extends Model implements ModelInterface
{
    use HasFactory;
    protected $table = 'm_books';
    protected $guarded = [
        'id',
    ];

    public function getAll(array $filter, int $itemPerPage, string $sort): object
    {
        $books = $this->query();
        if (!empty($filter['title'])) {
            $books->where('title', 'LIKE', '%' . $filter['title'] . '%');
        }
        if (!empty($filter['author'])) {
            $books->where('author', 'LIKE', '%' . $filter['author'] . '%');
        }
        if (!empty($filter['publisher'])) {
            $books->where('publisher', 'LIKE', '%' . $filter['publisher'] . '%');
        }
        $sort = $sort ?: 'id DESC';
        $books->orderByRaw($sort);
        $itemPerPage = $itemPerPage > 0 ? $itemPerPage : false;
        return $books->paginate($itemPerPage)->appends('sort', $sort);
    }

    public function getById(int $id): object
    {
        return $this->find($id);
    }

    public function store(array $payload)
    {
        return $this->create($payload);
    }

    public function edit(array $payload, int $id)
    {
        return $this->find($id)->update($payload);
    }

    public function drop(int $id)
    {
        return $this->find($id)->delete();
    }

    public function borrow()
    {
        return $this->hasMany(BorrowModel::class, 'book_id', 'id');
    }
}