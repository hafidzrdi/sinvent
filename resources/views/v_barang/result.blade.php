@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h1 class="h3 mt-3 ml-3 text-gray-800">Barang</h1>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(Session::has('Gagal'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('Gagal') }}
                        </div>
                    @endif

                    @if(Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <a href="{{ route('barang.create') }}" class="btn btn-md btn-success">TAMBAH BARANG</a>
                            <form action="{{ route('search_barang') }}" method="GET" class="form-inline d-flex mw-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" name="query" class="form-control bg-light border-0 small" placeholder="Cari Barang..." aria-label="Search" aria-describedby="basic-addon2" value="{{ request('query') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>MERK</th>
                            <th>SERI</th>
                            <th>SPESIFIKASI</th>
                            <th>STOK</th>
                            <th>DESKRIPSI</th>
                            <th>KATEGORI</th>
                            <th style="width: 15%">AKSI</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($results as $rowbarang)
                            <tr>
                                <td>{{ $rowbarang->id  }}</td>
                                <td>{{ $rowbarang->merk  }}</td>
                                <td>{{ $rowbarang->seri  }}</td>
                                <td>{{ $rowbarang->spesifikasi  }}</td>
                                <td>{{ $rowbarang->stok  }}</td>
                                <td>{{ $rowbarang->kategori->deskripsi }}</td>
                                <td>{{ $rowbarang->kategori->kategori }}</td>
                                <td class="text-center"> 
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" 
                                    action="{{ route('barang.destroy', $rowbarang->id) }}" method="POST">

                                        <a href="{{ route('barang.show', $rowbarang->id) }}" 
                                        class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>

                                        <a href="{{ route('barang.edit', $rowbarang->id) }}" 
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