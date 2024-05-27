<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Session;
use DataTables;

class GajiBulananController extends Controller
{
    public function index(){

        $tanggal = DB::table('tanggal')->get();

        return view('gajiBulanan.index', compact('tanggal'));
    }

    public function createTanggal(){


        // PANGGIL SETIAP NAMA BULAN
        $bulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulan[] = Carbon::createFromDate(null, $i, 1)->format('F');
        }

        // dd($karyawan);

        return view('gajiBulanan.createTanggal', compact('bulan'));
    }

    public function storeTanggal(Request $request){

        DB::table('tanggal')->insert([
            'tahun' => $request->tahun,
            'bulan' => $request->bulan
        ]);

        return redirect()->route('gaji.bulanan.index')->with('tambah', 'Data berhasil ditambahkan');
    }

    public function detail($id){

        if(request()->ajax()){

            $dataGajiBulanan = DB::table('gaji_bulanan')->get();
            $data = [];

            foreach($dataGajiBulanan as $gaji){
                $nama = DB::table('karyawan')->where('id', $gaji->id_karyawan)->value('nama');
                $divisi = DB::table('divisi')->where('id', $gaji->id_divisi)->value('nama');

                $data[] = [

                    'nama' => $nama,
                    'divisi' => $divisi,
                    'tahun' => $gaji->tahun,
                    'bulan' => $gaji->bulan,
                    'gaji_pokok' => $gaji->gaji_pokok,
                    'potongan' => $gaji->potongan,
                ];
            }


            return Datatables::of($data)->make();
        }

        // AMBIL ID TANGGAL DARI URL
        $idTanggal = $id;
        
        $tahun = DB::table('tanggal')->where('id', $id)->value('tahun');
        $bulan = DB::table('tanggal')->where('id', $id)->value('bulan');

        return view('gajiBulanan.detail', compact('idTanggal', 'tahun', 'bulan'));
    }

    public function create($idTanggal){

        $dataKaryawan = DB::table('karyawan')->get();
        $dataDivisi = DB::table('divisi')->get();

        $tahun = DB::table('tanggal')->where('id', $idTanggal)->value('tahun');
        $bulan = DB::table('tanggal')->where('id', $idTanggal)->value('bulan');

        return view('gajiBulanan.create', compact('dataKaryawan', 'dataDivisi', 'tahun', 'bulan'));
    }

    public function store(Request $request){

        // LOGIKA POTONGAN GAJI
        $gaji = $request->gajiPokok;
        
        // POTONGAN JIKA TERLAMBAT 10 MENIT
        $jumlahTelat10Menit = $request->terlambat10;
        $potongan10Menit = 20000;
        $totalPotonganTelat10Menit = $jumlahTelat10Menit * $potongan10Menit;

        // POTONGAN JIKA TERLAMBAT 20 MENIT
        $jumlahTelat20Menit = $request->terlambat20;
        $potongan20Menit = 30000;
        $totalPotonganTelat20Menit =  $jumlahTelat20Menit * $potongan20Menit;

        // POTONGAN JIKA  TERLAMBAT 30 MENIT
        $jumlahTelat30Menit = $request->terlambat30;
        $potongan30Menit = 50000;
        $totalPotonganTelat30Menit = $jumlahTelat30Menit * $potongan30Menit;

        $gaji = $gaji - $totalPotonganTelat10Menit;

        dd($totalPotonganTelat10Menit);

        $namaKaryawan = DB::table('karyawan')->where('id', $request->idKaryawan)->value('nama');
        $divisi = DB::table('divisi')->where('id', $request->idDivisi)->value('nama');

        DB::table('absensi_karyawan')->insert([
            'nama' => $namaKaryawan,
            'divisi' => $divisi,
            'telat_10_menit' => $request->terlambat10,
            'telat_20_menit' => $request->terlambat20,
            'telat_30_menit' => $request->terlambat30,
            'telat_lebih_dari_30_menit' => $request->terlambatLebih30,
            'pulang_lebih_awal' => $request->pulangLebihAwal,
            'tidak_hadir' => $request->tidakMasuk,
            'izin' => $request->izin,
            'sakit' => $request->sakit
        ]);

        DB::table('gaji_bulanan')->insert([
            'id_karyawan' => $request->idKaryawan,
            'id_divisi' => $request->idDivisi,
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'gaji_pokok' => $request->gajiPokok,
        ]);

        return redirect()->route('gaji.bulanan.index');
    }
}