<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;
use App\Models\Book;

class Borrowing extends Model
{
    use HasFactory;
    protected $fillable = [
        'member_id',
        'book_id',
        'borrowed_at',
        'due_date',
        'returned_at',
    ];
    public function member() 
    {
        return $this -> belongsTo(Member::class);
    }

    public function book()
    {
        return $this -> belongsTo(Book::class);
    }
}
