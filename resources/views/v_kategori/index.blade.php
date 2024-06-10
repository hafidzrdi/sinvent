@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <h1 class="h3 mt-3 ml-3 text-gray-800">Kategori</h1>
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
                        <a href="{{ route('kategori.create') }}" class="btn btn-md btn-success mb-3">TAMBAH KATEGORI</a>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 7%">ID</th>
                            <th>DESKRIPSI</th>
                            <th>KATEGORI</th>
                            <th>Keterangan Kategori</th>
                            <th style="width: 15%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rsetKategori as $kategori)
                            <tr>
                                <td>{{ $kategori->id  }}</td>
                                <td>{{ $kategori->deskripsi  }}</td>
                                <td>{{ $kategori->kategori  }}</td>
                                <td>{{ $kategori->ketKategori   }}</td>
                                <td class="text-center"> 
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" 
                                    action="{{ route('kategori.destroy', $kategori->id) }}" method="POST">

                                        <a href="{{ route('kategori.show', $kategori->id) }}" 
                                        class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>

                                        <a href="{{ route('kategori.edit', $kategori->id) }}" 
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
                {{$rsetKategori->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>
@endsection
