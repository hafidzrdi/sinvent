<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BKV extends Model
{
    use HasFactory;
    protected $table = 'barang_kategori_view';
    protected $fillable = [
        'barang_id', 'merk', 'seri', 'spesifikasi', 'stok', 'kategori_id',
        'deskripsi', 'kategori', 'ketKategori', 'created_at', 'updated_at'
    ];
}