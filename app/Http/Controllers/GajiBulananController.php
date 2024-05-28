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

        // AMBIL ID TANGGAL DARI URL
        $idTanggal = $id;
        
        if(request()->ajax()){
             // AMBIL ID TANGGAL DARI URL
             $idTanggal = $id;
             
            $dataGajiBulanan = DB::table('gaji_bulanan')->get();
            $data = [];

            foreach($dataGajiBulanan as $gaji){
                $nama = DB::table('karyawan')->where('id', $gaji->id_karyawan)->value('nama');
                $divisi = DB::table('divisi')->where('id', $gaji->id_divisi)->value('nama');

                $data[] = [
                    
                    'id' => $gaji->id_karyawan,
                    'nama' => $nama,
                    'divisi' => $divisi,
                    'gaji_pokok' => $gaji->gaji_pokok,
                    'potongan' => $gaji->potongan,
                    'id_tanggal' => $idTanggal
                ];
            }



            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('option', function($data){
                return '
                <a href="'.route('gaji.bulanan.detail.karyawan', [$data['id'], $data['id_tanggal']]).'" class="btn btn-success btn-sm">Detail</a>
                ';
            })
            ->rawColumns(['option'])
            ->make();

        }

        
        $tahun = DB::table('tanggal')->where('id', $id)->value('tahun');
        $bulan = DB::table('tanggal')->where('id', $id)->value('bulan');

        return view('gajiBulanan.detail', compact('idTanggal', 'tahun', 'bulan'));
    }

    public function create($idTanggal){

        $dataKaryawan = DB::table('karyawan')->get();
        $dataDivisi = DB::table('divisi')->get();

        $tahun = DB::table('tanggal')->where('id', $idTanggal)->value('tahun');
        $bulan = DB::table('tanggal')->where('id', $idTanggal)->value('bulan');

        return view('gajiBulanan.create', compact('dataKaryawan', 'dataDivisi', 'tahun', 'bulan', 'idTanggal'));
    }

    public function store(Request $request){

        // AMBIL ID TANGGAL UNTUK REDIRECT
        $idTanggal = $request->idTanggal;

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

        // POTONGAN JIKA TERLAMBAT 30 MENIT
        $jumlahTelat30Menit = $request->terlambat30;
        $potongan30Menit = 50000;
        $totalPotonganTelat30Menit = $jumlahTelat30Menit * $potongan30Menit;

        // POTONGAN JIKA TERLAMBAT LEBIH DARI 30 MENIT
        $jumlahTelatLebih30Menit = $request->terlambatLebih30;
        $potonganLebih30Menit = 60000;
        $totalPotonganTelatLebih30Menit = $jumlahTelatLebih30Menit * $potonganLebih30Menit;

        // POTONGAN JIKA PULANG LEBIH AWAL
        $jumlahPulangLebihAwal = $request->pulangLebihAwal;
        $potonganPulangLebihAwal = 50000;
        $totalPotonganPulangLebihAwal = $jumlahPulangLebihAwal * $potonganPulangLebihAwal;

        // POTONGAN JIKA TIDAK HADIR
        $jumlahTidakHadir = $request->tidakMasuk;
        $potonganTidakMasuk = 100000;
        $totalPotonganTidakMasuk = $jumlahTidakHadir * $potonganTidakMasuk;

        // POTONGAN JIKA IZIN HADIR
        $jumlahIzin = $request->izin;
        $potonganIzin = 75000;
        $totalPotonganIzin = $jumlahIzin * $potonganIzin;

        // POTONGAN JIKA SAKIT
        $jumlahSakit = $request->sakit;
        $potonganSakit = 20000;
        $totalPotonganSakit = $jumlahSakit * $potonganSakit;


        // TOTAL POTONGAN GAJI
        $totalPotongan = $totalPotonganTelat10Menit + $totalPotonganTelat20Menit + $totalPotonganTelat30Menit + $totalPotonganTelatLebih30Menit
        + $totalPotonganPulangLebihAwal + $totalPotonganTidakMasuk + $totalPotonganIzin + $totalPotonganSakit;

        // GAJI KARYAWAN
        $gaji = $gaji - $totalPotongan;


        $namaKaryawan = DB::table('karyawan')->where('id', $request->idKaryawan)->value('nama');
        $divisi = DB::table('divisi')->where('id', $request->idDivisi)->value('nama');


        DB::beginTransaction();

        try {
    
            DB::table('absensi_karyawan')->insert([
                'id_karyawan' => $request->idKaryawan,
                'nama' => $namaKaryawan,
                'divisi' => $divisi,
                'tahun' => $request->tahun,
                'bulan' => $request->bulan,
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
                'potongan' => $totalPotongan
            ]);

            DB::commit();

            return redirect()->route('gaji.bulanan.detail', $idTanggal)->with('tambah', 'Data berhasil ditambahkan');

        } catch(\Exception $e){

            DB::rollback();

            // return response()->json([
            //     'message' => $e->getMessage(),
            //     'status' => 400
            // ]);

            return redirect()->back();
        }
    }


    public function detailKaryawan($idKaryawan, $idTanggal){

        $hari = Carbon::now();
        $totalHari = $hari->daysInMonth;

        // AMBIL BULAN DAN TAHUN BERDASARKAN ID TANGGAL
        $bulan = DB::table('tanggal')->where('id', $idTanggal)->value('bulan');
        $tahun = DB::table('tanggal')->where('id', $idTanggal)->value('tahun');

        $dataKaryawan = DB::table('absensi_karyawan')
                        ->where('id_karyawan', $idKaryawan)
                        ->where('bulan', $bulan)
                        ->where('tahun', $tahun)
                        ->first();

        $tidakHadir = $dataKaryawan->tidak_hadir + $dataKaryawan->izin + $dataKaryawan->sakit;
        // dd($totalTidakHadir);

        return view('gajiBulanan.detailKaryawan', compact('totalHari', 'dataKaryawan', 'tidakHadir'));
    }
}