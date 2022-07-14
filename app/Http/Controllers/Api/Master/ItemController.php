<?php

namespace App\Http\Controllers\Api\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Master\ItemHelper;
use App\Http\Resources\Item\ItemResource;
use App\Http\Resources\Item\ItemCollection;
use App\Http\Requests\Item\CreateRequest;
use App\Http\Requests\Item\UpdateRequest;
use App\Http\Resources\Item\DetailResource;

class ItemController extends Controller
{
    protected $item;

    public function __construct()
    {
        $this->item = new ItemHelper;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = ['nama' => $request->nama ?? ''];
        $items = $this->item->getAll($filter, 5, $request->sort ?? '');

        return response()->success(new ItemCollection($items));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        /**
        * Menampilkan pesan error ketika validasi gagal
        * pengaturan validasi bisa dilihat pada class app/Http/request/User/CreateRequest
        */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors(), 422);
        }
        
        $dataInput = $request->only(['nama', 'deskripsi', 'harga', 'foto', 'is_available', 'kategori', 'detail']);
        $dataItem = $this->item->create($dataInput);
        
        if (!$dataItem['status']) {
            return response()->failed($dataItem['error'], 422);
        }
        
        return response()->success([], 'Data item berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataItem = $this->item->getById($id);

        if (empty($dataItem)) {
            return response()->failed(['Data item tidak ditemukan']);
        }

        return response()->success(new DetailResource($dataItem));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/User/UpdateRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $dataInput = $request->only(['nama', 'deskripsi', 'harga', 'foto', 'is_available', 'kategori', 'id', 'detail']);
        $dataItem = $this->item->update($dataInput, $dataInput['id']);
        
        if (!$dataItem['status']) {
            return response()->failed($dataItem['error']);
        }

        return response()->success(new ItemResource($dataItem['data']), 'Data item berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataItem = $this->item->delete($id);

        if (!$dataItem) {
            return response()->failed(['Mohon maaf data item tidak ditemukan']);
        }

        return response()->success($dataItem);
    }
}