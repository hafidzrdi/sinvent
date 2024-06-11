<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Validation\Rule;


class KategoriController extends Controller
{
    public function index()
    {  

        // query builder
        $rsetKategori = DB::table('kategori')->select('id','deskripsi', 'kategori',DB::raw('getKetKategori(kategori) as ketKategori'))->get();

        // pakai yg di model
        // $rsetKategori = Kategori::getKategoriAll()->paginate(10);

        // Eloquent ORM
        // $rsetKategori = Kategori::select('id', 'deskripsi', 'kategori',
        //     \DB::raw('(CASE
        //         WHEN kategori = "M" THEN "Modal"
        //         WHEN kategori = "A" THEN "Alat"
        //         WHEN kategori = "BHP" THEN "Bahan Habis Pakai"
        //         ELSE "Bahan Tidak Habis Pakai"
        //         END) AS ketKategori'))
        //     ->paginate(10);

        // menampilkan ke view
        return view('v_kategori.index', compact('rsetKategori'));
    }
    
    public function create()
    {
        return view('v_kategori.create');
    }

    public function store(Request $request)
    {
        // Pesan error
        $message = [
            'deskripsi.unique' => 'Deskripsi telah digunakan.',
            'deskripsi.required' => 'Kolom deskripsi tidak boleh kosong.',
            'kategori.required' => 'Kolom Kategori tidak boleh kosong.',
            'kategori.not_in' => 'Kategori yang dipilih tidak valid.',
        ];

        // Validasi data input dengan pesan error custom
        $request->validate([
            'deskripsi' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori', 'deskripsi')->where(function ($query) use ($request) {
                    return $query->whereRaw('LOWER(deskripsi) = ?', [strtolower($request->deskripsi)]);
                }),
            ],
            'kategori' => 'required|string|max:10|not_in:blank',
        ], $message);

        Kategori::create([
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id)
    {
        // query builder
        // $rsetKategori = DB::table('kategori')->select('id','deskripsi', 'kategori',DB::raw('getKetKategori(kategori) as ketKategori'))
        // ->where('id', '=', $id)
        // ->first();

        // pakai yang di model
        $rsetKategori = Kategori::getKategoriAll()
        ->where('id', '=', $id)
        ->first();
       
        // Eloquent ORM
        // $rsetKategori = Kategori::select('id', 'deskripsi', 'kategori',
        //     \DB::raw('(CASE
        //         WHEN kategori = "M" THEN "Modal"
        //         WHEN kategori = "A" THEN "Alat"
        //         WHEN kategori = "BHP" THEN "Bahan Habis Pakai"
        //         ELSE "Bahan Tidak Habis Pakai"
        //         END) AS ketKategori'))
        //     ->where('id', '=', $id)
        //     ->first();

        return view('v_kategori.show', compact('rsetKategori'));
    }

    public function edit(string $id)
    {
        $aKategori = array(
            'M' => 'Barang Modal',
            'A' => 'Alat',
            'BHP' => 'Bahan Habis Pakai',
            'BTHP' => 'Bahan Tidak Habis Pakai'
        );

        $rsetKategori = Kategori::find($id);
        return view('v_kategori.edit', compact('rsetKategori', 'aKategori'));
    }


    public function update(Request $request, string $id)
    {
        $p_error = [
            'deskripsi.unique' => 'Deskripsi telah digunakan.',
            'deskripsi.required' => 'Kolom Deskripsi tidak boleh kosong.',
        ];

        // Validasi data input dengan pesan error custom
        $request->validate([
            'deskripsi' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori', 'deskripsi')->ignore($id)->where(function ($query) use ($request) {
                    return $query->whereRaw('LOWER(deskripsi) = ?', [strtolower($request->deskripsi)]);
                }),
            ],
            'kategori' => 'required|string|max:10',
        ], $p_error);

        $rsetKategori = Kategori::find($id);
        $rsetKategori->update([
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        if (DB::table('barang')->where('kategori_id', $id)->exists()) {
            return redirect()->route('kategori.index')->with(['Gagal' => 'Data Gagal Dihapus!']);
        } else {
            $rsetKategori = Kategori::find($id);
            $rsetKategori->delete();
            return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }
    }

    function getAPIKategori()
    {
        $rsetKategori = Kategori::all();
        $data = array("data" => $rsetKategori);

        return response()->json($data);
    }

    function getAPIKategori1($id)
    {
        $rsetKategori = Kategori::find($id);
        $data = array("data" => $rsetKategori);
        return response()->json($data);
    }

    function updateKategori(Request $request, $id)
    {
        $rsetKategori = Kategori::find($id);
        if (null == $rsetKategori) {
            return response()->json(['status' => "Kategori tidak ditemukan"]);
        }
        
        $request->validate([
            'deskripsi' => 'required|string|max:255',
            'kategori' => 'required|string|max:10',
        ]);

        $rsetKategori->update([
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
        ]);

        return response()->json(['status' => "Kategori berhasil diubah"]);
    }
}
