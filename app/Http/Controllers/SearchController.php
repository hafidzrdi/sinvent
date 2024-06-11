<?php

// app/Http/Controllers/SearchController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\BKV;

class SearchController extends Controller
{
    public function search_barang(Request $request)
    {
        $query = $request->input('query');

        $rsetBarang = BKV::where('merk', 'like', "%$query%")
            ->orWhere('seri', 'like', "%$query%")
            ->orWhere('spesifikasi', 'like', "%$query%")
            ->get();

        return view('v_barang.index', compact('rsetBarang'));
    }

    public function search_kategori(Request $request)
    {
        $query = $request->input('query');

        $rsetKategori = Kategori::getKategoriAll()
            ->where('deskripsi', 'like', "%$query%")
            ->orWhere('kategori', 'like', "%$query%")
            // ->orWhere('ketKategori', 'like', "%$query%")
            // ->with('kategori')
            ->get();
        return view('v_kategori.index', compact('rsetKategori'));
    }
}
