@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('barangmasuk.store') }}" method="POST" enctype="multipart/form-data">                    
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
                                <label class="font-weight-bold">TANGGAL MASUK</label>
                                <input type="date" class="form-control @error('tgl_masuk') is-invalid @enderror" 
                                name="tgl_masuk" value="{{ old('tgl_masuk') }}" placeholder="Masukkan Tanggal Masuk">
                            
                                <!-- error message untuk tgl_masuk -->
                                @error('tgl_masuk')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">JUMLAH MASUK</label>
                                <input type="number" class="form-control @error('qty_masuk') is-invalid @enderror" 
                                name="qty_masuk" value="{{ old('qty_masuk') }}" placeholder="Masukkan Jumlah Masuk">
                            
                                <!-- error message untuk qty_masuk -->
                                @error('qty_masuk')
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