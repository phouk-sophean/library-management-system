<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Book;

class Category extends Model
{
    use HasFactory;
    

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book__category')->withTimestamps();
    }

    protected $table = 'categories';
    protected $fillable = ['name'];

     public function getCreatedAtAttribute($value) {
        return date('d-m-Y', strtotime($value));
    }

    // create attribute to clean date formate
    public function getUpdatedAtAttribute($value) {
        return date('F d, Y', strtotime($value));
    }
}
