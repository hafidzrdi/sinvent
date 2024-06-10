<?php

namespace App\Http\Controllers;
use App\Models\Barangmasuk;
use App\Models\Barang;
use App\Models\Barangkeluar; // Add this to check if barangkeluar exists
use Illuminate\Http\Request;

class BarangmasukController extends Controller
{
    public function index()
    {
        $rsetBarangmasuk = Barangmasuk::latest()->paginate(10);
        return view('v_barangmasuk.index', compact('rsetBarangmasuk'));
    }

    public function create()
    {
        $barangOptions = Barang::all();
        return view('v_barangmasuk.create', compact('barangOptions'));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'tgl_masuk' => 'required|date',
            'qty_masuk' => 'required|integer|min:1',
            'barang_id' => 'required|exists:barang,id',
        ]);

        // Simpan data barang masuk ke database
        Barangmasuk::create([
            'tgl_masuk' => $request->tgl_masuk,
            'qty_masuk' => $request->qty_masuk,
            'barang_id' => $request->barang_id,
        ]);

        // Update stok barang
        // $barang = Barang::find($request->barang_id);
        // $barang->stok += $request->qty_masuk;
        // $barang->save();

        return redirect()->route('barangmasuk.index')->with('success', 'Data barang masuk berhasil ditambah');
    }

    public function show(string $id)
    {
        $rsetBarangmasuk = Barangmasuk::find($id);
        return view('v_barangmasuk.show', compact('rsetBarangmasuk'));
    }

    public function edit(string $id)
    {
        $rsetBarangmasuk = Barangmasuk::find($id);
        $selectedbarang = Barang::find($rsetBarangmasuk->barang_id); 
        return view('v_barangmasuk.edit', compact('rsetBarangmasuk','selectedbarang'));
    }

    public function update(Request $request, string $id)
    {
        // Validasi data input
        $request->validate([
            'tgl_masuk' => 'required|date',
            'qty_masuk' => 'required|integer|min:1',
        ]);

        // Ambil data barang masuk yang akan diupdate
        $rsetBarangmasuk = Barangmasuk::find($id);

        // Ambil data barang terkait
        $barang = Barang::find($rsetBarangmasuk->barang_id);

        // Hitung perubahan stok
        $stokLama = $barang->stok - $rsetBarangmasuk->qty_masuk;
        $stokBaru = $stokLama + $request->qty_masuk;

        // Periksa stok barang
        if ($stokBaru < 0) {
            return redirect()->route('barangmasuk.index')->with(['Gagal' => 'Stok barang tidak bisa negatif setelah pembaruan!']);
        }

        // Update data barang masuk
        $rsetBarangmasuk->update([
            'tgl_masuk' => $request->tgl_masuk,
            'qty_masuk' => $request->qty_masuk,
        ]);

        // // Update stok barang
        // $barang->stok = $stokBaru;
        // $barang->save();

        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    // public function destroy($id)
    // {
    //     $barangmasuk = Barangmasuk::findOrFail($id);

    //     // Check if there are any related barangkeluar entries
    //     $barangkeluar = Barangkeluar::where('barang_id', $barangmasuk->barang_id)
    //         ->where('tgl_keluar', '>=', $barangmasuk->tgl_masuk)
    //         ->first();

    //     if ($barangkeluar) {
    //         return redirect()->route('barangmasuk.index')->with('Gagal', 'Tidak dapat menghapus barang masuk karena ada barang keluar terkait.');
    //     }

    //     // Reduce the stock before deleting
    //     $barang = Barang::find($barangmasuk->barang_id);
    //     $barang->stok -= $barangmasuk->qty_masuk;
    //     $barang->save();

    //     // Hapus data barang masuk berdasarkan ID
    //     $barangmasuk->delete();

    //     return redirect()->route('barangmasuk.index')->with('success', 'Data barang masuk berhasil dihapus');
    // }

    public function destroy($id)
    {
        $barangmasuk = Barangmasuk::findOrFail($id);

        // Check if deleting the barangmasuk entry would result in negative stock
        $barang = Barang::find($barangmasuk->barang_id);
        $new_stock = $barang->stok - $barangmasuk->qty_masuk;

        if ($new_stock < 0) {
            return redirect()->route('barangmasuk.index')->with('Gagal', 'Tidak dapat menghapus barang masuk karena stok akan menjadi minus.');
        }

        // // Check if there are any related barangkeluar entries
        // $barangkeluar = Barangkeluar::where('barang_id', $barangmasuk->barang_id)
        //     ->where('tgl_keluar', '>=', $barangmasuk->tgl_masuk)
        //     ->first();

        // if ($barangkeluar) {
        //     return redirect()->route('barangmasuk.index')->with('Gagal', 'Tidak dapat menghapus barang masuk karena ada barang keluar terkait.');
        // }

        // Reduce the stock before deleting
        // $barang->stok -= $barangmasuk->qty_masuk;
        // $barang->save();

        // Hapus data barang masuk berdasarkan ID
        $barangmasuk->delete();

        return redirect()->route('barangmasuk.index')->with('success', 'Data barang masuk berhasil dihapus');
    }

    
}
