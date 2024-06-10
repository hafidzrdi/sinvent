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
                                <td>{{ $rsetBarangmasuk->barang->merk }}</td>
                            </tr>
                            <tr>
                                <td>SERI</td>
                                <td>{{ $rsetBarangmasuk->barang->seri }}</td>
                            </tr>
                            <tr>
                                <td>TANGGAL MASUK</td>
                                <td>{{ $rsetBarangmasuk->tgl_masuk }}</td>
                            </tr>
                            <tr>
                                <td>JUMLAH MASUK</td>
                                <td>{{ $rsetBarangmasuk->qty_masuk }}</td>
                            </tr>
                            <tr>
                                <td>TOTAL BARANG SAAT INI</td>
                                <td>{{ $rsetBarangmasuk->barang->stok }}</td>
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
                

                <a href="{{ route('barangmasuk.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
            </div>
        </div>
    </div>
@endsection