<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;
use App\AbsensiKelas;
use App\Dosen;
use App\Kelas;
use App\TahunAkademik;
use App\Http\Controllers\Controller;
use Auth;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $thnAkademiks = TahunAkademik::get();
        $thnAkademikSekarang = TahunAkademik::orderBy('id_thn_akademik', 'DESC')->first();
        
        $id_dosen = Dosen::select('id_dosen')->where('id_user',Auth::user()->id)->first();

        $absens = Kelas::join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->join('tb_pengampu','tb_pengampu.id_kelas','tb_kelas.id_kelas')
        ->join('tb_dosen','tb_dosen.id_dosen','tb_pengampu.id_dosen')
        ->join('tb_thn_akademik','tb_thn_akademik.id_thn_akademik','tb_kelas.id_thn_akademik')
        ->where('tb_pengampu.id_dosen',$id_dosen->id_dosen)
        ->where('tb_thn_akademik.id_thn_akademik', $thnAkademikSekarang['id_thn_akademik'])
        ->orderBy('tb_kelas.id_kelas','ASC')
        ->get();

        return view('dosen.dashboard.index')->with(compact('absens','thnAkademiks','thnAkademikSekarang'));
    }

    public function absensiKelasRefresh(Request $request){
        $id_dosen = Dosen::select('id_dosen')->where('id_user',Auth::user()->id)->first();
        
        $absens = Kelas::join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->join('tb_pengampu','tb_pengampu.id_kelas','tb_kelas.id_kelas')
        ->join('tb_dosen','tb_dosen.id_dosen','tb_pengampu.id_dosen')
        ->join('tb_thn_akademik','tb_thn_akademik.id_thn_akademik','tb_kelas.id_thn_akademik')
        ->where('tb_pengampu.id_dosen',$id_dosen->id_dosen)
        ->where('tb_thn_akademik.id_thn_akademik', $request->id)
        ->where('tb_pengampu.status','Aktif')
        ->orderBy('tb_kelas.id_kelas','ASC')
        ->get();

        return $absens;
    }

    public function showListAbsensiKelas($id)
    {
        $id_dosen = Dosen::select('id_dosen')->where('id_user',Auth::user()->id)->first();
        $kelas = Kelas::join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->where('id_kelas',$id)
        ->first();

        $absens = AbsensiKelas::select('tb_absensi_kelas.id_absensi_kelas','tb_absensi_kelas.mulai','tb_absensi_kelas.selesai','tb_absensi_kelas.status')
        ->join('tb_kelas','tb_kelas.id_kelas','tb_absensi_kelas.id_kelas')
        ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->join('tb_pengampu','tb_pengampu.id_kelas','tb_kelas.id_kelas')
        ->join('tb_dosen','tb_dosen.id_dosen','tb_pengampu.id_dosen')
        ->where('tb_kelas.id_kelas',$id)
        ->where('tb_pengampu.id_dosen',$id_dosen->id_dosen)
        ->where('tb_pengampu.status','Aktif')
        ->orderBy('tb_absensi_kelas.id_absensi_kelas','ASC')
        ->get();

        return view('dosen.dashboard.showListAbsensiKelas')->with(compact('absens','kelas'));
    }
}
