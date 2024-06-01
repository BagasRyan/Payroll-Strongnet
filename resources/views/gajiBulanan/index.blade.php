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
    <a href="{{ route('gaji.bulanan.create.tanggal') }}" class="btn btn-sm btn-primary m-2">Buat Gaji Bulanan Baru</a>
    <div class="container-fluid row">
        <!-- @forelse($tanggal as $data)
        <div class="card mt-4 m-2 col-4" style="width: 18rem;">
            <div class="card-body">
                <h3>{{ $data->tahun }}</h3>
                <h3>{{ $data->bulan }}</h3>
                <hr>
                <p class="card-text">Jumlah Karyawan: {{ $data->total_karyawan }}</p>
                <p class="card-text">Total Pengeluaran: Rp. {{ $data->total_pengeluaran }}</p>
                <a href="{{ route('gaji.bulanan.detail', $data->id) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                <button onclick="onDelete(this)" id="{{ $data->id }}" class="btn btn-sm btn-danger">Hapus</button>
            </div>
        </div>
        @empty
        <div class="card mt-3">
            <div class="card-header">
                Kosong
            </div>
            <div class="card-body">
                <p class="text-center">Data masih kosong, silahkan tambahkan beberapa data</p>
                <br>
                <div class="text-center">
                    <a href="{{ route('gaji.bulanan.create.tanggal') }}" class="btn btn-sm btn-primary">Buat Gaji Bulanan Baru</a>
                </div>
            </div>
        </div>
        @endforelse -->
        <div class="card">
            <div class="card-body">
                <table id="table" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jumlah Karyawan</th>
                            <th>Total Pengeluaran</th>
                            <th>Tahun</th>
                            <th>Bulan</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="{{asset('/plugins/datatables/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/datatables/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('/plugins/datatables/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('js/tanggalGajian.js') }}"></script>
@endpush
@if(session('tambahTanggal'))
<script>
Swal.fire({
    title: 'Berhasil',
    text: `{{ session('tambahTanggal') }}`,
    icon: 'success',
    showConfirmButton: false,
    timer: 1500
});
</script>
@endif

@if(session('hapus'))
<script>
Swal.fire({
    title: 'Berhasil',
    text: `{{ session('hapus') }}`,
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