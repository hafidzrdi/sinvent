<?php

namespace App\Http\Controllers;
use App\Models\Barangkeluar;
use App\Models\Barangmasuk;
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

    public function store(Request $request)
    {
        // Pesan error
        $messages = [
            'tgl_keluar.required' => 'Kolom Tanggal keluar tidak boleh kosong.',
            'qty_keluar.required' => 'Kolom Jumlah keluar tidak boleh kosong.',
            'qty_keluar.min' => 'Nilai Input minimal 1!',
            'barang_id.required' => 'Kolom Barang tidak boleh kosong.',
            'barang_id.exists' => 'Barang yang dipilih tidak valid.',
            'tgl_keluar.before_or_equal' => 'Tanggal keluar tidak boleh mendahului tanggal paling awal di barang masuk.',
        ];

        // Validasi data input
        $request->validate([
            'tgl_keluar' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $earliestTglMasuk = Barangmasuk::where('barang_id', $request->barang_id)->min('tgl_masuk');
                    if ($earliestTglMasuk && $value < $earliestTglMasuk) {
                        $fail('Tanggal keluar tidak boleh mendahului tanggal paling awal di barang masuk untuk barang ini.');
                    }
                }
            ],
            'qty_keluar' => 'required|integer|min:1',
            'barang_id' => 'required|exists:barang,id',
        ], $messages);

        // Check apakah ada tanggal yang sama
        $existingBarangKeluar = Barangkeluar::where('tgl_keluar', $request->tgl_keluar)
                                                ->where('barang_id', $request->barang_id)
                                                ->first();

        if ($existingBarangKeluar) {
            // Update record yang sudah ada
            $existingBarangKeluar->update([
                'qty_keluar' => $request->qty_keluar,
                'barang_id' => $request->barang_id,
            ]);
            $message = 'Data barang keluar berhasil diperbarui';
        } else {
            // Ambil data barang berdasarkan ID
            $barang = Barang::find($request->barang_id);

            // Cek stok barang
            if ($barang->stok <= 0) {
                return redirect()->route('barangkeluar.index')->with(['Gagal' => 'Stok barang habis, tidak bisa menambahkan barang keluar!']);
            } elseif ($barang->stok < $request->qty_keluar) {
                return redirect()->route('barangkeluar.index')->with(['Gagal' => 'Stok barang tidak mencukupi untuk jumlah barang keluar yang diminta!']);
            }

            // Tambah record baru
            Barangkeluar::create([
                'tgl_keluar' => $request->tgl_keluar,
                'qty_keluar' => $request->qty_keluar,
                'barang_id' => $request->barang_id,
            ]);
            $message = 'Data barang keluar berhasil ditambah';

            // Kurangi stok barang
            $barang->stok -= $request->qty_keluar;
            $barang->save();
        }

        return redirect()->route('barangkeluar.index')->with('success', $message);
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
        // pesan error
        $messages = [
            'tgl_keluar.required' => 'Kolom Tanggal keluar tidak boleh kosong.',
            'qty_keluar.required' => 'Kolom Jumlah keluar tidak boleh kosong.',
            'qty_keluar.min' => 'Nilai Input minimal 1!',
        ];

        $request->validate([
            'tgl_keluar' => 'required|date',
            'qty_keluar' => 'required|integer|min:1',
        ], $messages);

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
