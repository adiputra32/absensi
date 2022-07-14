<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Staff;
use App\Http\Controllers\Controller;
use Validator;
use Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = Staff::where('status', 'aktif')
            ->orderByRaw("FIELD(jenis_staff , 'Admin', 'Staff') ASC")
            ->get();

        return view('admin.staff.staff')->with(compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.staff.addStaff');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['name'] = $request['nama_staff'];
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
                'role' => $request['role'],
                'password' => Hash::make($request['password']),
                'role' => $request['jenis_staff'],
            ]);

    
            $staff = Staff::create([
                'nama_staff' => $request['nama_staff'],
                'id_user' => $user['id'],
                'jenis_staff' => ucwords($request['jenis_staff']),
            ]);
    
            return redirect('admin/staff')->with('success','Berhasil menambah data staff!');
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
        $staff = Staff::select('tb_staff.*','users.id','users.username')
        ->join('users','users.id','tb_staff.id_user')
        ->where('id_staff', $id)
        ->first();

        return view('admin.staff.editStaff')->with(compact('staff'));
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
        $staff = Staff::join('users','users.id','tb_staff.id_user')->where('id_staff',$id)->update([
            'nama_staff' => $request['nama_staff'],
            'jenis_staff' => ucwords($request['jenis_staff']),
            'role' => $request['jenis_staff'],
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
                    ->join('tb_staff','tb_staff.id_user','users.id')
                    ->where('id_staff',$id)
                    ->first();

                User::where('id',$id_user['id'])->update([
                    'password' => Hash::make($request['password']),
                ]);

                return redirect('admin/staff')->with('success','Berhasil memperbarui data staff!');
            }
        }

        return redirect('admin/staff')->with('success','Berhasil memperbarui data staff!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = Staff::where('id_staff', $id)->first();

        Staff::where('id_staff', $id)->update([
            'status' => 'nonaktif',
        ]);

        $user = User::where('id', $staff['id_staff'])->update([
            'status' => 'nonaktif',
        ]);

        return redirect('admin/staff')->with('success','Berhasil menghapus data staff!');
    }
}
