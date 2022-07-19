<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Borrow\BorrowResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'email' => $this->email,
            'fotoUrl' => $this->fotoUrl(),
            'updated_security' => $this->updated_security,
            'akses' => json_decode($this->role->akses),
            'hak_akses' => $this->role->nama,
            'is_admin' => $this->isAdmin(),
            'borrows' => BorrowResource::collection($this->borrow),
        ];
    }
}