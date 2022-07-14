<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;
use App\AbsensiKelas;
use App\DetAbsensiKelas;
use App\Dosen;
use App\Kelas;
use App\Pengampu;
use App\DetKelas;
use Auth;
use DateTime;
use App\DetAbsensiKelasDosen;
use App\Exports\AbsensiKelasExport;
use App\Exports\AbsensiKelasDosenExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class AbsensiKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $kelas = Kelas::join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->where('id_kelas', $id)
        ->first();

        return view('dosen.dashboard.addAbsensiKelas')->with(compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $absenKelas = AbsensiKelas::create([
            'id_kelas' => $request['id_kelas'],
            'materi' => $request['materi'],
            'metode' => $request['metode'],
            'mulai' => date('Y-m-d H:i:s', strtotime($request['mulai'])),
            'selesai' => date('Y-m-d H:i:s', strtotime($request['selesai'])),
        ]);
        
        $mahasiswas = DetKelas::select('tb_det_kelas.id_mahasiswa')
        ->join('tb_mahasiswa','tb_mahasiswa.id_mahasiswa','tb_det_kelas.id_mahasiswa')
        ->where('id_kelas',$request['id_kelas'])
        ->get();

        $dosens = Pengampu::select('tb_pengampu.id_dosen')
        ->join('tb_dosen','tb_dosen.id_dosen','tb_pengampu.id_dosen')
        ->where('id_kelas',$request['id_kelas'])
        ->where('tb_pengampu.status','Aktif')
        ->get();

        foreach ($mahasiswas as $mahasiswa) {
            DetAbsensiKelas::create([
                'id_absensi_kelas' => $absenKelas['id'],
                'id_mahasiswa' => $mahasiswa['id_mahasiswa'],
            ]);
        }

        foreach ($dosens as $dosen) {
            DetAbsensiKelasDosen::create([
                'id_absensi_kelas' => $absenKelas['id'],
                'id_dosen' => $dosen['id_dosen'],
            ]);
        }

        return redirect('/dosen/dashboard/' . $request['id_kelas'])->with('success','Berhasil membuat absensi kelas!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dosen = Dosen::where('id_user', Auth::user()->id)->first();

        $kelas = AbsensiKelas::where('id_absensi_kelas',$id)
        ->join('tb_kelas','tb_kelas.id_kelas','tb_absensi_kelas.id_kelas')
        ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->first();

        $absens = DetAbsensiKelas::where('tb_det_absensi_kelas.id_absensi_kelas',$id)
        ->join('tb_absensi_kelas','tb_absensi_kelas.id_absensi_kelas','tb_det_absensi_kelas.id_absensi_kelas')
        ->join('tb_mahasiswa','tb_mahasiswa.id_mahasiswa','tb_det_absensi_kelas.id_mahasiswa')
        ->get();

        $absenDosens = DetAbsensiKelasDosen::join('tb_absensi_kelas','tb_absensi_kelas.id_absensi_kelas','tb_det_absensi_kelas_dosen.id_absensi_kelas')
        ->join('tb_dosen','tb_dosen.id_dosen','tb_det_absensi_kelas_dosen.id_dosen')
        ->where('tb_det_absensi_kelas_dosen.id_absensi_kelas',$id)
        ->get();

        return view('dosen.dashboard.showAbsensiKelas')->with(compact('kelas','absens','dosen','absenDosens','id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_dosen = Dosen::select('id_dosen')->where('id_user',Auth::user()->id)->first();

        $absen = AbsensiKelas::where('id_absensi_kelas',$id)
        ->join('tb_kelas','tb_kelas.id_kelas','tb_absensi_kelas.id_kelas')
        ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->first();

        $kelass = Pengampu::where('id_dosen',$id_dosen->id_dosen)
        ->join('tb_kelas','tb_kelas.id_kelas','tb_pengampu.id_kelas')
        ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->get();
        
        return view('dosen.dashboard.editAbsensiKelas')->with(compact('kelass','absen'));
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
        AbsensiKelas::where('id_absensi_kelas',$id)->update([
            'id_kelas' => $request['id_kelas'],
            'mulai' => date('Y-m-d H:i:s', strtotime($request['mulai'])),
            'selesai' => date('Y-m-d H:i:s', strtotime($request['selesai'])),
        ]);

        return redirect('/dosen/dashboard/' . $request['id_kelas'])->with('success','Berhasil memperbarui absensi kelas!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AbsensiKelas::where('id_absensi_kelas', $id)->delete();

        return redirect()->back()->with('success','Berhasil menghapus data absensi kelas!');
    }

    public function translateToHari ($day) {
        switch ($day) {
          case 'Sunday':
            return 'Minggu';
          case 'Monday':
            return 'Senin';
          case 'Tuesday':
            return 'Selasa';
          case 'Wednesday':
            return 'Rabu';
          case 'Thursday':
            return 'Kamis';
          case 'Friday':
            return 'Jumat';
          case 'Saturday':
            return 'Sabtu';
          default:
            return 'hari tidak valid';
        }
    }

    public function updateStatus(Request $request, $id){
        $status = $request['status'];
        AbsensiKelas::where('id_absensi_kelas',$id)->update([
            'status' => $status,
        ]);

        if ($status == "Aktif") {
            return redirect()->back()->with('success','Berhasil mengaktifkan absensi kelas!');
        } elseif ($status == "Selesai") {
            return redirect()->back()->with('success','Berhasil mengubah status absensi kelas menjadi selesai!');
        } else {
            return redirect()->back();
        }       
    }

    public function updateMateriMetode(Request $request, $id){
        AbsensiKelas::where('id_absensi_kelas',$id)->update([
            'materi' => $request['materi'],
            'metode' => $request['metode'],
        ]);

        return redirect()->back()->with('success','Berhasil memperbarui data absensi kelas!');
    }

    public function absenDosen(Request $request, $id)
    {
        DetAbsensiKelasDosen::where('id_det_absensi_kelas_dosen',$id)->update([
            'absensi' => $request['absensi'],
        ]);

        return redirect()->back()->with('success','Berhasil memperbarui status absensi!');
    }

}
