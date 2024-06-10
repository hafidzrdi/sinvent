@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h1 class="h3 mt-3 ml-3 text-gray-800">Barang Masuk</h1>
                    @if(Session::has('Gagal'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('Gagal') }}
                        </div>
                    @endif

                    @if(Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <a href="{{ route('barangmasuk.create') }}" class="btn btn-md btn-success mb-3">TAMBAH STOK BARANG</a>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>BARANG</th>
                            <th>SERI</th>
                            <th>STOK SAAT INI</th>
                            <th>TANGGAL MASUK</th>
                            <th>QTY MASUK</th>
                            <th style="width: 15%">AKSI</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rsetBarangmasuk as $barangmasuk)
                            <tr>
                                <td>{{ $barangmasuk->barang->merk  }}</td>
                                <td>{{ $barangmasuk->barang->seri  }}</td>
                                <td>{{ $barangmasuk->barang->stok  }}</td>
                                <td>{{ $barangmasuk->tgl_masuk  }}</td>
                                <td>{{ $barangmasuk->qty_masuk  }}</td>
                                <td class="text-center"> 
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" 
                                    action="{{ route('barangmasuk.destroy', $barangmasuk->id) }}" method="POST">

                                        <a href="{{ route('barangmasuk.show', $barangmasuk->id) }}" 
                                        class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>

                                        <a href="{{ route('barangmasuk.edit', $barangmasuk->id) }}" 
                                        class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                                        
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <div class="alert">
                                Data Barang belum tersedia
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection