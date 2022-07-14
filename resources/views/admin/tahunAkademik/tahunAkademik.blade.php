@extends('admin.layouts.admin-master')

@section('title')
Data Tahun Akademik
@endsection

@section('css')
<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Tahun Akademik</h1>
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

    <div class="alert alert-info alert-has-icon">
        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
        <div class="alert-body">
            <div class="alert-title">Info</div>
            Tahun Akademik <u>{{ $thnAkademikSekarang->thn_akademik_1 }}/{{ $thnAkademikSekarang->thn_akademik_2 }}</u> Angkatan <u>{{ $thnAkademikSekarang->angkatan }}</u> Semester <u>{{ $thnAkademikSekarang->semester }}</u> Telah Aktif!
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Data Tahun Akademik</h4>
                        <div class="card-header-action">
                            <a href="tahun-akademik/create" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Tambah Tahun Akademik
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                              <thead>
                                  <tr>
                                      <th style="width: 5%;">#</th>
                                      <th style="width: 20%;" data-field="tahunAkademik">Tahun Akademik</th>
                                      <th style="width: 20%;" data-field="angkatan">Angkatan</th>
                                      <th style="width: 40%;" data-field="angkatan">Semester</th>
                                      <th style="width: 15%;" data-field="mulai">Aksi</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach($thnAkademiks as $key => $thnAkademik)
                                      <tr>
                                            <td style="vertical-align: middle;">{{ $key+1 }}</td>
                                            <td style="vertical-align: middle;">{{ $thnAkademik->thn_akademik_1 }}/{{ $thnAkademik->thn_akademik_2 }}</td>
                                            <td style="vertical-align: middle;">{{ $thnAkademik->angkatan }}</td>
                                            <td style="vertical-align: middle;">{{ $thnAkademik->semester }}</td>
                                            <td style="vertical-align: middle;">
                                                <a class="btn btn-warning" href="tahun-akademik/{{ $thnAkademik->id_thn_akademik }}/edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                                @if($loop->last)
                                                <a class="btn btn-danger" href="tahun-akademik/{{ $thnAkademik->id_thn_akademik }}/delete" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus?')"><i class="fas fa-trash"></i></a>
                                                @else
                                                <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus" disabled><i class="fas fa-trash"></i></button>
                                                @endif
                                                
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

  <script>
    $('#button1').click(function(){
   $('#formId').attr('action', 'page1');
});
  </script>
@endsection

