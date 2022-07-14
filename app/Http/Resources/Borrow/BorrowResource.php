<?php

namespace App\Http\Resources\Borrow;

use Illuminate\Http\Resources\Json\JsonResource;

class BorrowResource extends JsonResource
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
            'user' => $this->user->only(['id', 'nama', 'email']),
            'book' => $this->book,
            'borrow_date' => $this->borrow_date->locale('id')->isoFormat('D MMMM Y'),
            'return_date' => $this->return_date ? $this->return_date->locale('id')->isoFormat('D MMMM Y') : null,
            'status' => $this->status(),
            'denda' => $this->denda(),
            'must_return_date' => $this->must_return_date()->locale('id')->isoFormat('D MMMM Y')
        ];
    }
}