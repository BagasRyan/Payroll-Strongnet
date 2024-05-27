<?php

namespace App\Http\Controllers;

use Session;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DivisiController extends Controller
{
    public function index(){

        if(request()->ajax()){

            $data = DB::table('divisi')->get();

            return Datatables::of($data)
            ->addColumn('option', function($data){
                return '
                    <a href="'.route('divisi.edit', $data->id).'" class="btn btn-success btn-sm">Edit</a>
                    <button onclick="onDelete(this)" id="'.$data->id.'" name="'.$data->nama.'" class="btn btn-danger btn-sm">Hapus</button>
                ';
            })
            ->rawColumns(['option'])
            ->make();
        }

        return view('divisi.index');
    }

    public function create(){
        return view('divisi.create');
    }

    public function store(Request $request){

        DB::table('divisi')->insert([
            'nama' => $request->nama
        ]);

        return redirect()->route('divisi.index')->with('tambah', 'Data berhasil ditambahkan');
    }

    public function edit($id){

        $data = DB::table('divisi')->where('id', $id)->first();

        return view('divisi.edit', compact('data'));
    }

    public function update(Request $request){

        $id = $request->id;

        DB::table('divisi')->where('id', $id)->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('divisi.index')->with('update', 'Data berhasil diedit');
    }

    public function delete($id){
        DB::table('divisi')->where('id', $id)->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'status' => 'success'
        ]);
    }
}
