@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('barangkeluar.store') }}" method="POST" enctype="multipart/form-data">                    
                            @csrf

                            <div class="form-group">
                                <label class="font-weight-bold">BARANG</label>
                                
                                <div class="form-check">
                                    <select class="form-select" name="barang_id" aria-label="Default select example">
                                        <option value="blank" selected>Pilih Barang</option>
                                        @foreach ($barangOptions as $barang)
                                            <option value="{{ $barang->id }}">{{ $barang->merk }} - {{ $barang->seri }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- error message untuk barang -->
                                @error('barang_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label class="font-weight-bold">TANGGAL KELUAR</label>
                                <input type="date" class="form-control @error('tgl_keluar') is-invalid @enderror" 
                                name="tgl_keluar" value="{{ old('tgl_keluar') }}" placeholder="Masukkan Tanggal Keluar">
                            
                                <!-- error message untuk tgl_keluar -->
                                @error('tgl_keluar')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">JUMLAH KELUAR</label>
                                <input type="number" class="form-control @error('qty_keluar') is-invalid @enderror" 
                                name="qty_keluar" value="{{ old('qty_keluar') }}" placeholder="Masukkan Jumlah Keluar">
                            
                                <!-- error message untuk qty_keluar -->
                                @error('qty_keluar')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>
                            <a href="{{ route('barangkeluar.index') }}" class="btn btn-md btn-primary">BACK</a>
                        </form> 
                    </div>
                </div>

 

            </div>
        </div>
    </div>
@endsection