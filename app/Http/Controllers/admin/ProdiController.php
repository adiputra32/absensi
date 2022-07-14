<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Prodi;
use App\MataKuliah;
use App\Kelas;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodis = Prodi::get();

        return view('admin.prodi.prodi')->with(compact('prodis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.prodi.addProdi');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Prodi::create([
            'prodi' => $request['prodi'],
        ]);

        return redirect('admin/prodi')->with('success','Berhasil menambah Program Studi!');
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
        $prodi = Prodi::where('id_prodi',$id)->first();

        return view('admin.prodi.editProdi')->with(compact('prodi'));
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
        Prodi::where('id_prodi',$id)->update([
            'prodi' => $request['prodi'],
        ]);

        return redirect('admin/prodi')->with('success','Berhasil memperbarui Program Studi!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kelas = Kelas::where('id_prodi',$id)->first();
        $matkul = MataKuliah::where('id_prodi',$id)->first();
        $success = 0;
        if (empty($kelas) && empty($matkul)){
            $success = Prodi::where('id_prodi', $id)->delete();
        }

        if($success > 0){
            return redirect()->back()->with('success','Berhasil menghapus Program Studi!');
        } else {
            return redirect()->back()->with('error','Gagal menghapus Program Studi! Masih terdapat data kelas atau data mata kuliah dengan Program Studi tersebut!');
        }
    }
}
