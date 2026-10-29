<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    // Mengizinkan Laravel untuk mengisi kolom-kolom ini
    protected $fillable = ['order_id', 'donor_name', 'amount', 'status'];
}