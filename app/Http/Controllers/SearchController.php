<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\BKV;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search_barang(Request $request)
    {
        $query = $request->input('query');
        $collation = 'utf8mb4_unicode_ci'; // Sesuaikan dengan kolasi yang digunakan di database

        $rsetBarang = BKV::whereRaw("CONVERT(merk USING utf8mb4) COLLATE $collation LIKE ?", ["%$query%"])
            ->orWhereRaw("CONVERT(seri USING utf8mb4) COLLATE $collation LIKE ?", ["%$query%"])
            ->orWhereRaw("CONVERT(spesifikasi USING utf8mb4) COLLATE $collation LIKE ?", ["%$query%"])
            ->orWhereRaw("CONVERT(stok USING utf8mb4) COLLATE $collation LIKE ?", ["%$query%"])
            ->orWhereRaw("CONVERT(kategori_id USING utf8mb4) COLLATE $collation LIKE ?", ["%$query%"])
            ->orWhereRaw("CONVERT(deskripsi USING utf8mb4) COLLATE $collation LIKE ?", ["%$query%"])
            ->orWhereRaw("CONVERT(kategori USING utf8mb4) COLLATE $collation LIKE ?", ["%$query%"])
            ->orWhereRaw("CONVERT(ketKategori USING utf8mb4) COLLATE $collation LIKE ?", ["%$query%"])
            ->get();

        return view('v_barang.index', compact('rsetBarang'));
    }

    // public function search_barang(Request $request)
    // {
    //     $query = $request->input('query');

    //     $rsetBarang = BKV::where('merk', 'like', "%$query%")
    //         ->orWhere('seri', 'like', "%$query%")
    //         ->orWhere('spesifikasi', 'like', "%$query%")
    //         ->orWhere('stok', 'like', "%$query%")
    //         ->orWhere('kategori_id', 'like', "%$query%")
    //         ->orWhere('deskripsi', 'like', "%$query%")
    //         ->orWhere('kategori', 'like', "%$query%")
    //         ->orWhere('ketKategori', 'like', "%$query%")
    //         ->get();

    //     return view('v_barang.index', compact('rsetBarang'));
    // }

    public function search_kategori(Request $request)
    {
        $query = $request->input('query');
        $rsetKategori = DB::table('kategori')->select('id','deskripsi', 'kategori',DB::raw('getKetKategori(kategori) as ketKategori'))
        ->where('deskripsi', 'like', "%$query%")
        ->orWhere('kategori', 'like', "%$query%")
        // ->orWhere('getKetKategori', 'like', "%$query%")
        ->get();
        // $rsetKategori = Kategori::where('deskripsi', 'like', "%$query%")
        //     ->orWhere('kategori', 'like', "%$query%")
        //     // ->orWhere('ketKategori', 'like', "%$query%")
        //     ->get();
        return view('v_kategori.index', compact('rsetKategori'));
    }

    // public function search_kategori(Request $request)
    // {
    //     $query = $request->input('query');

    //     $rsetKategori = DB::table('kategori')
    //         ->select('id', 'deskripsi', 'kategori', DB::raw('getKetKategori(kategori) as ketKategori'))
    //         ->where(function ($q) use ($query) {
    //             $q->where('deskripsi', 'like', "%$query%")
    //                 ->orWhere('kategori', 'like', "%$query%")
    //                 ->orWhere(DB::raw('getKetKategori(kategori)'), 'like', "%$query%");
    //         })
    //         ->get();

    //     return view('v_kategori.index', compact('rsetKategori'));
    // }
}
