<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'age',
        'phone_number',
    ];

    protected $hidden = [
        'password',
        // 'remember_token', // Jika Anda tidak menggunakan remember token
    ];

    protected $table = 'users';
    public $timestamps = true;

    // Relationship to Borrows
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}