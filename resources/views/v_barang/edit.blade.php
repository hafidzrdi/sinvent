@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('barang.update',$rsetBarang->id) }}" method="POST" enctype="multipart/form-data">                    
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="font-weight-bold">MERK BARANG</label>
                                <input type="text" class="form-control @error('merk') is-invalid @enderror" 
                                name="merk" value="{{ old('merk',$rsetBarang->merk) }}" placeholder="Masukkan merk Barang">
                            
                                <!-- error message untuk merk -->
                                @error('merk')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">SERI BARANG</label>
                                <input type="text" class="form-control @error('seri') is-invalid @enderror" 
                                name="seri" value="{{ old('seri',$rsetBarang->seri) }}" placeholder="Masukkan seri Barang">
                            
                                <!-- error message untuk seri -->
                                @error('seri')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">SPESIFIKASI</label>
                                <input type="text" class="form-control @error('spesifikasi') is-invalid @enderror" 
                                name="spesifikasi" value="{{ old('spesifikasi',$rsetBarang->spesifikasi) }}" placeholder="Tulis Spesifikasi Barang">
                            
                                <!-- error message untuk spesifikasi -->
                                @error('spesifikasi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="font-weight-bold">KATEGORI</label>
                                
                                <div class="form-check">
                                   
                                    <select class="form-select" name="kategori_id" aria-label="Default select example">
                                        @foreach($kategoriOptions as $key=>$val)
                                            @if($rsetBarang->kategori_id==$key)
                                                <option value="{{ $rsetBarang->kategori_id }}" 
                                                selected>{{ $rsetBarang->kategori->deskripsi }} - {{ $rsetBarang->kategori->kategori }}</option>
                                            @else
                                                <option value="{{ $val->id }}">{{ $val->deskripsi }} - {{ $val->kategori }}</option>
                                            @endif
                                        @endforeach    
                                    </select>

                                </div>
                                <!-- error message untuk kategori -->
                                @error('kategori_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>   

                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <a href="{{ route('barang.index') }}" class="btn btn-md btn-primary">BACK</a>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection