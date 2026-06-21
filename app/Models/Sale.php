<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom diisi KECUALI id (konsisten dengan model lain di project ini)
    protected $guarded = ['id'];

    protected $casts = [
        'transaction_date' => 'datetime',
        'total' => 'decimal:2',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
