@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('barangmasuk.update',$rsetBarangmasuk->id) }}" method="POST" enctype="multipart/form-data">                    
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
                                <label class="font-weight-bold">TANGGAL MASUK</label>
                                <input type="date" class="form-control @error('tgl_masuk') is-invalid @enderror" 
                                name="tgl_masuk" value="{{ old('tgl_masuk',$rsetBarangmasuk->tgl_masuk) }}" placeholder="Tulis tgl_masuk Barang">
                            
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
                                name="qty_masuk" value="{{ old('qty_masuk',$rsetBarangmasuk->qty_masuk) }}" placeholder="Tulis qty_masuk Barang">
                            
                                <!-- error message untuk qty_masuk -->
                                @error('qty_masuk')
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