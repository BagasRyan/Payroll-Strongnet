@extends('layout.app')

@section('title', 'Gaji Bulanan')

@section('header', 'Gaji Bulanan')

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
        <div class="row justify-content-center">
            <div>
                <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm m-2">Kembali</a>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Gaji Bulanan
                    </div>
                    <div class="card-body">
                        <form action="{{ route('gaji.bulanan.update') }}" method="POST">
                            @csrf
                            <label class="form-label">Data Diri Karyawan</label>
                            <div class="form-group">
                                <input type="hidden" name="id" value="{{ $karyawan->id_karyawan }}">
                                <input type="hidden" name="idTanggal" value="{{ $idTanggal }}">
                                <label class="form-label mt-3" for="nama">Nama</label>
                                <select class="form-control" name="nama">
                                    @foreach($dataKaryawan as $data)
                                    <option
                                    @if($data->nama == $karyawan->nama)
                                    selected
                                    @endif
                                     value="{{ $data->nama }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                                <label class="form-label mt-3" for="nama">Posisi</label>
                                <select class="form-control" name="divisi">
                                    @foreach($dataDivisi as $divisi)
                                    <option
                                    @if($divisi->nama == $karyawan->divisi)
                                    selected
                                    @endif
                                     value="{{ $divisi->nama }}">{{ $divisi->nama }}</option>
                                    @endforeach
                                </select>
                                <label class="form-label mt-3" for="nama">Gaji Pokok</label>
                                <input type="text" class="form-control" value="{{ $gajiPokok }}" onkeyup="formatCurrency(this)" name="gajiPokok" id="nama">
                                <hr>
                                <label class="form-label">Pemotongan Gaji</label>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label mt-3" for="nama">Total Telat 10 Menit</label>
                                        <input type="number" class="form-control" min="0" value="{{ $karyawan->telat_10_menit }}" name="terlambat10" id="nama">
                                        <label class="form-label mt-3" for="nama">Total Telat 20 Menit</label>
                                        <input type="number" class="form-control" min="0" value="{{ $karyawan->telat_20_menit }}" name="terlambat20" id="nama">
                                        <label class="form-label mt-3" for="nama">Total Telat 30 Menit</label>
                                        <input type="number" class="form-control" min="0" value="{{ $karyawan->telat_30_menit }}" name="terlambat30" id="nama">
                                        <label class="form-label mt-3" for="nama">Total Telat Lebih Dari 30
                                            Menit</label>
                                        <input type="number" class="form-control" min="0" value="{{ $karyawan->telat_lebih_dari_30_menit }}" name="terlambatLebih30" id="nama">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mt-3" for="nama">Pulang Lebih Awal</label>
                                        <input type="number" class="form-control" min='0' value="{{ $karyawan->pulang_lebih_awal }}" name="pulangLebihAwal" id="nama">
                                        <label class="form-label mt-3" for="nama">Tidak Masuk</label>
                                        <input type="number" class="form-control" min="0" value="{{ $karyawan->tidak_hadir }}" name="tidakMasuk" id="nama">
                                        <label class="form-label mt-3" for="nama">Izin Tidak Hadir</label>
                                        <input type="number" class="form-control" min="0" value="{{ $karyawan->izin }}" name="izin" id="nama">
                                        <label class="form-label mt-3" for="nama">Sakit</label>
                                        <input type="number" class="form-control" min="0" value="{{ $karyawan->sakit }}" name="sakit" id="nama">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>
function formatCurrency(input) {
    // Mengambil nilai inputan tanpa tanda titik
    var value = input.value.replace(/\./g, '');

    // Format dengan menambahkan titik setiap 3 digit dari belakang
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    // Memasukkan nilai yang sudah diformat kembali ke input
    input.value = value;
}
</script>
@endpush