@extends('admin.layouts.admin-master')

@section('title')
Data Staff
@endsection

@section('css')
<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Staff</h1>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible show fade" style="width: 100%; margin-top: -10px;">
        <div class="alert-body" style="padding-right: 40px;">
            <button class="close" data-dismiss="alert">
            <span>&times;</span>
            </button>
            {{ session()->get('success') }}
        </div>
        </div>
    @endif

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
                        <h4>Tabel Data Staff</h4>
                        <div class="card-header-action">
                            <a href="staff/create" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Tambah Data
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                              <thead>
                                  <tr>
                                      <th style="width: 5%;">#</th>
                                      <th style="width: 35%;" data-field="nama_staff">Nama Staff</th>
                                      <th style="width: 10%;" data-field="id_user">ID User</th>
                                      <th style="width: 15%;" data-field="aksi">Aksi</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach($staffs as $key => $staff)
                                      <tr>
                                            <td style="vertical-align: middle;">{{ $key+1 }}</td>
                                            @if($staff->jenis_staff == "Admin")
                                            <td style="vertical-align: middle;">{{ $staff->nama_staff }} ({{ $staff->jenis_staff }})</td>
                                            @else
                                            <td style="vertical-align: middle;">{{ $staff->nama_staff }}</td>
                                            @endif
                                            <td style="vertical-align: middle;">{{ $staff->id_user }}</td>
                                            <td style="vertical-align: middle;">
                                                <a class="btn btn-warning" href="staff/{{ $staff->id_staff }}/edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                                <a class="btn btn-danger" href="staff/{{ $staff->id_staff }}/delete" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus?')"><i class="fas fa-trash"></i></a>
                                            </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                    </div>
                </div>
              </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<!-- JS Libraies -->
<script src="/assets/modules/datatables/datatables.min.js"></script>
  <script src="/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
  <script src="/assets/modules/jquery-ui/jquery-ui.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="/assets/js/page/modules-datatables.js"></script>
@endsection
