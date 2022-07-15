<?php

namespace App\Http\Controllers\Api\Master;

use App\Helpers\Master\BooksHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BooksCollection;
use App\Http\Resources\Book\BooksResource;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    private $book;

    public function __construct()
    {
        $this->book = new BooksHelper();
    }
    public function index(Request $request)
    {
        $filter = [
            'title' => $request->title ?? '',
            'author' => $request->author ?? '',
            'publisher' => $request->publisher ?? '',
        ];

        $listBooks = $this->book->getAll($filter, $request->limit ?? 0, $request->sort ?? '');
        return response()->success(new BooksCollection($listBooks));
    }

    public function show($id)
    {
        $dataBook = $this->book->getById($id);
        if (empty($dataBook)) {
            return response()->failed(['Data buku tidak ditemukan']);
        }
        return response()->success(new BooksResource($dataBook));
    }

    public function store(Request $request)
    {
        $dataInput = $request->only(['title', 'description', 'photo', 'publisher', 'publish_year', 'author', 'qty']);
        $dataBook = $this->book->create($dataInput);
        if (!$dataBook['status']) {
            return response()->failed($dataBook['error'], 422);
        }
        return response()->success([], 'Data buku berhasil disimpan');
    }

    public function update(Request $request)
    {
        $dataInput = $request->only(['title', 'description', 'photo', 'publisher', 'publish_year', 'author', 'qty', 'id']);
        $dataBook = $this->book->update($dataInput, $dataInput['id']);
        if (!$dataBook['status']) {
            return response()->failed($dataBook['error']);
        }
        return response()->success($dataBook['data'], 'Data buku berhasil disimpan');
    }

    public function borrowing(Request $request)
    {
        $dataBook = $this->book->borrowing($request->user_id, $request->book_id);
        if (!$dataBook['status']) {
            return response()->failed($dataBook['error']);
        }
        return response()->success($dataBook['data'], 'Buku berhasil dipinjam');
    }

    public function destroy($id)
    {
        $dataBook = $this->book->delete($id);
        if (!$dataBook) {
            return response()->failed(['Mohon maaf data customer tidak ditemukan']);
        }
        return response()->success($dataBook);
    }
}