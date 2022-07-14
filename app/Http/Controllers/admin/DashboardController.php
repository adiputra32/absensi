<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\AbsensiKelas;
use App\AbsensiKegiatan;
use App\TahunAkademik;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $thnAkademiks = TahunAkademik::get();

        $thnAkademikSekarang = TahunAkademik::orderBy('id_thn_akademik', 'DESC')->first();

        $absens = AbsensiKelas::join('tb_kelas','tb_kelas.id_kelas','tb_absensi_kelas.id_kelas')
            ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
            ->where('id_thn_akademik', $thnAkademikSekarang['id_thn_akademik'])
            ->groupBy('tb_kelas.id_kelas')
            ->get();

        $kegiatans = AbsensiKegiatan::select('tb_absensi_kegiatan.*','tb_staff.nama_staff')
            ->join('tb_staff','tb_staff.id_staff','tb_absensi_kegiatan.id_staff')
            ->get();

        return view('admin.dashboard.index')->with(compact('absens','kegiatans','thnAkademiks','thnAkademikSekarang'));
    }

    public function absensiKelasRefresh(Request $request){
        $absens = AbsensiKelas::join('tb_kelas','tb_kelas.id_kelas','tb_absensi_kelas.id_kelas')
        ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->join('tb_pengampu','tb_pengampu.id_kelas','tb_kelas.id_kelas')
        ->join('tb_dosen','tb_dosen.id_dosen','tb_pengampu.id_dosen')
        ->join('tb_thn_akademik','tb_thn_akademik.id_thn_akademik','tb_kelas.id_thn_akademik')
        ->where('tb_pengampu.status','Aktif')
        ->where('tb_thn_akademik.id_thn_akademik', $request->id)
        ->groupBy('kode_kelas')
        ->get();

        return $absens;
    }
}
