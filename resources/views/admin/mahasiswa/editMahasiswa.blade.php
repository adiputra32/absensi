@extends('admin.layouts.admin-master')

@section('title')
Edit Data Mahasiswa
@endsection

@section('css')
<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Data Mahasiswa</h1>
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
                        <form method="POST" action="/admin/mahasiswa/{{ $mahasiswa->id_mahasiswa }}">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Nama Mahasiswa</div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama_mahasiswa" placeholder="Nama Mahasiswa" value="{{ $mahasiswa->nama_mahasiswa }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Semester</div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="smt_mahasiswa" placeholder="Semester" value="{{ $mahasiswa->smt_mahasiswa }}" required>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">NIM</div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nim_mahasiswa" placeholder="NIM" value="{{ $mahasiswa->nim_mahasiswa }}" oninput="document.getElementsByName('username')[0].value = this.value; document.getElementById('username').value = this.value;" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Tahun Akademik</div>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_thn_akademik" required>
                                        @foreach($thnAkademiks as $thnAkademik)
                                        @if($thnAkademik->id_thn_akademik == $mahasiswa->id_thn_akademik)
                                        <option value="{{ $thnAkademik->id_thn_akademik }}" selected>{{ $thnAkademik->thn_akademik_1 }}/{{ $thnAkademik->thn_akademik_2 }} - Semester {{ $thnAkademik->semester }}</option>
                                        @else
                                        <option value="{{ $thnAkademik->id_thn_akademik }}">{{ $thnAkademik->thn_akademik_1 }}/{{ $thnAkademik->thn_akademik_2 }} - Semester {{ $thnAkademik->semester }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Username</div>
                                <div class="col-sm-10">
                                    <input type="text" id="username" class="form-control" placeholder="Username" value="{{ $mahasiswa->username }}" disabled>
                                    <input type="hidden" name="username" class="form-control" value="{{ $mahasiswa->username }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Ubah Password</div>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" placeholder="Password Baru (Opsional)">
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