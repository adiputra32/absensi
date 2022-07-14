<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Dosen;
use App\Pengampu;
use App\AbsensiKelas;
use App\Kelas;
use App\DetKelas;
use App\MataKuliah;
use App\TahunAkademik;
use App\Http\Controllers\Controller;

class PengampuController extends Controller
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
            Pengampu::create([
                'id_dosen' => $request['id_dosen'],
                'id_kelas' => $kelas,
                'status' => 'Aktif',
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
        $kelass = Pengampu::join('tb_dosen','tb_dosen.id_dosen','tb_pengampu.id_dosen','tb_kelas.kode_kelas')
        ->join('tb_kelas','tb_kelas.id_kelas','tb_pengampu.id_kelas')
        ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->where('tb_kelas.id_thn_akademik',$thnAkademikSekarang->id_thn_akademik)
        ->where('tb_pengampu.id_dosen',$id)
        ->where('tb_pengampu.status','Aktif')
        ->get();    
        
        $dosen = Dosen::where('id_dosen',$id)->first();
        
        $filters = Pengampu::select('id_kelas')->where('id_dosen',$id)->where('status','Aktif')->get();   
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

        return view('admin.dosen.addKelas')->with(compact('kelass','matkuls','dosen','thnAkademiks','thnAkademikSekarang'));
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
        Pengampu::where('id_pengampu', $id)->update([
            'status' => "Nonaktif"
        ]);
        
        return redirect()->back()->with('success','Berhasil menghapus kelas!');
    }

    public function pengampuRefresh(Request $request){
        $pengampus = Pengampu::join('tb_dosen','tb_dosen.id_dosen','tb_pengampu.id_dosen','tb_kelas.kode_kelas')
        ->join('tb_kelas','tb_kelas.id_kelas','tb_pengampu.id_kelas')
        ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->where('tb_kelas.id_thn_akademik',$request->id_thn_akademik)
        ->where('tb_pengampu.id_dosen',$request->id_dosen)
        ->where('tb_pengampu.status','Aktif')
        ->get();  

        return $pengampus;
    }
}
