<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // TAMBAHKAN BARIS INI: Mengizinkan semua kolom diisi KECUALI id
    protected $guarded = ['id']; 

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}