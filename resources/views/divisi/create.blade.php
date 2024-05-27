@extends('layout.app')

@section('title', 'Divisi Karyawan')

@section('header', 'Tambah Divisi Karyawan')

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
                <a href="{{ route('divisi.index') }}" class="btn btn-primary btn-sm m-2">Kembali</a>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Tambah Divisi Baru
                    </div>
                    <div class="card-body">
                        <form action="{{ route('divisi.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label mt-3" for="nama">Nama Divisi</label>
                                <input type="text" class="form-control" name="nama" id="nama">

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