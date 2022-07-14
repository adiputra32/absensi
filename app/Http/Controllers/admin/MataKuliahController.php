<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MataKuliah;
use App\Kelas;
use App\Prodi;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matkuls = MataKuliah::join('tb_prodi','tb_prodi.id_prodi','tb_mata_kuliah.id_prodi')->get();

        return view('admin.mataKuliah.mataKuliah')->with(compact('matkuls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prodis = Prodi::get();

        return view('admin.mataKuliah.addMataKuliah')->with(compact('prodis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MataKuliah::create([
            'mata_kuliah' => $request['mata_kuliah'],
            'id_prodi' => $request['id_prodi'],
            'kode_mata_kuliah' => $request['kode_mata_kuliah'],
        ]);

        return redirect('admin/mata-kuliah')->with('success','Berhasil menambah mata kuliah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $matkul = MataKuliah::where('id_mata_kuliah',$id)
        ->join('tb_prodi','tb_prodi.id_prodi','tb_mata_kuliah.id_prodi')
        ->first();
        $prodis = Prodi::get();

        return view('admin.mataKuliah.editMataKuliah')->with(compact('matkul','prodis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        MataKuliah::where('id_mata_kuliah',$id)->update([
            'mata_kuliah' => $request['mata_kuliah'],
            'id_prodi' => $request['id_prodi'],
            'kode_mata_kuliah' => $request['kode_mata_kuliah'],
        ]);

        return redirect('admin/mata-kuliah')->with('success','Berhasil memperbarui mata kuliah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kelas = Kelas::where('id_mata_kuliah',$id)->first();
        $success = 0;
        if (empty($kelas)){
            $success = MataKuliah::where('id_mata_kuliah', $id)->delete();
        }

        if($success > 0){
            return redirect()->back()->with('success','Berhasil menghapus mata kuliah!');
        } else {
            return redirect()->back()->with('error','Gagal menghapus mata kuliah! Masih terdapat data kelas dengan mata kuliah tersebut!');
        }
    }
}
