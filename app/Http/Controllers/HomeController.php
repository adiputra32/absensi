<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = Auth::user()->role;

        if ($role == 'admin') {
            return redirect('admin/dashboard');
        } elseif ($role == 'staff') {
            return redirect('staff/dashboard');
        } elseif ($role == 'dosen koordinator'){
            return redirect('dosen-koordinator/dashboard');
        } elseif ($role == 'dosen'){
            return redirect('dosen/dashboard');
        } elseif($role == 'mahasiswa') {
            return redirect('dashboard');
        } else {
            return redirect('logout');
        }
    }
}
