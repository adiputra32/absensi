<?php



namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;

use App\User;

use App\Mahasiswa;

use App\DetKelas;

use App\TahunAkademik;

use App\Http\Controllers\Controller;

use Validator;

use Hash;



class MahasiswaController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $thnAkademikSekarang = TahunAkademik::orderBy('id_thn_akademik', 'DESC')->first();

        $mahasiswas = Mahasiswa::join('tb_thn_akademik','tb_thn_akademik.id_thn_akademik','tb_mahasiswa.id_thn_akademik')

	->where('status', 'aktif')->get();

        $kelass = DetKelas::join('tb_kelas','tb_kelas.id_kelas','tb_det_kelas.id_kelas')

        ->join('tb_mata_kuliah','tb_mata_kuliah.id_mata_kuliah','tb_kelas.id_mata_kuliah')

        ->where('id_thn_akademik',$thnAkademikSekarang->id_thn_akademik)

        ->get();        



        return view('admin.mahasiswa.mahasiswa')->with(compact('mahasiswas','kelass','thnAkademikSekarang'));

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

	$thnAkademiks = TahunAkademik::orderBy('id_thn_akademik', 'DESC')->get();



        return view('admin.mahasiswa.addMahasiswa')->with(compact('thnAkademiks'));

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $request['name'] = $request['nama_mahasiswa'];

        $validator = Validator::make($request->all(),[

            'name' => ['required', 'string', 'max:255'],

            'username' => ['required', 'string', 'max:255', 'unique:users'],

            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);



        if($validator->fails()){

            return redirect()->back()->with('error','Pastikan username dan email tidak sama dengan user lain dan password minimal 8 karakter!');

        } else {

	        $thnAkademikSekarang = TahunAkademik::orderBy('id_thn_akademik', 'DESC')->first();

            $user = User::create([

                'name' => $request['name'],

                'username' => $request['username'],

                'email' => $request['email'],

                'role' => $request['role'],

                'password' => Hash::make($request['password']),

            ]);



    

            $mahasiswa = Mahasiswa::create([

                'nama_mahasiswa' => $request['nama_mahasiswa'],

                'nim_mahasiswa' => $request['nim_mahasiswa'],

                'smt_mahasiswa' => $request['smt_mahasiswa'],

                'id_user' => $user['id'],

		        'id_thn_akademik' => $thnAkademikSekarang->id_thn_akademik,

            ]);

    

            return redirect('admin/mahasiswa')->with('success','Berhasil menambah data mahasiswa!');

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

      	$thnAkademiks = TahunAkademik::orderBy('id_thn_akademik', 'DESC')->get();

        $mahasiswa = Mahasiswa::select('tb_mahasiswa.*','users.id','users.username')

        ->join('users','users.id','tb_mahasiswa.id_user')

        ->where('id_mahasiswa', $id)

        ->first();



        return view('admin.mahasiswa.editMahasiswa')->with(compact('mahasiswa','thnAkademiks','thnAkademikSekarang'));

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

        $validator = Validator::make($request->all(),[
            
            'username' => ['required', 'string', 'max:255', 'unique:users'],

        ]);

        if($validator->fails()){

            return redirect()->back()->with('error','Pastikan username tidak sama dengan user lain!');

        } else {

            $mahasiswa = Mahasiswa::where('id_mahasiswa',$id)->update([

                'nama_mahasiswa' => $request['nama_mahasiswa'],

                'nim_mahasiswa' => $request['nim_mahasiswa'],

                'smt_mahasiswa' => $request['smt_mahasiswa'],

                'id_thn_akademik' => $request['id_thn_akademik'],

            ]);

            $id_user = User::select('id')

                ->join('tb_mahasiswa','tb_mahasiswa.id_user','users.id')

                ->where('id_mahasiswa',$id)

                ->first();



            User::where('id',$id_user['id'])->update([

                'username' => $request['username'],

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

                        ->join('tb_mahasiswa','tb_mahasiswa.id_user','users.id')

                        ->where('id_mahasiswa',$id)

                        ->first();



                    User::where('id',$id_user['id'])->update([

                        'password' => Hash::make($request['password']),

                    ]);



                    return redirect('admin/mahasiswa')->with('success','Berhasil memperbarui data mahasiswa!');

                }

            }
        }



        return redirect('admin/mahasiswa')->with('success','Berhasil memperbarui data mahasiswa!');

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $mahasiswa = Mahasiswa::where('id_mahasiswa', $id)->first();



        Mahasiswa::where('id_mahasiswa', $id)->update([

            'status' => 'nonaktif',

        ]);



        $user = User::where('id', $mahasiswa['id_mahasiswa'])->update([

            'status' => 'nonaktif',

        ]);



        return redirect('admin/mahasiswa')->with('success','Berhasil menghapus data mahasiswa!');

    }

}

