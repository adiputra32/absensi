<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TahunAkademik;
use App\Mahasiswa;

class TahunAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $thnAkademiks = TahunAkademik::get();
        $thnAkademikSekarang = TahunAkademik::orderBy('id_thn_akademik','DESC')->first();

        return view('admin.tahunAkademik.tahunAkademik')->with(compact('thnAkademiks','thnAkademikSekarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tahunAkademik.addTahunAkademik');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tahunAkademik = TahunAkademik::create([
            'thn_akademik_1' => $request['thn_akademik_1'],
            'thn_akademik_2' => $request['thn_akademik_2'],
            'angkatan' => $request['angkatan'],
            'semester' => $request['semester'],
        ]);

        return redirect('/admin/tahun-akademik')->with('success', 'Berhasil membuat tahun akademik baru! 
            Data kelas dosen dan data kelas mahasiswa telah dikosongkan. 
            Silakan diisi kembali berdasarkan data KRS tahun akademik/semester terbaru.');

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
        $thnAkademik = TahunAkademik::where('id_thn_akademik', $id)->first();

        return view('admin.tahunAkademik.editTahunAkademik')->with(compact('thnAkademik'));
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
        TahunAkademik::where('id_thn_akademik', $id)->update([
            'thn_akademik_1' => $request['thn_akademik_1'],
            'thn_akademik_2' => $request['thn_akademik_2'],
            'angkatan' => $request['angkatan'],
            'semester' => $request['semester'],
        ]);

        return redirect('/admin/tahun-akademik')->with('success','Berhasil memperbarui tahun akademik');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mhs = Mahasiswa::join('tb_thn_akademik','tb_thn_akademik.id_thn_akademik','tb_mahasiswa.id_thn_akademik')
            ->where('tb_mahasiswa.id_thn_akademik',$id)
            ->count();
        
        if ($mhs < 1) {
            $thnAkademik = TahunAkademik::where('id_thn_akademik', $id)->delete();

            return redirect()->back()->with('success','Berhasil menghapus tahun akademik!');
        } else {
            return redirect()->back()->with('error','Gagal menghapus tahun akademik! Terdapat mahasiswa yang telah terdaftar pada id tahun akademik tersebut.');
        }
    }
}
