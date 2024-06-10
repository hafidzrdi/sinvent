<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use DB;

class BarangController extends Controller
{
    public function index()
    {
        $rsetBarang = Barang::latest()->paginate(10);
        return view('v_barang.index', compact('rsetBarang'));
    }

    public function create()
    {
        $kategoriOptions = Kategori::all();
        return view('v_barang.create', compact('kategoriOptions'));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'merk' => 'required|string|max:50',
            'seri' => 'required|string|max:50',
            'spesifikasi' => 'nullable|string',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        Barang::create([
            'merk' => $request->merk,
            'seri' => $request->seri,
            'spesifikasi' => $request->spesifikasi,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id)
    {
        $rsetBarang = Barang::find($id);
        $rsetKategori = Kategori::select('id', 'deskripsi', 'kategori',
            \DB::raw('(CASE
                WHEN kategori = "M" THEN "Modal"
                WHEN kategori = "A" THEN "Alat"
                WHEN kategori = "BHP" THEN "Bahan Habis Pakai"
                ELSE "Bahan Tidak Habis Pakai"
                END) AS ketKategori'));
        return view('v_barang.show', compact('rsetBarang', 'rsetKategori'));
    }

    public function edit(string $id)
    {
        $kategoriOptions = Kategori::all();
        $rsetBarang = Barang::find($id);
        return view('v_barang.edit', compact('rsetBarang', 'kategoriOptions'));
    }

    public function update(Request $request, string $id)
    {
        // // Validasi data input
        // $request->validate([
        //     'merk' => 'required|string|max:50',
        //     'seri' => 'required|string|max:50',
        //     'spesifikasi' => 'nullable|string',
        //     'stok' => 'required|integer|min:0',
        //     'kategori_id' => 'required|exists:kategori,id',
        // ]);

        $rsetBarang = Barang::find($id);

        $rsetBarang->update([
            'merk' => $request->merk,
            'seri' => $request->seri,
            'spesifikasi' => $request->spesifikasi,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        if (DB::table('barangmasuk')->where('barang_id', $id)->exists()) {
            return redirect()->route('barang.index')->with(['Gagal' => 'Data Gagal Dihapus!']);
        }
        elseif (DB::table('barangkeluar')->where('barang_id', $id)->exists()) {
            return redirect()->route('barang.index')->with(['Gagal' => 'Data Gagal Dihapus!']);
        }
        else {
            $rsetBarang = Barang::find($id);
            $rsetBarang->delete();
            return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }
    }
}