<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\BKV;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
// use App\Models\Barang_Kategori_View;

class BarangController extends Controller
{
    public function index()
    {
        // Eloquent ORM (ambil data di view)
        $rsetBarang = BKV::latest()->get();

        // menampilkan ke view
        return view('v_barang.index', compact('rsetBarang'));
    }

    public function create()
    {
        $kategoriOptions = Kategori::all();
        return view('v_barang.create', compact('kategoriOptions'));
    }

    public function store(Request $request)
    {
        // pesan error
        $messages = [
            'merk.required' => 'Kolom merk tidak boleh kosong.',
            'seri.required' => 'Kolom seri tidak boleh kosong.',
            'spesifikasi.required' => 'Kolom spesifikasi tidak boleh kosong.',
            'kategori_id.required' => 'Kolom kategori tidak boleh kosong.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
        ];
        
        // Validasi data input
        $request->validate([
            'merk' => 'required|string|max:50',
            'seri' => 'required|string|max:50',
            'spesifikasi' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
        ], $messages);

        // tambah record baru
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
        $rsetKategori = Kategori::select('id', 'deskripsi', 'kategori', DB::raw('getKetKategori(kategori) as ketKategori'))
        ->where ('id',$rsetBarang->kategori_id)
        ->first();
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
        $rsetBarang = Barang::find($id);

        $messages = [
            'merk.required' => 'Kolom merk tidak boleh kosong.',
            'seri.required' => 'Kolom seri tidak boleh kosong.',
            'spesifikasi.required' => 'Kolom spesifikasi tidak boleh kosong.', // Meskipun nullable, tambahkan untuk konsistensi
            'kategori_id.required' => 'Kolom kategori tidak boleh kosong.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
        ];
        
        // Validasi data input
        $request->validate([
            'merk' => 'required|string|max:50',
            'seri' => 'required|string|max:50',
            'spesifikasi' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
        ], $messages);

        $rsetBarang->update([
            'merk' => $request->merk,
            'seri' => $request->seri,
            'spesifikasi' => $request->spesifikasi,
            // 'stok' => $request->stok,
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