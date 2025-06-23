<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Category;

class Book extends Model
{
    use HasFactory;

    public function borrowings()
    {
        return $this -> hasMany(Borrowing::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book__category')->withTimestamps();
    }
    protected $fillable = ['title', 'author', 'isbn', 'copies'];
}
