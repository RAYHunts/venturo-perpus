<?php

namespace App\Models\Master;

use App\Repository\ModelInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\UserModel;
use Carbon\Carbon;

class BorrowModel extends Model implements ModelInterface
{
    use HasFactory;
    protected $table = 'm_borrow';
    protected $guarded = [
        'id',
    ];

    public $dates = [
        'borrow_date',
        'return_date',
    ];


    public function getAll(array $filter, int $itemPerPage, string $sort): object
    {
        $borrow = $this->query()->with('user', 'book');
        if (!empty($filter['user_id'])) {
            $borrow->where('user_id', $filter['user_id']);
        }
        if (!empty($filter['book_id'])) {
            $borrow->where('book_id', $filter['book_id']);
        }
        if (!empty($filter['borrow_date'])) {
            $borrow->where('borrow_date', $filter['borrow_date']);
        }
        if (!empty($filter['return_date'])) {
            $borrow->where('return_date', $filter['return_date']);
        }
        $sort = $sort ?: 'id DESC';
        $borrow->orderByRaw($sort);
        $itemPerPage = $itemPerPage > 0 ? $itemPerPage : false;
        return $borrow->paginate($itemPerPage)->appends('sort', $sort);
    }
    public function getById(int $id): object
    {
        return $this->find($id);
    }

    public function store(array $payload)
    {
        $payload['borrow_date'] = Carbon::now()->format('Y-m-d');
        return $this->create($payload);
    }

    public function edit(array $payload, int $id)
    {
        $payload['return_date'] = Carbon::now()->format('Y-m-d');
        return $this->find($id)->update($payload);
    }

    public function drop(int $id)
    {
        return $this->find($id)->delete();
    }

    public function status()
    {
        if ($this->return_date != null) {
            if ($this->return_date <= $this->must_return_date()) {
                return 'ontime';
            } else {
                return 'late return';
            }
        } elseif ($this->must_return_date() < Carbon::now()) {
            return 'late not return';
        }
        return 'borrowed';
    }

    public function denda()
    {
        $denda = 0;
        switch ($this->status()) {
            case 'ontime':
                $denda = 0;
                break;
            case 'late return':
                $denda = $this->must_return_date()->diffInDays($this->return_date);
                break;
            case 'late not return':
                $denda = $this->must_return_date()->diffInDays(Carbon::now());
                break;
            default:
                $denda = 0;
                break;
        }
        return $denda * 5000;
    }

    public function must_return_date()
    {
        return $this->borrow_date->addDays(7);
    }

    public function book()
    {
        return $this->belongsTo(BooksModel::class, 'book_id');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}