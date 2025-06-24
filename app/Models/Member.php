<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// model 
use App\Models\Borrowing;

class Member extends Model
{
    use HasFactory;

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];
     public function getCreatedAtAttribute($value) {
        return date('d-m-Y', strtotime($value));
    }

    // create attribute to clean date formate
    public function getUpdatedAtAttribute($value) {
        return date('F d, Y', strtotime($value));
    }
}
