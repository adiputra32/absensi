@extends('admin.layouts.admin-master')



@section('title')

Tambah Data Mahasiswa

@endsection



@section('css')

<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">

<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

@endsection



@section('content')

<section class="section">

    <div class="section-header">

        <h1>Tambah Data Mahasiswa</h1>

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

                        <h4>Form Data Mahasiswa</h4>

                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ action('admin\MahasiswaController@store') }}">

                            @csrf

                            <h5>Data Mahasiswa</h5>

                            <br>

                            <div class="form-group row">

                                <div class="col-form-label col-sm-2">Nama Mahasiswa</div>

                                <div class="col-sm-10">

                                    <input type="text" class="form-control" name="nama_mahasiswa" placeholder="Nama Mahasiswa" value="{{ old('nama_mahasiswa') }}" required>

                                </div>

                            </div>



                            <div class="form-group row">

                                <div class="col-form-label col-sm-2">Semester</div>

                                <div class="col-sm-10">

                                    <input type="text" class="form-control" name="smt_mahasiswa" placeholder="Semester" value="{{ old('nim') }}" required>

                                </div>

                            </div>

                            

                            <div class="form-group row">

                                <div class="col-form-label col-sm-2">NIM</div>

                                <div class="col-sm-10">

                                    <input type="text" class="form-control" name="nim_mahasiswa" placeholder="NIM" value="{{ old('nim') }}" oninput="document.getElementsByName('username')[0].value = this.value; document.getElementById('username').value = this.value;" required>

                                </div>

                            </div>



                            <div class="form-group row">

                                <div class="col-form-label col-sm-2">Tahun Akademik</div>

                                <div class="col-sm-10">

                                    <select class="form-control" name="id_thn_akademik" required>

                                        @foreach($thnAkademiks as $thnAkademik)

                                        <option value="{{ $thnAkademik->id_thn_akademik }}">{{ $thnAkademik->thn_akademik_1 }}/{{ $thnAkademik->thn_akademik_2 }} - Semester {{ $thnAkademik->semester }}</option>

                                        @endforeach

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

                                    <input type="text" id="username" class="form-control" placeholder="Username" disabled>

                                    <input type="hidden" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}" required>

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

                                <input type="hidden" name="role" value="mahasiswa">

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