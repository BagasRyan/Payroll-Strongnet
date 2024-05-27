@extends('layout.app')

@section('title', 'Gaji Bulanan Karyawan')

@section('header', 'Gaji Bulanan Karyawan')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Gaji Bulanan</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <hr>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        <a href="{{ route('gaji.bulanan.create.tanggal') }}" class="btn btn-sm btn-primary">Buat Gaji Bulanan Baru</a>
        @forelse($tanggal as $data)
        <div class="card mt-4" style="width: 18rem;">
            <div class="card-body">
                <h3>{{ $data->tahun }}</h3>
                <h3>{{ $data->bulan }}</h3>
                <hr>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card's content.</p>
                <a href="{{ route('gaji.bulanan.detail', $data->id) }}" class="btn btn-primary">Lihat Detail</a>
            </div>
        </div>
        @empty
        <div class="card mt-3">
            <div class="card-header">
                Kosong
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p class="text-center">Data Masih Kosong</p>
                </blockquote>
            </div>
        </div>
        @endforelse
    </div>
</section>
@endsection
@if(session('tambah'))
<script>
Swal.fire({
    title: 'Berhasil',
    text: `{{ session('tambah') }}`,
    icon: 'success',
    showConfirmButton: false,
    timer: 1500
});
</script>
@endif

@if(session('update'))
<script>
Swal.fire({
    title: 'Berhasil',
    text: `{{ session('update') }}`,
    icon: 'success',
    showConfirmButton: false,
    timer: 1500
});
</script>
@endif