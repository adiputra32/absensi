<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\AbsensiKegiatan;
use App\Staff;
use Auth;
use App\DetAbsensiKegiatan;
use App\Http\Controllers\Controller;

class AbsensiKegiatanController extends Controller
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
        //
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
        DetAbsensiKegiatan::where('id_det_absensi_kegiatan',$id)->update([
            'absensi' => $request['absensi'],
        ]);

        return redirect()->back()->with('success','Berhasil memperbarui status absensi!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function absen(Request $request, $id)
    {
        DetAbsensiKegiatan::where('id_det_absensi_kegiatan',$id)->update([
            'absensi' => $request['absensi'],
        ]);

        return redirect()->back()->with('success','Berhasil memperbarui status absensi!');
    }
}
