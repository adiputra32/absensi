@extends('dosen.layouts.admin-master')

@section('title')
Absensi {{ $kelas->mata_kuliah }}
@endsection

@section('css')
<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Absensi {{ $kelas->mata_kuliah }}</h1>
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

    <div style="width: 100%;">
        <a style="float: left;" href="/dosen/dashboard/{{ $kelas->id_kelas }}"><button class="btn btn-success"><i class="fas fa-reply"></i> Kembali</button></a>
    </div>
    <br><br><br>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Jurnal dan Absensi Dosen Kelas {{ $kelas->mata_kuliah }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ action('dosen\AbsensiKelasController@updateMateriMetode', $id) }}" method="POST">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="form-group row">
                                <div class="col-form-label col-sm-3">Materi/Topik Pembelajaran</div>
                                <div class="col-sm-9">
                                    <textarea class="form-control" placeholder="Materi/Topik Pembelajaran" name="materi" rows="3" style="height: auto;">{{ $kelas->materi }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-3">Metode</div>
                                <div class="col-sm-9">
                                    <textarea class="form-control" placeholder="Metode" name="metode" rows="3" style="height: auto;">{{ $kelas->metode }}</textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <input type="hidden" name="id_kelas" value="{{ $kelas->id_kelas }}">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>

                        <hr>

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 15%;" data-field="kode_kelas">NIDN</th>
                                        <th style="width: 60%;" data-field="mata_kuliah">Nama Dosen</th>
                                        <th style="width: 20%;" data-field="status">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($absenDosens as $key => $absenDosen)
                                        <tr>
                                            <td style="vertical-align: middle;">{{ $key+1 }}</td>
                                            <td style="vertical-align: middle;">{{ $absenDosen->nidn }}</td>
                                            <td style="vertical-align: middle;">{{ $absenDosen->nama_dosen }}</td>
                                            <td style="vertical-align: middle;">
                                                @if($kelas->status == "Aktif")
                                                    @if($absenDosen->id_dosen == $dosen->id_dosen)
                                                    <form method="POST" action="{{ action('dosen\AbsensiKelasController@absenDosen', $absenDosen->id_det_absensi_kelas_dosen) }}">
                                                        @csrf
                                                        {{ method_field('PATCH') }}
                                                        <select class="form-control" name="absensi" onchange="this.form.submit();" required>
                                                            <option value="{{ $absenDosen->absensi }}" selected>{{ $absenDosen->absensi }}</option>
                                                            @if($absenDosen->absensi == "Hadir")
                                                            <option value="Tidak Hadir">Tidak Hadir</option>
                                                            @elseif($absenDosen->absensi == "Tidak Hadir")
                                                            <option value="Hadir">Hadir</option>
                                                            @else
                                                            <option value="Hadir">Hadir</option>
                                                            <option value="Tidak Hadir">Tidak Hadir</option>
                                                            @endif
                                                        </select>
                                                    </form>
                                                    @else
                                                    @if($absenDosen->absensi == "Hadir")
                                                    <span class="badge badge-success">{{ $absenDosen->absensi }}</span>
                                                    @elseif($absenDosen->absensi == "Tidak Hadir")
                                                    <span class="badge badge-danger">{{ $absenDosen->absensi }}</span>
                                                    @else
                                                    <span class="badge badge-secondary">{{ $absenDosen->absensi }}</span>
                                                    @endif
                                                    @endif
                                                @else
                                                    @if($absenDosen->absensi == "Hadir")
                                                    <span class="badge badge-success">{{ $absenDosen->absensi }}</span>
                                                    @elseif($absenDosen->absensi == "Tidak Hadir")
                                                    <span class="badge badge-danger">{{ $absenDosen->absensi }}</span>
                                                    @else
                                                    <span class="badge badge-secondary">{{ $absenDosen->absensi }}</span>
                                                    @endif
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

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Absensi Kelas {{ $kelas->mata_kuliah }}</h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 15%;" data-field="kode_kelas">NIM</th>
                                    <th style="width: 60%;" data-field="mata_kuliah">Nama Mahasiswa</th>
                                    <th style="width: 20%;" data-field="status">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($absens as $key => $absen)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $key+1 }}</td>
                                        <td style="vertical-align: middle;">{{ $absen->nim_mahasiswa }}</td>
                                        <td style="vertical-align: middle;">{{ $absen->nama_mahasiswa }}</td>
                                        @if($absen->absensi == "Hadir")
                                        <td style="vertical-align: middle;"><span class="badge badge-success">{{ $absen->absensi }}</span></td>
                                        @elseif($absen->absensi == "Alpha")
                                        <td style="vertical-align: middle;"><span class="badge badge-danger">{{ $absen->absensi }}</span></td>
                                        @elseif($absen->status == "Menunggu")
                                        <td style="vertical-align: middle;"><span class="badge badge-secondary">{{ $absen->absensi }}</span></td>
                                        @else
                                        <td style="vertical-align: middle;"><span class="badge badge-warning">{{ $absen->absensi }}</span></td>
                                        @endif
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
