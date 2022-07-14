<?php

namespace App\Http\Resources\Item;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'foto' => $this->foto,
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'kategori' => $this->kategori,
            'harga' => $this->harga,
            'is_available' => $this->is_available
        ];
    }
}
