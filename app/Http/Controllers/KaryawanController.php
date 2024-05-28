<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use Session;

class KaryawanController extends Controller
{
    public function index(){

        if(request()->ajax()){

            $data = DB::table('karyawan')->get();

            return DataTables::of($data)
            ->addColumn('option', function($data){
                return '
                <a href="'.route('karyawan.edit', $data->id).'" class="btn btn-sm btn-success">Edit</a>
                <button onclick="onDelete(this)" id="'.$data->id.'" name="'.$data->nama.'" class="btn btn-danger btn-sm">Hapus</button>
                ';
            })
            ->rawColumns(['option'])
            ->make();
        }

        // $karyawan = DB::table('karyawan')->get();

        // $array = [];
        // foreach($karyawan as $data => $item){

        //     $divisi = DB::table('divisi')->where('id', $item->id_divisi)->value('nama');


        //     $array[] = [
        //         'nama' => $item->nama,
        //         'divisi' => $divisi,
        //         'alamat' => $item->alamat
        //     ];
        // }
        // dd($array);

        return view('karyawan.index');
    }

    public function create(){

        $divisi = DB::table('divisi')->get();

        return view('karyawan.create', compact('divisi'));
    }

    public function store(Request $request){

        DB::table('karyawan')->insert([
            'nama' => $request->nama,
            'id_divisi' => $request->idDivisi,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telp,
            'email' => $request->email,
            'gaji_pokok' => $request->gajiPokok
        ]);
    }

    public function edit($id){
    
        $karyawan = DB::table('karyawan')->where('id', $id)->first();
        $divisi = DB::table('divisi')->get();

        return view('karyawan.edit', compact('karyawan', 'divisi'));
    }

    public function update(Request $request){
        $id = $request->id;

        DB::table('karyawan')->where('id', $id)->update([
            'nama' => $request->nama,
            'id_divisi' => $request->idDivisi,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telp,
            'email' => $request->email,
            'gaji_pokok' => $request->gajiPokok
        ]);

        return redirect()->route('karyawan.index')->with('update', 'Data berhasil diedit');
    }

    public function delete($id){
        $delete = DB::table('karyawan')->where('id', $id)->delete();

        if($delete){
            return response()->json([
                'message' => 'Data berhasil dihapus',
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'message' => 'Data gagal dihapus',
                'status' => 'error'
            ]);
        }
    }
}
