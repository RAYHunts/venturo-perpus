<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Borrow\BorrowResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BooksResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'author' => $this->author,
            'photo' => $this->photoUrl(),
            'publisher' => $this->publisher,
            'publish_year' => $this->publish_year,
            'qty' => $this->qty,
            'borrows' => BorrowResource::collection($this->borrow),
        ];
    }
}