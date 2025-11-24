<?php // Tidak ada spasi, baris kosong, atau karakter lain sebelum ini

namespace App\Models; // Ini adalah baris kode pertama setelah <?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'year',
        'available',
    ];

    protected $table = 'books';
}