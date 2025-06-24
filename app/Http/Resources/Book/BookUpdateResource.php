<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookUpdateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'copies' => $this->copies,
            'isbn' => $this->isbn,
            'category_ids' => $this->whenLoaded('categories', fn () => $this->categories->pluck('id')),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
