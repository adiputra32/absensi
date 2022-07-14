@extends('admin.layouts.admin-master')

@section('title')
Edit Data Dosen
@endsection

@section('css')
<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Data Dosen</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Data Dosen</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/admin/dosen/{{ $dosen->id_dosen }}">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Nama Dosen</div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama_dosen" placeholder="Nama Dosen" value="{{ $dosen->nama_dosen }}" required>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">NIDN</div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nidn" placeholder="NIDN" value="{{ $dosen->nidn }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Jenis Dosen</div>
                                <div class="col-sm-10">
                                    <select class="form-control" name="jenis_dosen" value="{{ old('jenis_dosen') }}" required>
                                        <option value="{{ strtolower($dosen->jenis_dosen) }}" selected>{{ $dosen->jenis_dosen }}</option>    
                                        @if($dosen->jenis_dosen == "Dosen Koordinator")
                                        <option value="dosen">Dosen</option>
                                        @else
                                        <option value="dosen koordinator">Dosen Koordinator</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Username</div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{ $dosen->username }}" disabled>
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