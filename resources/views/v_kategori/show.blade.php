<!-- resources/views/v_kategori/show.blade.php -->

@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <h1>Detail Kategori</h1>
        <div class="row">
            <div class="col-md-12">
               <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>ID</td>
                                <td>{{ $rsetKategori->id }}</td>
                            </tr>
                            <tr>
                                <td>DESKRIPSI</td>
                                <td>{{ $rsetKategori->deskripsi }}</td>
                            </tr>
                            <tr>
                                <td>KATEGORI</td>
                                <td>{{ $rsetKategori->kategori }}</td>
                            </tr>
                            <tr>
                                <td>KETERANGAN KATEGORI</td>
                                <td>{{ $rsetKategori->ketKategori }}</td>
                            </tr>
                        </table>
                    </div>
               </div>
            </div>
        </div>
        <div class="row">
            <br>
            <br>
        </div>
        <div class="col-md-12  text-center"">
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">BACK</a>
        </div>
    </div>
@endsection
