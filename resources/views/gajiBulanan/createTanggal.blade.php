@extends('layout.app')

@section('title', 'Tambah Gaji Bulanan')

@section('header', 'Tambah Gaji Bulanan')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Gaji Bulanan</h1>
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
                <a href="{{ route('gaji.bulanan.index') }}" class="btn btn-primary btn-sm m-2">Kembali</a>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Tambah Karyawan Baru
                    </div>
                    <div class="card-body">
                        <form action="{{ route('gaji.bulanan.store.tanggal') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label mt-3" for="nama">Tahun</label>
                                <select class="form-control" name="tahun">
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                </select>
                                <label class="form-label mt-3" for="nama">Bulan</label>
                                <select class="form-control" name="bulan">
                                    @foreach($bulan as $data)
                                    <option value="{{ $data }}">{{ $data }}</option>
                                    @endforeach
                                </select>
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