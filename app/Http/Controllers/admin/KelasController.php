<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Kelas;
use App\DetKelas;
use App\Pengampu;
use App\AbsensiKelas;
use App\DetAbsensiKelas;
use App\MataKuliah;
use App\Prodi;
use App\TahunAkademik;
use App\Http\Controllers\Controller;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $thnAkademikSekarang = TahunAkademik::orderBy('id_thn_akademik', 'DESC')->first();
        $kelass = Kelas::join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->join('tb_prodi','tb_prodi.id_prodi','tb_mata_kuliah.id_prodi')
        ->where('id_thn_akademik',$thnAkademikSekarang['id_thn_akademik'])
        ->get();
        $thnAkademiks = TahunAkademik::get();
        
        return view('admin.kelas.kelas')->with(compact('kelass','thnAkademiks','thnAkademikSekarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $matkuls = MataKuliah::get();
        $prodis = Prodi::get();
        $thnAkademiks = TahunAkademik::orderBy('id_thn_akademik', 'DESC')->get();

        return view('admin.kelas.addKelas')->with(compact('matkuls','prodis','thnAkademiks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Kelas::create([
            'id_mata_kuliah' => $request['id_mata_kuliah'],
            'id_prodi' => $request['id_prodi'],
            'kode_kelas' => $request['kode_kelas'],
            'id_thn_akademik' => $request['id_thn_akademik'],
        ]);

        return redirect('admin/kelas')->with('success','Berhasil menambah kelas!');
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
        $kelas = Kelas::join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->join('tb_prodi','tb_prodi.id_prodi','tb_mata_kuliah.id_prodi')
        ->where('id_kelas',$id)
        ->first();
        $matkuls = MataKuliah::get();
        $prodis = Prodi::get();
        $thnAkademiks = TahunAkademik::orderBy('id_thn_akademik', 'DESC')->get();

        return view('admin.kelas.editKelas')->with(compact('kelas','matkuls','prodis','thnAkademiks'));
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
        Kelas::where('id_kelas',$id)->update([
            'id_mata_kuliah' => $request['id_mata_kuliah'],
            'id_prodi' => $request['id_prodi'],
            'kode_kelas' => $request['kode_kelas'],
            'id_thn_akademik' => $request['id_thn_akademik'],
        ]);

        return redirect('admin/kelas')->with('success','Berhasil memperbarui kelas!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detKelas = DetKelas::where('id_kelas', $id)->first();
        $pengampu = Pengampu::where('id_kelas', $id)->delete();
        $success = 1;
        if (empty($detKelas) || empty($pengampu)){
            $success = Kelas::where('id_kelas', $id)->delete();
        }

        if($success > 0){
            return redirect()->back()->with('success','Berhasil menghapus mata kuliah!');
        } else {
            return redirect()->back()->with('error','Gagal menghapus mata kuliah! Masih terdapat data kelas dengan mata kuliah tersebut!');
        }
    }

    public function kelasRefresh(Request $request){
        $kelas = Kelas::join('tb_thn_akademik','tb_thn_akademik.id_thn_akademik','tb_kelas.id_thn_akademik')
        ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->join('tb_prodi','tb_prodi.id_prodi','tb_mata_kuliah.id_prodi')
        ->where('tb_thn_akademik.id_thn_akademik', $request->id)
        ->get();

        return $kelas;
    }
}
