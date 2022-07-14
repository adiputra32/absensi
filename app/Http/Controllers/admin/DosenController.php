<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Dosen;
use App\Kelas;
use App\Pengampu;
use App\MataKuliah;
use App\TahunAkademik;
use App\Http\Controllers\Controller;
use Validator;
use Hash;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $thnAkademikSekarang = TahunAkademik::orderBy('id_thn_akademik', 'DESC')->first();
        $dosens = Dosen::where('status', 'aktif')->get();
        $kelass = Pengampu::join('tb_dosen','tb_dosen.id_dosen','tb_pengampu.id_dosen')
        ->join('tb_kelas','tb_kelas.id_kelas','tb_pengampu.id_kelas')
        ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')
        ->where('id_thn_akademik',$thnAkademikSekarang->id_thn_akademik)
        ->get();   

        return view('admin.dosen.dosen')->with(compact('dosens','kelass','thnAkademikSekarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelass = Kelas::join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')->get();

        return view('admin.dosen.addDosen')->with(compact('kelass'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['name'] = $request['nama_dosen'];
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if($validator->fails()){
            return redirect()->back()->with('error','Pastikan username dan email tidak sama dengan user lain dan password minimal 8 karakter!');
        } else {
            $user = User::create([
                'name' => $request['name'],
                'username' => $request['username'],
                'email' => $request['email'],
                'role' => $request['jenis_dosen'],
                'password' => Hash::make($request['password']),
            ]);

    
            $dosen = Dosen::create([
                'nama_dosen' => $request['nama_dosen'],
                'nidn' => $request['nidn'],
                'id_user' => $user['id'],
                'jenis_dosen' => ucwords($request['jenis_dosen']),
            ]);        

            return redirect('admin/dosen')->with('success','Berhasil menambah data dosen!');
        }
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
        $dosen = Dosen::select('tb_dosen.*','users.id','users.username')
        ->join('users','users.id','tb_dosen.id_user')
        ->where('id_dosen', $id)
        ->first();

        return view('admin.dosen.editDosen')->with(compact('dosen'));
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
        $dosen = Dosen::join('users','users.id','tb_dosen.id_user')->where('id_dosen',$id)->update([
            'nama_dosen' => $request['nama_dosen'],
            'nidn' => $request['nidn'],
            'jenis_dosen' => ucwords($request['jenis_dosen']),
            'role' => $request['jenis_dosen'],
        ]);

        $password = $request['password'];

        if(!empty($password)){
            $validator = Validator::make($request->all(),[
                'password' => ['required', 'string', 'min:8'],
            ]);
    
            if($validator->fails()){
                return redirect()->back()->with('error','Password minimal 8 karakter!');
            } else { 
                $id_user = User::select('id')
                    ->join('tb_dosen','tb_dosen.id_user','users.id')
                    ->where('id_dosen',$id)
                    ->first();

                User::where('id',$id_user['id'])->update([
                    'password' => Hash::make($request['password']),
                ]);

                return redirect('admin/dosen')->with('success','Berhasil memperbarui data dosen!');
            }
        }

        return redirect('admin/dosen')->with('success','Berhasil memperbarui data dosen!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dosen = Dosen::where('id_dosen', $id)->first();

        Dosen::where('id_dosen', $id)->update([
            'status' => 'nonaktif',
        ]);

        $user = User::where('id', $dosen['id_user'])->update([
            'status' => 'nonaktif',
        ]);

        return redirect('admin/dosen')->with('success','Berhasil menghapus data dosen!');
    }
}
