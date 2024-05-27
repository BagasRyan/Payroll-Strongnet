@extends('layout.app')

@section('title', 'Karyawan')

@section('header', 'Data Karyawan')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pembayaran Paket Langganan</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <hr>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div>
                <a href="{{ route('karyawan.index') }}" class="btn btn-primary btn-sm m-2">Kembali</a>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Tambah Karyawan Baru
                    </div>
                    <div class="card-body">
                        <form action="{{ route('karyawan.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label mt-3" for="nama">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama">
                                <label class="form-label mt-3" for="nama">Posisi</label>
                                <select class="form-control" name="idDivisi">
                                    @foreach($divisi as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                                <label class="form-label mt-3" for="nama">Email</label>
                                <input type="email" class="form-control" name="email" id="nama">
                                <label class="form-label mt-3" for="nama">Alamat</label>
                                <input type="text" class="form-control" name="alamat" id="nama">
                                <label class="form-label mt-3" for="nama">Gaji Pokok</label>
                                <input type="text" class="form-control" name="gajiPokok" id="nama">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection