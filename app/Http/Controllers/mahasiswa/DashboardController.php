<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\DetAbsensiKelas;
use App\AbsensiKelas;
use App\Mahasiswa;
use App\Kelas;
use App\TahunAkademik;
use App\Http\Controllers\Controller;
use Auth;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $thnAkademikSekarang = TahunAkademik::orderBy('id_thn_akademik', 'DESC')->first();
        $id_mahasiswa = Mahasiswa::select('id_mahasiswa')->where('id_user',Auth::user()->id)->first();

        $kelass = Kelas::join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->join('tb_det_kelas','tb_det_kelas.id_kelas','tb_kelas.id_kelas')
        ->where('tb_det_kelas.id_mahasiswa', $id_mahasiswa->id_mahasiswa)
        ->where('id_thn_akademik', $thnAkademikSekarang['id_thn_akademik'])
        ->get();

        return view('mahasiswa.dashboard.index')->with(compact('kelass'));
    }

    public function showListAbsensiKelas($id)
    {
        $id_mahasiswa = Mahasiswa::select('id_mahasiswa')->where('id_user',Auth::user()->id)->first();
        
        $kelas = Kelas::join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->where('id_kelas',$id)
        ->first();

        $absens = AbsensiKelas::join('tb_kelas','tb_kelas.id_kelas','tb_absensi_kelas.id_kelas')
        ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->join('tb_det_absensi_kelas','tb_det_absensi_kelas.id_absensi_kelas','tb_absensi_kelas.id_absensi_kelas')
        ->where('tb_det_absensi_kelas.id_mahasiswa', $id_mahasiswa->id_mahasiswa)
        ->where('tb_kelas.id_kelas',$id)
        ->orderBy('tb_absensi_kelas.id_absensi_kelas','ASC')
        ->get();

        return view('mahasiswa.dashboard.showListAbsensiKelas')->with(compact('absens','kelas'));
    }
}
