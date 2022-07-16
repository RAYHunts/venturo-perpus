<?php

namespace App\Models\Master;

use App\Http\Traits\RecordSignature;
use App\Models\User\UserModel;
use App\Repository\ModelInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class BooksModel extends Model implements ModelInterface
{
    use HasFactory, SoftDeletes, HasRelationships;
    protected $table = 'm_books';
    protected $guarded = [
        'id',
    ];

    public function getAll(array $filter, int $itemPerPage, string $sort): object
    {
        $books = $this->query()->with('borrow');
        if (!empty($filter['borrowed'])) {
            if ($filter['borrowed'] == 'true') {
                $books->whereRelation('borrow', 'id', '>', 0);
            } else {
                $books->where('qty', '>', 0);
            }
        }
        // if (!empty($filter['title'])) {
        //     $books->where('title', 'LIKE', '%' . $filter['title'] . '%');
        // }
        // if (!empty($filter['author'])) {
        //     $books->where('author', 'LIKE', '%' . $filter['author'] . '%');
        // }
        // if (!empty($filter['publisher'])) {
        //     $books->where('publisher', 'LIKE', '%' . $filter['publisher'] . '%');
        // }
        $sort = $sort ?: 'id DESC';
        $books->orderByRaw($sort);
        $itemPerPage = $itemPerPage > 0 ? $itemPerPage : $this->query()->count();
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

    public function getBorrowedBooks(array $filter, int $itemPerPage, string $sort): object
    {
        $books = $this->query()->with('borrow')->whereRelation('borrow', '>', 0);
        return $books->paginate($itemPerPage)->appends('sort', $sort);
    }

    public function borrowing($user_id, $id)
    {
        BorrowModel::create([
            'user_id' => $user_id,
            'book_id' => $id,
            'borrow_date' => Carbon::now()->format('Y-m-d'),
        ]);
        $book = $this->find($id);
        $book->decrement('qty');
        $book->save();
        return $book;
    }

    public function photoUrl()
    {
        if (empty($this->photo)) {
            return "https://via.placeholder.com/300x380.png/0044aa?text=" . $this->title;
        }
        return $this->photo;
    }
}