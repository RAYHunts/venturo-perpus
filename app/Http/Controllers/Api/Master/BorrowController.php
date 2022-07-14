<?php

namespace App\Http\Controllers\Api\Master;

use App\Helpers\Master\BorrowHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Borrow\BorrowCollection;
use App\Http\Resources\Borrow\BorrowResource;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    private $borrow;

    public function __construct()
    {
        $this->borrow = new BorrowHelper();
    }

    public function index(Request $request)
    {
        $filter = [
            'book_id' => $request->book_id ?? '',
            'status' => $request->status ?? '',
            'borrow_date' => $request->borrow_date ?? '',
            'return_date' => $request->return_date ?? '',
        ];
        $listBorrow = $this->borrow->getAll($filter, $request->limit ?? 10, $request->sort ?? '');
        return response()->success(new BorrowCollection($listBorrow));
    }

    public function store(Request $request)
    {
        $dataInput = $request->only(['book_id', 'user_id']);
        $dataBorrow = $this->borrow->create($dataInput);
        if (!$dataBorrow['status']) {
            return response()->failed($dataBorrow['error'], 422);
        }
        return response()->success([], 'Data peminjaman berhasil disimpan');
    }

    public function show($id)
    {
        $dataBorrow = $this->borrow->getById($id);
        if (empty($dataBorrow)) {
            return response()->failed(['Data peminjaman tidak ditemukan']);
        }
        return response()->success(new BorrowResource($dataBorrow));
    }

    public function update(Request $request)
    {

        $dataInput = $request->only(['book_id', 'user_id', 'id']);
        $dataBorrow = $this->borrow->update($dataInput, $dataInput['id']);
        if (!$dataBorrow['status']) {
            return response()->failed($dataBorrow['error']);
        }
        return response()->success($dataBorrow['data'], 'Data peminjaman berhasil diubah');
    }

    public function destroy($id)
    {
        $dataBorrow = $this->borrow->delete($id);
        if (!$dataBorrow) {
            return response()->failed($dataBorrow['error']);
        }
        return response()->success($dataBorrow['data']);
    }
}