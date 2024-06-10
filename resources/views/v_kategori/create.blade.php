@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">                    
                            @csrf

                            <div class="form-group">
                                <label class="font-weight-bold">DESKRIPSI</label>
                                <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" 
                                name="deskripsi" value="{{ old('deskripsi') }}" placeholder="Masukkan deskripsi Barang">
                            
                                <!-- error message untuk merk -->
                                @error('deskripsi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">KATEGORI</label>
                                
                                <div class="form-check">
                                    <select class="form-select" name="kategori" aria-label="Default select example">
                                        <option value="blank" selected>Pilih kategori</option>
                                        <option value="M">M - Barang Modal</option>
                                        <option value="A">A - Alat</option>
                                        <option value="BHP">BHP - Barang Habis Pakai</option>
                                        <option value="BTHP">BTHP - Barang Tidak Habis Pakai</option>
                                    </select>

                                </div>
                                <!-- error message untuk kategori -->
                                @error('kategori')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            

                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                        </form> 
                    </div>
                </div>

 

            </div>
        </div>
    </div>
@endsection