<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\AbsensiKegiatan;
use App\DetAbsensiKegiatan;
use App\Staff;
use Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $id_staff = Staff::select('id_staff')->where('id_user',Auth::user()->id)->first();

        $absens = DetAbsensiKegiatan::join('tb_absensi_kegiatan','tb_absensi_kegiatan.id_absensi_kegiatan','tb_det_absensi_kegiatan.id_absensi_kegiatan')
            ->where('tb_det_absensi_kegiatan.id_staff',$id_staff->id_staff)
            ->where('tb_absensi_kegiatan.status','!=','Selesai')
            ->orderBy('mulai','ASC')
            ->orderBy('status','ASC')
            ->get();

        return view('staff.dashboard.index')->with(compact('absens'));
    }

    public function absen(Request $request, $id)
    {
        DetAbsensiKegiatan::where('id_det_absensi_kegiatan',$id)->update([
            'absensi' => $request['absensi'],
        ]);

        return redirect()->back()->with('success','Berhasil memperbarui status absensi!');
    }
}
