<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\AbsensiKegiatan;
use App\Staff;
use App\Dosen;
use Auth;
use App\DetAbsensiKegiatan;
use App\Exports\AbsensiKegiatanExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use DB;

class AbsensiKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_staff = Staff::select('id_staff')->where('id_user',Auth::user()->id)->first();

        $absens = DetAbsensiKegiatan::join('tb_absensi_kegiatan','tb_absensi_kegiatan.id_absensi_kegiatan','tb_det_absensi_kegiatan.id_absensi_kegiatan')
        ->where('tb_det_absensi_kegiatan.id_staff',$id_staff->id_staff)
        ->orderBy('id_det_absensi_kegiatan','DESC')
        ->orderBy('mulai','ASC')
        ->get();

        return view('admin.absensiKegiatan.index')->with(compact('absens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.addAbsensiKegiatan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_staff = Staff::select('id_staff')->where('id_user',Auth::user()->id)->first();
        $absenKegiatan = AbsensiKegiatan::create([
            'nama_kegiatan' => $request['nama_kegiatan'],
            'id_staff' => $id_staff->id_staff,
            'mulai' => date('Y-m-d H:i:s', strtotime($request['mulai'])),
            'selesai' => date('Y-m-d H:i:s', strtotime($request['selesai'])),
        ]);

        $id_dosens = Dosen::select('id_dosen')->get();
        $id_staffs = Staff::select('id_staff')->where('jenis_staff','!=','Admin')->get();

        foreach($id_dosens as $id_dosen){
            DetAbsensiKegiatan::create([
                'id_absensi_kegiatan' => $absenKegiatan['id'],
                'id_dosen' => $id_dosen->id_dosen,
            ]);
        }

        foreach($id_staffs as $id_staff){
            DetAbsensiKegiatan::create([
                'id_absensi_kegiatan' => $absenKegiatan['id'],
                'id_staff' => $id_staff->id_staff,
            ]);
        }

        return redirect('/admin/dashboard')->with('success','Berhasil membuat absensi kegiatan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kegiatan = AbsensiKegiatan::where('id_absensi_kegiatan',$id)->first();

        $absens = DetAbsensiKegiatan::where('id_absensi_kegiatan',$id)
            ->leftJoin('tb_dosen','tb_dosen.id_dosen','tb_det_absensi_kegiatan.id_dosen')
            ->leftJoin('tb_staff','tb_staff.id_staff','tb_det_absensi_kegiatan.id_staff')
            ->get();

            // return $absens;

        return view('admin.dashboard.showAbsensiKegiatan')->with(compact('kegiatan','absens'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kegiatan = AbsensiKegiatan::where('id_absensi_kegiatan',$id)->first();

        return view('admin.dashboard.editAbsensiKegiatan')->with(compact('kegiatan'));
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
        AbsensiKegiatan::where('id_absensi_kegiatan',$id)->update([
            'nama_kegiatan' => $request['nama_kegiatan'],
            'mulai' => date('Y-m-d H:i:s', strtotime($request['mulai'])),
            'selesai' => date('Y-m-d H:i:s', strtotime($request['selesai'])),
        ]);

        return redirect('/admin/dashboard')->with('success','Berhasil memperbarui absensi kegiatan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AbsensiKegiatan::where('id_absensi_kegiatan', $id)->delete();
        DetAbsensiKegiatan::where('id_absensi_kegiatan', $id)->delete();

        return redirect('admin/dashboard')->with('success','Berhasil menghapus data absensi kegiatan!');
    }

    public function exportExcel($id)
    {
        $nama_file =  AbsensiKegiatan::select('nama_kegiatan')
            ->where('id_absensi_kegiatan',$id)
            ->where('status','Selesai')
            ->first();

        if(empty($nama_file)){
            return redirect()->back()->with('error','Gagal, data absensi belum selesai!');
        }

        $tanggal_kegiatan =  AbsensiKegiatan::select('mulai')
            ->where('id_absensi_kegiatan',$id)
            ->first()
	    ->mulai;

	$hari = self::hariIndo(date('D', strtotime($tanggal_kegiatan)));
	$tgl = date('d-m-Y', strtotime($tanggal_kegiatan));

        $array = [];
        $array = [
            ["Politeknik Kesehatan Kartini Bali"],
            [null],
            ["Jln. Piranha No. 2 Pegok Sesetan Denpasar. Telp (0361) 7446292"],
            ["Email: akkb2008@yahoo.co.id, Website: www.akbidkartinibali.ac.id"],
            [null, null, null, "Program Studi Kebidanan Terakreditasi B", null, null, null, null, "Institusi Terakreditasi B"],
            [null, null, null, "Nomor : 026/BAN-PT/Ak-XI/DpI-III/XII/2011", null, null, null, null, "Nomor: 1313/SK/BAN-PT/Akred/PT/V/2017"],
            [null],
            [null],
            ["DAFTAR HADIR"],
            [strtoupper($nama_file->nama_kegiatan)],
            ["Tanggal : " . $hari . ", " . $tgl,null],
            ["No", "Nama", null, null, null, null, null, null, null, "Jabatan", null, null, "Kehadiran", null, null],
        ];

        $datas = DetAbsensiKegiatan::select('nama_dosen','nama_staff','absensi','jenis_dosen','created_at')
            ->where('id_absensi_kegiatan',$id)
            ->leftJoin('tb_dosen','tb_dosen.id_dosen','tb_det_absensi_kegiatan.id_dosen')
            ->leftJoin('tb_staff','tb_staff.id_staff','tb_det_absensi_kegiatan.id_staff')
            ->orderBy('nama_staff','ASC')
            ->orderByRaw("FIELD(jenis_dosen , 'Dosen Koordinator', 'Dosen') ASC")
            ->get();

        $startArray = 13;
        foreach ($datas as $key => $data){
            if ($data['absensi'] == "Hadir") {
                $absensi = date('H:i', strtotime($data['created_at']));
            } elseif ($data['absensi'] == "Piket") {
                $absensi = date('H:i', strtotime($data['created_at'])) . " (Piket)";		
	    } else {
                $absensi = $data['absensi'];
            }
            if(!empty($data['nama_staff'])){
                $array[$startArray+$key] = [
                    $key+1, $data['nama_staff'], null, null, null, null, null, null, null, "Staff", null, null, $absensi, null, null
                ];
            } else{
                $array[$startArray+$key] = [
                    $key+1, $data['nama_dosen'], null, null, null, null, null, null, null, $data['jenis_dosen'], null, null, $absensi, null, null
                ];
            }
        }

        return Excel::download(new AbsensiKegiatanExport($array), date('Ymd') . '_Absensi Kegiatan.xlsx');
    }

    public function absen(Request $request, $id)
    {
        DetAbsensiKegiatan::where('id_det_absensi_kegiatan',$id)->update([
            'absensi' => $request['absensi'],
        ]);

        return redirect()->back()->with('success','Berhasil memperbarui status absensi!');
    }

    public function updateStatus(Request $request, $id){
        $status = $request['status'];
        AbsensiKegiatan::where('id_absensi_kegiatan',$id)->update([
            'status' => $status,
        ]);

        if ($status == "Aktif") {
            return redirect('/admin/dashboard')->with('success','Berhasil mengaktifkan absensi kegiatan!');
        } elseif ($status == "Selesai") {
            return redirect('/admin/dashboard')->with('success','Berhasil mengubah status absensi kegiatan menjadi selesai!');
        } else {
            return redirect('/admin/dashboard');
        }       
    }

    public function hariIndo ($hariInggris) {
        switch ($hariInggris) {
          case 'Sun':
            return 'Minggu';
          case 'Mon':
            return 'Senin';
          case 'Tue':
            return 'Selasa';
          case 'Wed':
            return 'Rabu';
          case 'Thu':
            return 'Kamis';
          case 'Fri':
            return 'Jumat';
          case 'Sat':
            return 'Sabtu';
          default:
            return ' ';
        }
    }
}
