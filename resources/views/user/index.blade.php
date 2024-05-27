@extends('layout.app')

@section('title', 'Akun User')

@section('header', 'Akun User')

@section('content')
<a href="{{ route('divisi.create') }}" class="btn btn-primary btn-sm m-2">Tambah Data</a>
<table id="table" class="table table-hover">
<thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Opsi</th>
    </tr>
  </thead>
</table>
@endsection
@push('script')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap.min.js"></script> -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/divisi.js') }}"></script>

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