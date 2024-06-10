<?php

namespace App\Http\Controllers;
use App\Models\Barangkeluar;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangkeluarController extends Controller
{
    public function index()
    {
        $rsetBarangkeluar = Barangkeluar::latest()->paginate(10);
        return view('v_barangkeluar.index',compact('rsetBarangkeluar'));
    }

    public function create()
    {
        $barangOptions = Barang::all();       
        return view('v_barangkeluar.create', compact('barangOptions'));
    }

    // public function store(Request $request)
    // {
        
    //     Barangkeluar::create([
    //         'tgl_keluar'          => $request->tgl_keluar,
    //         'qty_keluar'          => $request->qty_keluar,
    //         'barang_id'          => $request->barang_id,
    //     ]);

        

    //     return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Ditambah!']);
    // }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'tgl_keluar' => 'required|date',
            'qty_keluar' => 'required|integer|min:1',
            'barang_id' => 'required|exists:barang,id',
        ]);

        // Ambil data barang berdasarkan ID
        $barang = Barang::find($request->barang_id);

        // Periksa stok barang
        if ($barang->stok <= 0) {
            return redirect()->route('barangkeluar.index')->with(['Gagal' => 'Stok barang habis, tidak bisa menambahkan barang keluar!']);
        } elseif ($barang->stok < $request->qty_keluar) {
            return redirect()->route('barangkeluar.index')->with(['Gagal' => 'Stok barang tidak mencukupi untuk jumlah barang keluar yang diminta!']);
        }

        // Jika stok mencukupi, tambah data barang keluar
        Barangkeluar::create([
            'tgl_keluar' => $request->tgl_keluar,
            'qty_keluar' => $request->qty_keluar,
            'barang_id' => $request->barang_id,
        ]);

        // Kurangi stok barang
        $barang->stok -= $request->qty_keluar;
        $barang->save();

        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Ditambah!']);
    }


    
    public function show(string $id)
    {
        $rsetBarangkeluar = Barangkeluar::find($id);
        return view('v_barangkeluar.show', compact('rsetBarangkeluar'));
    }

    public function edit(string $id)
    {
        $rsetBarangkeluar = Barangkeluar::find($id);
        $selectedbarang = Barang::find($rsetBarangkeluar->barang_id); 
        return view('v_barangkeluar.edit', compact('rsetBarangkeluar','selectedbarang'));

    }

    public function update(Request $request, string $id)
    {
        $rsetBarangkeluar = Barangkeluar::find($id);

            $rsetBarangkeluar->update([
                'tgl_keluar'          => $request->tgl_keluar,
                'qty_keluar'          => $request->qty_keluar,
            ]);

        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id)
    {
        // Hapus data barang masuk berdasarkan ID
        Barangkeluar::findOrFail($id)->delete();

        return redirect()->route('barangkeluar.index')->with('success', 'Data barang masuk berhasil dihapus');
    }
}
