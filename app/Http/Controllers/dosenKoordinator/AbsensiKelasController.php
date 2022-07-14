<?php

namespace App\Http\Controllers\DosenKoordinator;

use Illuminate\Http\Request;
use App\AbsensiKelas;
use App\DetAbsensiKelas;
use App\Dosen;
use App\Kelas;
use App\Pengampu;
use App\DetKelas;
use Auth;
use DB;
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

        return view('dosenKoordinator.dashboard.addAbsensiKelas')->with(compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	$mahasiswas = DetKelas::select('tb_det_kelas.id_mahasiswa')
        ->join('tb_mahasiswa','tb_mahasiswa.id_mahasiswa','tb_det_kelas.id_mahasiswa')
        ->where('id_kelas',$request['id_kelas'])
        ->count();

	if($mahasiswas < 1){
		return redirect('/dosen-koordinator/dashboard/' . $request['id_kelas'])->with('error','Gagal membuat absensi kelas! Belum ada data mahasiswa.');
	}

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
        ->where('tb_pengampu.status','Aktif')
        ->where('id_kelas',$request['id_kelas'])
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

        return redirect('/dosen-koordinator/dashboard/' . $request['id_kelas'])->with('success','Berhasil membuat absensi kelas!');
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

        return view('dosenKoordinator.dashboard.showAbsensiKelas')->with(compact('kelas','absens','dosen','absenDosens','id'));
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
        
        return view('dosenKoordinator.dashboard.editAbsensiKelas')->with(compact('kelass','absen'));
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

        return redirect('/dosen-koordinator/dashboard/' . $request['id_kelas'])->with('success','Berhasil memperbarui absensi kelas!');
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
	DetAbsensiKelas::where('id_absensi_kelas', $id)->delete();

        return redirect()->back()->with('success','Berhasil menghapus data absensi kelas!');
    }

    public function exportExcel($id, $smt)
    {
	$kelass =  AbsensiKelas::where('tb_absensi_kelas.id_kelas',$id)
            ->join('tb_kelas','tb_kelas.id_kelas','tb_absensi_kelas.id_kelas')
            ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
            ->join('tb_thn_akademik','tb_thn_akademik.id_thn_akademik','tb_kelas.id_thn_akademik')
            ->where('tb_absensi_kelas.status', 'Selesai')
            ->count();

	if($kelass < 1){
		return redirect()->back()->with('error','Gagal export data absensi! Belum ada data absensi kelas.');
	}

        $angkatan = DetKelas::select('angkatan')
            ->where('tb_det_kelas.id_kelas',$id)
            ->join('tb_mahasiswa','tb_mahasiswa.id_mahasiswa','tb_det_kelas.id_mahasiswa')
            ->join('tb_thn_akademik','tb_thn_akademik.id_thn_akademik','tb_mahasiswa.id_thn_akademik')
            ->groupBy('tb_mahasiswa.id_thn_akademik')
            ->orderByRaw('COUNT(*) DESC')
            ->first()
            ->angkatan;
        
        $kls = Kelas::join('tb_prodi','tb_prodi.id_prodi','tb_kelas.id_prodi')
            ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
            ->join('tb_thn_akademik','tb_thn_akademik.id_thn_akademik','tb_kelas.id_thn_akademik')
            ->where('id_kelas',$id)
            ->first();

        $kelass =  AbsensiKelas::where('tb_absensi_kelas.id_kelas',$id)
            ->join('tb_kelas','tb_kelas.id_kelas','tb_absensi_kelas.id_kelas')
            ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
            ->join('tb_thn_akademik','tb_thn_akademik.id_thn_akademik','tb_kelas.id_thn_akademik')
            ->where('tb_absensi_kelas.status', 'Selesai')
            ->get();

        $kelassCount =  AbsensiKelas::where('tb_absensi_kelas.id_kelas',$id)
            ->join('tb_kelas','tb_kelas.id_kelas','tb_absensi_kelas.id_kelas')
            ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
            ->join('tb_thn_akademik','tb_thn_akademik.id_thn_akademik','tb_kelas.id_thn_akademik')
            ->where('tb_absensi_kelas.status', 'Selesai')
            ->count();
        
        $dosenKoor = Pengampu::join('tb_dosen','tb_dosen.id_dosen','tb_pengampu.id_dosen')
            ->where('jenis_dosen','Dosen Koordinator')
            ->where('id_kelas',$id)
            ->first();

        if ($smt == "UAS") {
            if($kelassCount <= 7){
                return redirect()->back()->with('error','Tidak ada data absensi yang telah selesai!');
            }
        } elseif ($smt == "UTS"){
            if(empty($kelass[0])){
                return redirect()->back()->with('error','Tidak ada data absensi yang telah selesai!');
            }
        } 
        $nama_file = "Data Absensi Mahasiswa Kelas " . $kelass[0]->mata_kuliah;

        $array = [];
        $array = [
            ["Politeknik Kesehatan Kartini Bali"],
            ["Program Studi " . $kls->prodi],
            ["Jln. Piranha No. 2 Pegok Sesetan Denpasar. Telp (0361) 7446292"],
            ["Email: akkb2008@yahoo.co.id, Website: www.akbidkartinibali.ac.id"],
            [null, null, null, "Program Studi Kebidanan Terakreditasi B", null, null, null, null, "Institusi Terakreditasi B"],
            [null, null, null, "Nomor : 026/BAN-PT/Ak-XI/DpI-III/XII/2011", null, null, null, null, "Nomor: 1313/SK/BAN-PT/Akred/PT/V/2017"],
            [null],
            [null],
            ["DAFTAR HADIR MAHASISWA PROGRAM STUDI " . strtoupper($kls->prodi)],
            ["POLITEKNIK KESEHATAN KARTINI BALI"],
            ["ANGKATAN " . $angkatan],
            [null],
            ["MATA KULIAH", null, ": " . $kls->mata_kuliah],
            ["SEMESTER", null, ": " . $kls->semester],
            ["BULAN/TAHUN", null, ":"],
            [null],
            ["No Urut", "Nama Mahasiswa", null, null, null, "NIM", null, "Tanggal", null, null, null, null, null, null, "Jumlah Kehadiran"],
        ];

        $tgl = [];
        $tgl = [null, null, null, null, null, null, null, null, null, null, null, null, null, null, null];

        $detAbsensiKelass = DetAbsensiKelas::select('nim_mahasiswa','nama_mahasiswa','absensi','created_at', 'tb_det_absensi_kelas.id_absensi_kelas')
            ->join('tb_mahasiswa','tb_mahasiswa.id_mahasiswa','tb_det_absensi_kelas.id_mahasiswa')
            ->join('tb_absensi_kelas','tb_absensi_kelas.id_absensi_kelas','tb_det_absensi_kelas.id_absensi_kelas')
            ->join('tb_kelas','tb_kelas.id_kelas','tb_absensi_kelas.id_kelas')
            ->where('tb_absensi_kelas.id_kelas',$id)
            ->get();

        $countKehadiran = [];
        foreach ($kelass as $key => $kelas) {
            if($smt == "UTS" && $key < 7){
                $loopKey2 = 0;
                $tgl[$key+7] = date('d/m/y', strtotime($kelas->mulai));
                $array[17] = $tgl;
                
                foreach ($detAbsensiKelass as $key2 => $detAbsensiKelas) {
                    if ($detAbsensiKelas->id_absensi_kelas == $kelas->id_absensi_kelas) {
                        if($key == 0){
                            if ($detAbsensiKelas->absensi == "Hadir") {
                                $ttd = date("H.i", strtotime($detAbsensiKelas->created_at));
                                $kehadiranFirstLoop = 1;
                            } else{
                                $ttd = $detAbsensiKelas->absensi;
                                $kehadiranFirstLoop = "0";
                            } 
            
                            $array[$loopKey2+18] = [
                                $loopKey2+1,
                                $detAbsensiKelas->nama_mahasiswa,
                                null, 
                                null, 
                                null,
                                $detAbsensiKelas->nim_mahasiswa,
                                null,
                                $ttd,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                $kehadiranFirstLoop,
                            ];
                        } elseif($key < 7) {
                            if ($detAbsensiKelas->absensi == "Hadir") {
                                $ttd = date("H.i", strtotime($detAbsensiKelas->created_at));
                                $array[$loopKey2+18][14] = (int)$array[$loopKey2+18][14]+1;
                            } else{
                                $ttd = $detAbsensiKelas->absensi;
                            } 
            
                            $array[$loopKey2+18][$key+7] = $ttd;
                        } else{
                            break;
                        }
                        $loopKey2 = $loopKey2+1;
                    }
                }
            } elseif($smt == "UAS" && $key >= 7){
                $loopKey2 = 0;
                $tgl[$key] = date('d/m/y', strtotime($kelas->mulai));
                $array[17] = $tgl;
                
                foreach ($detAbsensiKelass as $key2 => $detAbsensiKelas) {
                    if ($detAbsensiKelas->id_absensi_kelas == $kelas->id_absensi_kelas) {
                        if($key == 7){
                            if ($detAbsensiKelas->absensi == "Hadir") {
                                $ttd = date("H.i", strtotime($detAbsensiKelas->created_at));
                                $kehadiranFirstLoop = 1;
                            } else{
                                $ttd = $detAbsensiKelas->absensi;
                                $kehadiranFirstLoop = "0";
                            } 
            
                            $array[$loopKey2+18] = [
                                $loopKey2+1,
                                $detAbsensiKelas->nama_mahasiswa,
                                null, 
                                null, 
                                null,
                                $detAbsensiKelas->nim_mahasiswa,
                                null,
                                $ttd,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                $kehadiranFirstLoop,
                            ];
                        } elseif($key > 7) {
                            if ($detAbsensiKelas->absensi == "Hadir") {
                                $ttd = date("H.i", strtotime($detAbsensiKelas->created_at));
                                $array[$loopKey2+18][14] = $array[$loopKey2+18][14]+1;
                            } else{
                                $ttd = $detAbsensiKelas->absensi;
                            } 
            
                            $array[$loopKey2+18][$key] = $ttd;
                        } else{
                            break;
                        }
                        $loopKey2 = $loopKey2+1;
                    }
                }
            } 
        }
        $array[$loopKey2+18] = [null];
        $array[$loopKey2+19] = [null];
        $array[$loopKey2+20] = [null, "Mengetahui", null, null, null, null, null, null, null, null, "Denpasar, " . date('d-m-Y')];
        $array[$loopKey2+21] = [null, "Politeknik Kesehatan Kartini Bali", null, null, null, null, null, null, null, null, "Koordinator Mata Kuliah"];
        $array[$loopKey2+22] = [null, "Kepala Program Studi " . $kls->prodi];
        $array[$loopKey2+23] = [null];
        $array[$loopKey2+24] = [null];
        $array[$loopKey2+25] = [null];
        $array[$loopKey2+26] = [null, null, null, null, null, null, null, null, null, null, $dosenKoor->nama_dosen];
        $array[$loopKey2+27] = [null, "NIDN: ", null, null, null, null, null, null, null, null, "NIDN: " . $dosenKoor->nidn];
        // return $array;

        return Excel::download(new AbsensiKelasExport($array, $loopKey2+18), date('Ymd').'_'.$nama_file.'.xlsx');
    }

    public function exportExcelDosen($id)
    {
	$kelass =  AbsensiKelas::where('tb_absensi_kelas.id_kelas',$id)
            ->join('tb_kelas','tb_kelas.id_kelas','tb_absensi_kelas.id_kelas')
            ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
            ->join('tb_thn_akademik','tb_thn_akademik.id_thn_akademik','tb_kelas.id_thn_akademik')
            ->where('tb_absensi_kelas.status', 'Selesai')
            ->count();

	if($kelass < 1){
		return redirect()->back()->with('error','Gagal export data absensi! Belum ada data absensi kelas.');
	}
	
        $angkatan = DetKelas::select('angkatan','thn_akademik_1','thn_akademik_2')
            ->where('tb_det_kelas.id_kelas',$id)
            ->join('tb_mahasiswa','tb_mahasiswa.id_mahasiswa','tb_det_kelas.id_mahasiswa')
            ->join('tb_thn_akademik','tb_thn_akademik.id_thn_akademik','tb_mahasiswa.id_thn_akademik')
            ->groupBy('tb_mahasiswa.id_thn_akademik')
            ->orderByRaw('COUNT(*) DESC')
            ->first();
        
        $kls = Kelas::join('tb_prodi','tb_prodi.id_prodi','tb_kelas.id_prodi')
            ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
            ->join('tb_thn_akademik','tb_thn_akademik.id_thn_akademik','tb_kelas.id_thn_akademik')
            ->where('id_kelas',$id)
            ->first();

        $dosenKoor = Pengampu::join('tb_dosen','tb_dosen.id_dosen','tb_pengampu.id_dosen')
            ->where('jenis_dosen','Dosen Koordinator')
            ->where('id_kelas',$id)
            ->first();

        $kelass =  AbsensiKelas::where('tb_absensi_kelas.id_kelas',$id)
            ->join('tb_kelas','tb_kelas.id_kelas','tb_absensi_kelas.id_kelas')
            ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
            ->join('tb_thn_akademik','tb_thn_akademik.id_thn_akademik','tb_kelas.id_thn_akademik')
            ->where('tb_absensi_kelas.status', 'Selesai')
            ->get();

        if(empty($kelass[0])){
            return redirect()->back()->with('error','Tidak ada data absensi yang telah selesai!');
        }

        $nama_file = "Data Jurnal dan Absensi Dosen Kelas " . $kelass[0]->mata_kuliah;

        $array = [];
        
        $array = [
            ["Politeknik Kesehatan Kartini Bali"],
            ["Program Studi " . $kls->prodi],
            ["Jln. Piranha No. 2 Pegok Sesetan Denpasar. Telp (0361) 7446292"],
            ["Email: akkb2008@yahoo.co.id, Website: www.akbidkartinibali.ac.id"],
            [null, null, null, "Program Studi Kebidanan Terakreditasi B", null, null, null, null, "Institusi Terakreditasi B"],
            [null, null, null, "Nomor : 026/BAN-PT/Ak-XI/DpI-III/XII/2011", null, null, null, null, "Nomor: 1313/SK/BAN-PT/Akred/PT/V/2017"],
            [null],
            [null],
            ["DAFTAR HADIR DOSEN"],
            [null],
            ["Mata Kuliah", null, null, ": " . $kls->mata_kuliah, null, null, null, null, null, null, null, "Semester", ": " . $kls->semester, null, null],
            ["Tahun Ajaran / Angkatan", null, null, ": " . $angkatan->thn_akademik_1 . "/" . $angkatan->thn_akademik_2 . " / " . $angkatan->angkatan, null, null, null, null, null, null, null, "Bobot", ": ", null, null],
            [null],
            ["No", "Hari / Tanggal / Jam", null, "Materi / Topik Pembelajaran", null, null, null, null, "Metode", null, null, null, null, "Tanda Tangan", null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            ["DAFTAR HADIR DOSEN"],
            [null],
            ["Mata Kuliah", null, null, ": " . $kls->mata_kuliah, null, null, null, null, null, null, null, "Semester", ": " . $kls->semester, null, null],
            ["Tahun Ajaran / Angkatan", null, null, ": " . $angkatan->thn_akademik_1 . "/" . $angkatan->thn_akademik_2 . " / " . $angkatan->angkatan, null, null, null, null, null, null, null, "Bobot", ": ", null, null],
            [null],
            ["No", "Hari / Tanggal / Jam", null, "Materi / Topik Pembelajaran", null, null, null, null, "Metode", null, null, null, null, "Tanda Tangan", null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            ["DAFTAR HADIR DOSEN"],
            [null],
            ["Mata Kuliah", null, null, ": " . $kls->mata_kuliah, null, null, null, null, null, null, null, "Semester", ": " . $kls->semester, null, null],
            ["Tahun Ajaran / Angkatan", null, null, ": " . $angkatan->thn_akademik_1 . "/" . $angkatan->thn_akademik_2 . " / " . $angkatan->angkatan, null, null, null, null, null, null, null, "Bobot", ": ", null, null],
            [null],
            ["No", "Hari / Tanggal / Jam", null, "Materi / Topik Pembelajaran", null, null, null, null, "Metode", null, null, null, null, "Tanda Tangan", null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            ["DAFTAR HADIR DOSEN"],
            [null],
            ["Mata Kuliah", null, null, ": " . $kls->mata_kuliah, null, null, null, null, null, null, null, "Semester", ": " . $kls->semester, null, null],
            ["Tahun Ajaran / Angkatan", null, null, ": " . $angkatan->thn_akademik_1 . "/" . $angkatan->thn_akademik_2 . " / " . $angkatan->angkatan, null, null, null, null, null, null, null, "Bobot", ": ", null, null],
            [null],
            ["No", "Hari / Tanggal / Jam", null, "Materi / Topik Pembelajaran", null, null, null, null, "Metode", null, null, null, null, "Tanda Tangan", null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            ["DAFTAR HADIR DOSEN"],
            [null],
            ["Mata Kuliah", null, null, ": " . $kls->mata_kuliah, null, null, null, null, null, null, null, "Semester", ": " . $kls->semester, null, null],
            ["Tahun Ajaran / Angkatan", null, null, ": " . $angkatan->thn_akademik_1 . "/" . $angkatan->thn_akademik_2 . " / " . $angkatan->angkatan, null, null, null, null, null, null, null, "Bobot", ": ", null, null],
            [null],
            ["No", "Hari / Tanggal / Jam", null, "Materi / Topik Pembelajaran", null, null, null, null, "Metode", null, null, null, null, "Tanda Tangan", null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null],
            [null, "Mengetahui", null, null, null, null, null, null, null, null, "Denpasar, " . date('d-m-Y')],
            [null, "Politeknik Kesehatan Kartini Bali", null, null, null, null, null, null, null, null, "Koordinator Mata Kuliah"],
            [null, "Kepala Program Studi " . $kls->prodi],
            [null],
            [null],
            [null],
            [null, null, null, null, null, null, null, null, null, null, $dosenKoor->nama_dosen],
            [null, "NIDN: ", null, null, null, null, null, null, null, null, "NIDN: " . $dosenKoor->nidn],
        ];

        // $id_dosen = Dosen::select('nama_dosen','id_dosen')->where('id_user',Auth::user()->id)->first();

        $j = 14;
        $k = 29;

        foreach ($kelass as $key => $kelas) {
            if ($j == $k) {
                $detAbsensiKelasDosen = DetAbsensiKelasDosen::join('tb_dosen','tb_dosen.id_dosen','tb_det_absensi_kelas_dosen.id_dosen')
                    ->where('id_absensi_kelas',$kelas->id_absensi_kelas)
                    ->where('absensi','Hadir')
                    ->first();

                $hari = self::translateToHari(date('l',strtotime($kelas->mulai)));

                if (!empty($detAbsensiKelasDosen)) {
                    $ttd = date("H.i", strtotime($detAbsensiKelasDosen->created_at)) . PHP_EOL  . '(' . $detAbsensiKelasDosen->nama_dosen . ')';
                } else {
                    $ttd = 'Tidak Hadir';
                }
                
                $array[$j+15] = [
                    $key+1,
                    $hari . '/' . date("d-m-Y", strtotime($kelas->mulai)) . '/' . date("H.i", strtotime($kelas->selesai)) . '-' . date("H.i", strtotime($kelas->mulai)), 
                    null,
                    $kelas->materi,
                    null,
                    null,
                    null,
                    null,
                    $kelas->metode,
                    null,
                    null,
                    null,
                    null,
                    $ttd,
                    null,
                ];

                $j = $j+13+5;

                $k = $k+28;
            } else {
                $detAbsensiKelasDosen = DetAbsensiKelasDosen::join('tb_dosen','tb_dosen.id_dosen','tb_det_absensi_kelas_dosen.id_dosen')
                    ->where('id_absensi_kelas',$kelas->id_absensi_kelas)
                    ->where('absensi','Hadir')
                    ->first();

                $hari = self::translateToHari(date('l',strtotime($kelas->mulai)));

                if (!empty($detAbsensiKelasDosen)) {
                    $ttd = date("H.i", strtotime($detAbsensiKelasDosen->created_at)) . PHP_EOL  . '(' . $detAbsensiKelasDosen->nama_dosen . ')';
                } else {
                    $ttd = 'Tidak Hadir';
                }
                
                $array[$j+2] = [
                    $key+1,
                    $hari . '/' . date("d-m-Y", strtotime($kelas->mulai)) . '/' . date("H.i", strtotime($kelas->selesai)) . '-' . date("H.i", strtotime($kelas->mulai)), 
                    null,
                    $kelas->materi,
                    null,
                    null,
                    null,
                    null,
                    $kelas->metode,
                    null,
                    null,
                    null,
                    null,
                    $ttd,
                    null,
                ];
                
                $j = $j+5;
            }
        }

        // return $array;

        return Excel::download(new AbsensiKelasDosenExport($array), date('Ymd').'_'.$nama_file.'.xlsx');
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
