<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $fillable = ['deskripsi','kategori'];

    public function barangg()
    {
        return $this->hasMany(Barangg::class);
    }

    public static function getKategoriAll(){
        return DB::table('kategori')
                    ->select('id','deskripsi','kategori',DB::raw('getKetKategori(kategori) as ketKategori'));
    }

    public static function katShowAll(){
        return DB::table('kategori')
                ->join('barangg','kategori.id','=','barangg.kategori_id')
                ->select('kategori.id','deskripsi',DB::raw('ketKategori(kategori) as ketkategori'),
                         'barangg.merk');
    }

    public static function showKategoriById($id){
        return DB::table('kategori')
                ->join('barang','kategori.id','=','barang.kategori_id')
                ->select('barang.id','kategori.deskripsi',DB::raw('getKetKategori(kategori.kategori) as ketkategori'),
                         'barang.merk','barang.seri','barang.spesifikasi','barang.stok')
                ->get();

    }
}