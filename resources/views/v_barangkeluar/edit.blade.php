@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('barangkeluar.update',$rsetBarangkeluar->id) }}" method="POST" enctype="multipart/form-data">                    
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="font-weight-bold">MERK BARANG</label>
                                <input type="text" class="form-control @error('merk') is-invalid @enderror" 
                                name="merk" readonly value="{{ old('merk',$selectedbarang->merk) }}" placeholder="Masukkan merk Barang">
                            
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
                                name="seri" readonly value="{{ old('seri',$selectedbarang->seri) }}" placeholder="Masukkan seri Barang">
                            
                                <!-- error message untuk seri -->
                                @error('seri')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">TANGGAL KELUAR</label>
                                <input type="date" class="form-control @error('tgl_keluar') is-invalid @enderror" 
                                name="tgl_keluar" value="{{ old('tgl_keluar',$rsetBarangkeluar->tgl_keluar) }}" placeholder="Tulis tgl_keluar Barang">
                            
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
                                name="qty_keluar" value="{{ old('qty_keluar',$rsetBarangkeluar->qty_keluar) }}" placeholder="Tulis qty_keluar Barang">
                            
                                <!-- error message untuk qty_keluar -->
                                @error('qty_keluar')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>
                            <button type="submit" class="btn btn-md btn-primary">KEMBALI</button>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection