@extends('admin.layouts.admin-master')



@section('title')

Absensi {{ $kegiatan->nama_kegiatan }}

@endsection



@section('css')

<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">

<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

@endsection



@section('content')

<section class="section">

    <div class="section-header">

        <h1>Absensi {{ $kegiatan->nama_kegiatan }}</h1>

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

        <a style="float: left;" href="/admin/dashboard"><button class="btn btn-success"><i class="fas fa-reply"></i> Kembali</button></a>

    </div>

    <br><br><br>



    <div class="section-body">

        <div class="row">

            <div class="col-lg-12">

                <div class="card">

                    <div class="card-header">

                        <h4>Data Absensi Kegiatan {{ $kegiatan->nama_kegiatan }}</h4>

                        <div class="card-header-action">

                            <a href="/admin/export-excel/{{ $kegiatan->id_absensi_kegiatan }}/download" class="btn btn-success">

                                <i class="fas fa-file-excel"></i>

                                Export Excel

                            </a>

                        </div>

                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-striped" id="table-1">

                                <thead>

                                    <tr>

                                        <th style="width: 5%;">#</th>

                                        <th style="width: 60%;" data-field="kode_kelas">Nama Peserta</th>

                                        <th style="width: 15%;" data-field="kode_kelas">Jabatan</th>

                                        <th style="width: 20%;" data-field="status">Status</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($absens as $key => $absen)

                                        <tr>

                                            <td style="vertical-align: middle;">{{ $key+1 }}</td>

                                            @if(!empty($absen->nama_staff))

                                            <td style="vertical-align: middle;">{{ $absen->nama_staff }}</td>

                                            <td style="vertical-align: middle;">Staff</td>

                                            @elseif(!empty($absen->nama_dosen))

                                            <td style="vertical-align: middle;">{{ $absen->nama_dosen }}</td>

                                            <td style="vertical-align: middle;">{{ $absen->jenis_dosen }}</td>

                                            @endif



                                            @if($absen->absensi == "Hadir" || $absen->absensi == "Akreditasi" || $absen->absensi == "Piket" || $absen->absensi == "Cuti" || $absen->absensi == "Sakit" || $absen->absensi == "Dispensasi" || $absen->absensi == "Dinas Luar" || $absen->absensi == "WFH")

                                            <td style="vertical-align: middle;"><span class="badge badge-success">{{ $absen->absensi }}</span></td>

                                            @elseif($absen->absensi == "Tidak Hadir")

                                            <td style="vertical-align: middle;"><span class="badge badge-danger">{{ $absen->absensi }}</span></td>

                                            @else

                                            <td style="vertical-align: middle;"><span class="badge badge-secondary">Menunggu</span></td>

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

