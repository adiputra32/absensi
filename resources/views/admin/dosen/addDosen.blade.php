@extends('admin.layouts.admin-master')

@section('title')
Tambah Data Dosen
@endsection

@section('css')
<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Tambah Data Dosen</h1>
    </div>

    @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible show fade" style="width: 100%; margin-top: -10px;">
        <div class="alert-body" style="padding-right: 40px;">
            <button class="close" data-dismiss="alert">
            <span>&times;</span>
            </button>
            {{ session()->get('error') }}
        </div>
        </div>
    @endif

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Data Dosen</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ action('admin\DosenController@store') }}">
                            @csrf
                            <h5>Data Dosen</h5>
                            <br>
                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Nama Dosen</div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama_dosen" placeholder="Nama Dosen" value="{{ old('nama_dosen') }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">NIDN</div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nidn" placeholder="NIDN" value="{{ old('nidn') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Jenis Dosen</div>
                                <div class="col-sm-10">
                                    <select class="form-control" name="jenis_dosen" value="{{ old('jenis_dosen') }}" required>
                                        <option value="dosen koordinator">Dosen Koordinator</option>
                                        <option value="dosen">Dosen</option>
                                    </select>
                                </div>
                            </div>

                            <br>
                            <hr>
                            <br>

                            <h5>Data User</h5>
                            <br>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Username</div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Email</div>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Password</div>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" placeholder="Password (minimal 8 karakter)" required>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Konfirmasi Password</div>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password (minimal 8 karakter)" required>
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
              </div>
        </div>
    </div>
</section>
@endsection