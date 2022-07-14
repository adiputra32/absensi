@extends('admin.layouts.admin-master')

@section('title')
Edit Data Staff
@endsection

@section('css')
<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Data Staff</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Data Staff</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/admin/staff/{{ $staff->id_staff }}">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Nama Staff</div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama_staff" placeholder="Nama Staff" value="{{ $staff->nama_staff }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Jenis Staff</div>
                                <div class="col-sm-10">
                                    <select class="form-control" name="jenis_staff" value="{{ old('jenis_staff') }}" required>
                                        <option value="{{ strtolower($staff->jenis_staff) }}">{{ $staff->jenis_staff }}</option>
                                        @if($staff->jenis_staff == "Admin")
                                        <option value="staff">Staff</option>
                                        @else
                                        <option value="admin">Admin</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Username</div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{ $staff->username }}" disabled>
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