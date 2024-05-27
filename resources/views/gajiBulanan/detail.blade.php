@extends('layout.app')

@section('title', 'Detail Gaji')

@section('header', 'Detail Gaji')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Gaji {{ $tahun }} {{ $bulan }}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <hr>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        <a href="{{ route('gaji.bulanan.create', $idTanggal) }}" class="btn btn-primary btn-sm m-2">Tambah Data</a>
        <table id="table" class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Divisi</th>
                    <th>Tahun</th>
                    <th>Bulan</th>
                    <th>Gaji Pokok</th>
                    <th>Potongan Gaji</th>
                </tr>
            </thead>
        </table>
    </div>
</section>
@endsection
@push('script')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap.min.js"></script> -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/gajiBulanan.js') }}"></script>
@push('script')

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

@endpush
@endpush