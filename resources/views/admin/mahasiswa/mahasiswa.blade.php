@extends('admin.layouts.admin-master')

@section('title')
Data Mahasiswa
@endsection

@section('css')
<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Mahasiswa</h1>
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
                        <h4>Tabel Data Mahasiswa</h4>
                        <div class="card-header-action">
                            <a href="mahasiswa/create" class="btn btn-primary">
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
                                      <th style="width: 10%;" data-field="kode_kelas">NIM</th>
                                      <th style="width: 10%;" data-field="mata_kuliah">Semester</th>
                                      <th style="width: 25%;" data-field="mata_kuliah">Nama Mahasiswa</th>
                                      <th style="width: 10%;" data-field="nama_mahasiswa">Angkatan</th>
                                      <th style="width: 15%;" data-field="mulai">Aksi</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach($mahasiswas as $key => $mahasiswa)
                                      <tr>
                                            <td style="vertical-align: middle;">{{ $key+1 }}</td>
                                            <td style="vertical-align: middle;">{{ $mahasiswa->nim_mahasiswa }}</td>
                                            <td style="vertical-align: middle;">{{ $mahasiswa->smt_mahasiswa }}</td>
                                            <td style="vertical-align: middle;">{{ $mahasiswa->nama_mahasiswa }}</td>
                                            <td style="vertical-align: middle;">{{ $mahasiswa->angkatan }}</td>
                                            <td style="vertical-align: middle;">
                                                <button class="btn btn-primary" data-toggle='modal' data-target='#exampleModal{{ $key+1 }}' title="Lihat Kelas"><i class="fas fa-eye"></i></button>
                                                <a class="btn btn-warning" href="mahasiswa/{{ $mahasiswa->id_mahasiswa }}/edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                                <a class="btn btn-danger" href="mahasiswa/{{ $mahasiswa->id_mahasiswa }}/delete" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus?')"><i class="fas fa-trash"></i></a>
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


<!-- Modal -->
@foreach($mahasiswas as $key => $mahasiswa)

<div class="modal fade" id="exampleModal{{ $key+1 }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Data Kelas {{ $mahasiswa->nama_mahasiswa }} 
          <p>Tahun Akademik {{ $thnAkademikSekarang->thn_akademik_1 }}/{{ $thnAkademikSekarang->thn_akademik_2 }} Semester {{ $thnAkademikSekarang->semester }}</p>
          </h5>
          
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table-2">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 80%;" data-field="mata_kuliah">Mata Kuliah</th>
                            <th style="width: 15%;" data-field="mulai">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @foreach($kelass as $kelas)
                        @if($mahasiswa->id_mahasiswa == $kelas->id_mahasiswa)
                        <tr>
                            <td style="vertical-align: middle;">{{ $i + 1 }}</td>
                            <td style="vertical-align: middle;">{{ $kelas->mata_kuliah }}</td>
                            <td style="vertical-align: middle;">
                                <a class="btn btn-danger" href="detail-kelas/{{ $kelas->id_det_kelas }}/delete"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
        <a type="button" class="btn btn-primary" href="detail-kelas/{{ $mahasiswa->id_mahasiswa }}">Lihat Selengkapnya</a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endforeach
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
$(document).ready(function(){
  $('#table-1').DataTable();
});
</script>
@endsection
