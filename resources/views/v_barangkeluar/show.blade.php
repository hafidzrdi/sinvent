@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
               <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>BARANG</td>
                                <td>{{ $rsetBarangkeluar->barang->merk }}</td>
                            </tr>
                            <tr>
                                <td>SERI</td>
                                <td>{{ $rsetBarangkeluar->barang->seri }}</td>
                            </tr>
                            <tr>
                                <td>TANGGAL KELUAR</td>
                                <td>{{ $rsetBarangkeluar->tgl_keluar }}</td>
                            </tr>
                            <tr>
                                <td>JUMLAH KELUAR</td>
                                <td>{{ $rsetBarangkeluar->qty_keluar }}</td>
                            </tr>
                            <tr>
                                <td>TOTAL BARANG SAAT INI</td>
                                <td>{{ $rsetBarangkeluar->barang->stok }}</td>
                            </tr>
                        </table>
                    </div>
               </div>
            </div>
        </div>
        <div class="row">
            <br>
        </div>
        <div class="row">
            <div class="col-md-12  text-center">
                

                <a href="{{ route('barangkeluar.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
            </div>
        </div>
    </div>
@endsection