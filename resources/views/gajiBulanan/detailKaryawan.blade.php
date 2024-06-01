@extends('layout.app')

@section('title', 'Detail Gaji')

@section('header', 'Detail Gaji')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Gaji </h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <hr>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
    <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm m-2">Kembali</a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card p-2 text-center">
                    <div class="rounded-circle mb-2 bg-secondary m-auto m-2 img-fluid"
                        style="width: 100px; height: 100px;">
                        <h1 class="mt-4"><i class="bx bx-user"></h1></i>
                    </div>
                    <h4></h4>
                    <h4>{{ $dataKaryawan->nama }}</h4>
                    <h4>{{ $dataKaryawan->divisi }}</h4>
                </div>
                <div class="card p-3">
                    <h5 class="text-center">Info Kehadiran Karyawan</h5>
                    <!-- <table>
                        <tr><td><h5>Telat 10 Menit : {{ $dataKaryawan->telat_10_menit }} Kali</h5></td></tr>
                        <tr><td><h5>Telat 20 Menit : {{ $dataKaryawan->telat_20_menit }} Kali</h5></td></tr>
                        <tr><td><h5>Telat 30 Menit : {{ $dataKaryawan->telat_30_menit }} Kali</h5></td></tr>
                        <tr><td><h5>Telat Lebih Dari 30 Menit : {{ $dataKaryawan->telat_lebih_dari_30_menit }} Kali</h5></td></tr>
                        <tr><td><h5>Pulang Lebih Awal : {{ $dataKaryawan->pulang_lebih_awal }} Kali</h5></td></tr>
                        <tr><td><h5>Tidak Hadir : {{ $dataKaryawan->tidak_hadir }} Hari</h5></td></tr>
                        <tr><td><h5>Izin : {{ $dataKaryawan->izin }} Hari</h5></td></tr>
                        <tr><td><h5>Sakit : {{ $dataKaryawan->sakit }} Hari</h5></td></tr>
                        <tr><td><h5>Total Tidak Hadir dalam 1 Bulan : {{ $tidakHadir }} Hari</h5></td></tr>
                    </table> -->
                    <table>
                        <tr>
                            <td><h5>Terlambat 10 Menit</h5></td>
                            <td><h5>:</h5></td>
                            <td><h5>{{ $dataKaryawan->telat_10_menit }} Kali</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Terlambat 20 Menit</h5></td>
                            <td><h5>:</h5></td>
                            <td><h5>{{ $dataKaryawan->telat_20_menit }} Kali</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Terlambat 30 Menit</h5></td>
                            <td><h5>:</h5></td>
                            <td><h5>{{ $dataKaryawan->telat_30_menit }} Kali</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Terlambat Lebih 30 Menit</h5></td>
                            <td><h5>:</h5></td>
                            <td><h5>{{ $dataKaryawan->telat_lebih_dari_30_menit }} Kali</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Pulang Lebih Awal</h5></td>
                            <td><h5>:</h5></td>
                            <td><h5>{{ $dataKaryawan->pulang_lebih_awal }} Kali</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Pulang Lebih Awal</h5></td>
                            <td><h5>:</h5></td>
                            <td><h5>{{ $dataKaryawan->pulang_lebih_awal }} Kali</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Tidak Hadir</h5></td>
                            <td><h5>:</h5></td>
                            <td><h5>{{ $dataKaryawan->tidak_hadir }} Kali</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Izin</h5></td>
                            <td><h5>:</h5></td>
                            <td><h5>{{ $dataKaryawan->izin }} Kali</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Sakit</h5></td>
                            <td><h5>:</h5></td>
                            <td><h5>{{ $dataKaryawan->sakit  }} Kali</h5></td>
                        </tr>
                    </table>
                    <hr>
                    <h4>Gaji Pokok: Rp. {{ $gajiKaryawan }}</h4>
                    <h4>Potongan : Rp. {{ $potonganGaji }}</h4>
                    <hr>
                    <h4>Gaji Diterima: Rp. {{ $totalGaji }}</h4>
                </div>
            </div>
        </div>
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
@endpush