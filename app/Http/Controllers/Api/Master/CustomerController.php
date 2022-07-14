<?php

namespace App\Http\Controllers\Api\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Master\CustomerHelper;
use App\Http\Requests\Customer\CustomerRequest;
use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\Customer\CustomerCollection;

class CustomerController extends Controller
{
    private $customer;
    
    public function __construct()
    {
        $this->customer = new CustomerHelper();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = ['nama' => $request->nama ?? ''];
        $listCustomer = $this->customer->getAll($filter, 5, $request->sort ?? '');

        return response()->success(new CustomerCollection($listCustomer));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/Customer/CustomerRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors(), 422);
        }
        
        $dataInput = $request->only(['nama', 'email', 'is_verified']);
        $dataCust = $this->customer->create($dataInput);
        
        if (!$dataCust['status']) {
            return response()->failed($dataCust['error'], 422);
        }

        return response()->success([], 'Data customer berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataCust = $this->customer->getById($id);

        if (empty($dataCust)) {
            return response()->failed(['Data customer tidak ditemukan']);
        }

        return response()->success(new CustomerResource($dataCust));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/Customer/CustomerRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $dataInput = $request->only(['nama', 'email', 'is_verified', 'id']);
        $dataCust = $this->customer->update($dataInput, $dataInput['id']);
        
        if (!$dataCust['status']) {
            return response()->failed($dataCust['error']);
        }

        return response()->success(new CustomerResource($dataCust['data']), 'Data customer berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataCust = $this->customer->delete($id);

        if (!$dataCust) {
            return response()->failed(['Mohon maaf data customer tidak ditemukan']);
        }

        return response()->success($dataCust);
    }
}
