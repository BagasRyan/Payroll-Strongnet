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

        if(request()->ajax()){
            $tableTanggal = DB::table('tanggal')->get();

            $data = [];
            foreach($tableTanggal as $item){

                $totalPengeluaran = number_format($item->total_pengeluaran, 0, ',', '.');

                $data[] = [
                    'id' => $item->id,
                    'tahun' => $item->tahun,
                    'bulan' => $item->bulan,
                    'total_karyawan' => $item->total_karyawan,
                    'total_pengeluaran' => $totalPengeluaran,
                ];
            }

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('option', function($data){
                return '
                <a href="'.route('gaji.bulanan.detail', $data['id']).'" class="btn btn-sm btn-primary">Lihat Detail</a>
                <button onclick="onDelete(this)" id="'.$data['id'].'" class="btn btn-sm btn-danger">Hapus</button>
                ';
            })
            ->rawColumns(['option'])
            ->make();
        }

        $tanggal = DB::table('tanggal')->get();
        // $dataBulanan = DB::table('data_bulanan')->get();

        // dd($dataBulanan);

        return view('gajiBulanan.index', compact('tanggal'));
    }

    public function createTanggal(){


        // PANGGIL SETIAP NAMA BULAN
        $bulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulan[] = Carbon::createFromDate(null, $i, 1)->format('F');
        }


        return view('gajiBulanan.createTanggal', compact('bulan'));
    }

    public function storeTanggal(Request $request){

        DB::table('tanggal')->insert([
            'tahun' => $request->tahun,
            'bulan' => $request->bulan
        ]);

        return redirect()->route('gaji.bulanan.index')->with('tambahTanggal', 'Data berhasil ditambahkan');
    }

    public function detail($id){

        // AMBIL ID TANGGAL DARI URL
        $idTanggal = $id;
        
        if(request()->ajax()){
             // AMBIL ID TANGGAL DARI URL
             $idTanggal = $id;
             
            $dataGajiBulanan = DB::table('gaji_bulanan')->where('id_tanggal', $idTanggal)->get();
            $data = [];

            foreach($dataGajiBulanan as $gaji){
                $nama = DB::table('karyawan')->where('id', $gaji->id_karyawan)->value('nama');
                $divisi = DB::table('divisi')->where('id', $gaji->id_divisi)->value('nama');

                $gajiPokok = number_format($gaji->gaji_pokok, 0, ',', '.');
                $potongan = number_format($gaji->potongan, 0, ',', '.');

                $data[] = [
                    'id' => $gaji->id,
                    'idKaryawan' => $gaji->id_karyawan,
                    'nama' => $nama,
                    'divisi' => $divisi,
                    'gaji_pokok' => $gajiPokok,
                    'potongan' => $potongan,
                    'id_tanggal' => $idTanggal
                ];
            }


            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('option', function($data){
                return '
                <a href="'.route('gaji.bulanan.detail.karyawan', [$data['idKaryawan'], $data['id_tanggal']]).'" class="btn btn-success btn-sm">Detail</a>
                <a href="'.route('gaji.bulanan.edit.karyawan', [$data['idKaryawan'], $data['id_tanggal']]).'" class="btn btn-sm btn-warning">Edit</a>
                <button onClick="onDelete(this)" id="'.$data['id'].'" class="btn btn-sm btn-danger">Hapus</button>
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
        // UBah dari 1.000.000 menjadi 1000000
        $gajiPokok = str_replace('.', '', $request->gajiPokok);
        
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
        $gaji = $gajiPokok - $totalPotongan;


        $namaKaryawan = DB::table('karyawan')->where('id', $request->idKaryawan)->value('nama');
        $divisi = DB::table('divisi')->where('id', $request->idDivisi)->value('nama');


        DB::beginTransaction();

        try {

            $gajiBulananId = DB::table('gaji_bulanan')->insertGetId([
                'id_karyawan' => $request->idKaryawan,
                'id_divisi' => $request->idDivisi,
                'id_tanggal' => $idTanggal,
                'tahun' => $request->tahun,
                'bulan' => $request->bulan,
                'gaji_pokok' => $gajiPokok,
                'potongan' => $totalPotongan
            ]);
    
            DB::table('absensi_karyawan')->insert([
                'id_karyawan' => $request->idKaryawan,
                'id_gaji_bulanan' => $gajiBulananId,
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

            $totalKaryawan = DB::table('gaji_bulanan')->where('id_tanggal', $idTanggal)->count('id_karyawan');

            // ENGHITUNG JUMLAH PENGELUARAN PERBULAN DENGAN CARA TOTAL GAJI DIKURANGI TOTAL POTONGAN
            $potongan = DB::table('gaji_bulanan')->where('id_tanggal', $idTanggal)->sum('potongan');
            $pengeluaran = DB::table('gaji_bulanan')->where('id_tanggal', $idTanggal)->sum('gaji_pokok');
            $totalPengeluaran = $pengeluaran - $potongan;


            DB::table('tanggal')->where('id', $idTanggal)->update([
                'total_karyawan' => $totalKaryawan,
                'total_pengeluaran' => $totalPengeluaran
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

        // AMBIL DATA GAJI KARYAWAN
        $gaji = DB::table('gaji_bulanan')->where('id_karyawan', $idKaryawan)->where('tahun', $tahun)->where('bulan', $bulan)->value('gaji_pokok');
        $gajiKaryawan = number_format($gaji, 0, ',', '.');
      
        $potongan = DB::table('gaji_bulanan')->where('id_karyawan', $idKaryawan)->where('tahun', $tahun)->where('bulan', $bulan)->value('potongan');
        $potonganGaji = number_format($potongan, 0, ',', '.');

        $total = $gaji - $potongan;
        $totalGaji = number_format($total, 0, ',', '.');

        $tidakHadir = $dataKaryawan->tidak_hadir + $dataKaryawan->izin + $dataKaryawan->sakit;
        // dd($totalTidakHadir);

        return view('gajiBulanan.detailKaryawan', compact('totalHari', 'dataKaryawan', 'tidakHadir', 'gajiKaryawan', 'potonganGaji', 'totalGaji'));
    }


    public function delete($idTanggal){
        $bulan = DB::table('tanggal')->where('id', $idTanggal)->value('bulan');
        $tahun = DB::table('tanggal')->where('id', $idTanggal)->value('tahun');

        DB::beginTransaction();
        try {

        DB::table('tanggal')->where('id', $idTanggal)->delete();
        DB::table('gaji_bulanan')->where('id_tanggal', $idTanggal)->delete();
        DB::table('absensi_karyawan')->where('bulan', $bulan)->where('tahun', $tahun)->delete();

        DB::commit();

        return redirect()->route('gaji.bulanan.index')->with('hapus', 'Data berhasil ditambahkan');
        } catch(\Exception $e){
            DB::rollback();

            return redirect()->back();
        }
    }

    public function edit($idKaryawan, $idTanggal){
        $dataKaryawan = DB::table('karyawan')->get();
        $dataDivisi = DB::table('divisi')->get();
        $bulan = DB::table('tanggal')->where('id', $idTanggal)->value('bulan');
        $tahun = DB::table('tanggal')->where('id', $idTanggal)->value('tahun');
        $gajiPokok = DB::table('gaji_bulanan')->where('id_karyawan', $idKaryawan)->where('bulan', $bulan)->where('tahun', $tahun)->value('gaji_pokok');
        $karyawan = DB::table('absensi_karyawan')->where('bulan', $bulan)->where('tahun', $tahun)->where('id_karyawan', $idKaryawan)->first();
        // dd($karyawan);

        return view('gajiBulanan.edit', compact('dataKaryawan', 'dataDivisi', 'karyawan', 'gajiPokok', 'idTanggal'));
    }

    public function update(Request $request){

        $id = $request->id;
        $idTanggal = $request->idTanggal;

        $gajiPokok = str_replace('.', '', $request->gajiPokok);
        
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

        // dd($totalPotongan);
        $bulan = DB::table('tanggal')->where('id', $idTanggal)->value('bulan');
        $tahun = DB::table('tanggal')->where('id', $idTanggal)->value('tahun');

        DB::beginTransaction();
        try {
            DB::table('absensi_karyawan')->where('id_karyawan', $id)->where('bulan', $bulan)->where('tahun', $tahun)->update([
                'nama' =>  $request->nama,
                'divisi' => $request->divisi,
                'telat_10_menit' => $request->terlambat10,
                'telat_20_menit' => $request->terlambat20,
                'telat_30_menit' => $request->terlambat30,
                'telat_lebih_dari_30_menit' => $request->terlambatLebih30,
                'pulang_lebih_awal' => $request->pulangLebihAwal,
                'tidak_hadir' => $request->tidakHadir,
                'izin' => $request->izin,
                'sakit' => $request->sakit
            ]);

            DB::table('gaji_bulanan')->where('id_karyawan', $id)->where('bulan', $bulan)->where('tahun', $tahun)->update([
                'gaji_pokok' => $gajiPokok,
                'potongan' => $totalPotongan
            ]);

            DB::commit();

            return redirect()->route('gaji.bulanan.detail', $idTanggal)->with('update', 'Data berhasil diedit');
        } catch(\Exception $e){
            DB::rollback();

            return redirect()->back();
        }
    }

    public function deleteKaryawan($id){

        $idTanggal = DB::table('gaji_bulanan')->where('id', $id)->value('id_tanggal');

        DB::beginTransaction();
        try {

        // HAPUS TERLEBIH DAHULU DATA DARI KEUDA TABEL INI
        DB::table('absensi_karyawan')->where('id_gaji_bulanan', $id)->delete();
        DB::table('gaji_bulanan')->where('id', $id)->delete();
            
        // LALU HITUNG KEMBALI JUMLAH DATA YANG ADA DI KEDUA TABEL  
        $totalKaryawan = DB::table('gaji_bulanan')->where('id_tanggal', $idTanggal)->count('id_karyawan');
        $totalPengeluaran = DB::table('gaji_bulanan')->where('id_tanggal', $idTanggal)->sum('gaji_pokok');
        DB::table('tanggal')->where('id', $idTanggal)->update([
            'total_karyawan' => $totalKaryawan,
            'total_pengeluaran' => $totalPengeluaran
        ]);

        DB::commit();

        return redirect()->route('gaji.bulanan.detail', $idTanggal)->with('hapus', 'Data berhasil dihapus');

        } catch(\Exception $e){
            DB::rollback();

            return redirect()->back();
        }
    }
}