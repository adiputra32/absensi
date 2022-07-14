<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Mahasiswa;
use App\MataKuliah;
use App\DetKelas;
use App\Kelas;
use App\TahunAkademik;
use App\AbsensiKelas;
use App\Http\Controllers\Controller;

class DetKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kelass = $request['id_kelas'];
        foreach ($kelass as $key => $kelas) {
            foreach($kelass as $key2 => $kelas2){
                if($key < $key2 && $kelas == $kelas2){
                    return redirect()->back()->with('error','Gagal menambah kelas, terdapat kelas yang sama!');
                }
            }

            $mulai = AbsensiKelas::where('id_kelas',$kelas)->count();
            $matkul = Kelas::where('id_kelas',$kelas)
            ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
            ->first();

            if ($mulai > 0) {
                return redirect()->back()->with('error','Gagal menambah kelas, absensi kelas ' . $matkul->kode_mata_kuliah . ' 
                    - ' . $matkul->mata_kuliah . ' (' . $matkul->kode_kelas . ') telah berlangsung sebanyak ' . $mulai . ' kali! Silakan kosongkan absensi terlebih dahulu jika ingin menambah kelas.');
            } 
        }

        foreach ($kelass as $key => $kelas) {
            DetKelas::create([
                'id_kelas' => $kelas,
                'id_mahasiswa' => $request['id_mahasiswa'],
            ]);
        }

        return redirect()->back()->with('success','Berhasil menambah kelas!');  
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $thnAkademiks = TahunAkademik::get();
        $thnAkademikSekarang = TahunAkademik::orderBy('id_thn_akademik', 'DESC')->first();
        $kelass = DetKelas::join('tb_kelas','tb_kelas.id_kelas','tb_det_kelas.id_kelas')
        ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->where('tb_kelas.id_thn_akademik',$thnAkademikSekarang->id_thn_akademik)
        ->where('tb_det_kelas.id_mahasiswa',$id)
        ->get();   

        $mahasiswa = Mahasiswa::where('id_mahasiswa',$id)->first();

        $filters = DetKelas::select('id_kelas')->where('id_mahasiswa',$id)->get();   
        $matkulFilters = Kelas::join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->where('tb_kelas.id_thn_akademik',$thnAkademikSekarang->id_thn_akademik)
        ->get();
        
        $matkuls = [];
        $loop = 0;
        foreach($matkulFilters as $key => $matkulFilter){
            $flag = 0;
            foreach($filters as $filter){
                if ($matkulFilter->id_kelas == $filter->id_kelas) {
                    $flag = 1;
                    break;
                }
            }
            if ($flag == 0) {
                $matkuls[$loop]['id_kelas'] = $matkulFilter->id_kelas;
                $matkuls[$loop]['kode_mata_kuliah'] = $matkulFilter->kode_mata_kuliah;
                $matkuls[$loop]['mata_kuliah'] = $matkulFilter->mata_kuliah;
                $matkuls[$loop]['kode_kelas'] = $matkulFilter->kode_kelas;
                $loop = $loop+1;
            } 
        }

        // return $matkuls;

        return view('admin.mahasiswa.addKelas')->with(compact('kelass','matkuls','mahasiswa','thnAkademiks','thnAkademikSekarang'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DetKelas::where('id_det_kelas', $id)->delete();

        return redirect()->back()->with('success','Berhasil menghapus kelas!');
    }

    public function detKelasRefresh(Request $request){      
        $kelass = DetKelas::join('tb_kelas','tb_kelas.id_kelas','tb_det_kelas.id_kelas')
        ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->where('tb_kelas.id_thn_akademik',$request->id_thn_akademik)
        ->where('tb_det_kelas.id_mahasiswa',$request->id_mahasiswa)
        ->get();   

        return $kelass;
    }
}
