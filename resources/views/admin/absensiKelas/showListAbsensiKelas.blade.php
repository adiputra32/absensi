@extends('admin.layouts.admin-master')



@section('title')

Data Absensi Kelas {{ $kelas->mata_kuliah }}

@endsection



@section('css')

<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">

<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

@endsection



@section('content')

<section class="section">

    <div class="section-header">

        <h1>Data Absensi Kelas {{ $kelas->mata_kuliah }}</h1>

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

        <a style="float: left;" href="/admin/absensi-kelas"><button class="btn btn-success"><i class="fas fa-reply"></i> Kembali</button></a>

    </div>

    <br><br><br>



    <div class="section-body">

        <div class="row">

            <div class="col-lg-12">

                <div class="card">

                    <div class="card-header">

                        <h4>Data Absensi Kelas {{ $kelas->mata_kuliah }}</h4>

                        <div class="card-header-action">

                            <a href="/admin/export-excel-dosen/{{ $kelas->id_kelas }}/download" class="btn btn-success">

                                <i class="fas fa-file-excel"></i>

                                Export Excel Absensi Dosen

                            </a>

                            <div class="dropdown">

                                <a href="#" data-toggle="dropdown" class="btn btn-success dropdown-toggle" aria-expanded="false"><i class="fas fa-file-excel"></i> Export Excel Absensi Mahasiswa</a>

                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">

                                    <a href="/admin/export-excel/{{ $kelas->id_kelas }}/UTS/download" class="dropdown-item has-icon"><i class="fas fa-file-excel"></i> UTS</a>

                                    <a href="/admin/export-excel/{{ $kelas->id_kelas }}/UAS/download" class="dropdown-item has-icon"><i class="fas fa-file-excel"></i> UAS</a>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-body">

                        <div class="table-responsive" id="div_table_1">

                            <table class="table table-striped" id="table-1">

                                <thead>

                                    <tr>

                                        <th style="width: 5%;">#</th>

                                        <th style="width: 20%;" data-field="mulai">Pertemuan</th>

                                        <th style="width: 30%;" data-field="mulai">Mulai</th>

                                        <th style="width: 30%;" data-field="selesai">Selesai</th>

                                        <th style="width: 15%;" data-field="status">Status</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($absens as $key => $absen)

                                    <tr>

                                        <td style="vertical-align: middle;">{{ $key+1 }}</td>

                                        <td style="vertical-align: middle;">Pertemuan ke-{{ $key+1 }}</td>

                                        <td style="vertical-align: middle;">{{ date('H:i d-m-Y', strtotime($absen->mulai)) }}</td>

                                        <td style="vertical-align: middle;">{{ date('H:i d-m-Y', strtotime($absen->selesai)) }}</td>

                                        <td style="vertical-align: middle;">

                                            @if($absen->status == "Selesai")

                                            <span class="badge badge-success">{{ $absen->status }}</span>

                                            @elseif($absen->status == "Aktif")

                                            <span class="badge badge-info">{{ $absen->status }}</span>

                                            @elseif($absen->status == "Menunggu")

                                            <span class="badge badge-secondary">{{ $absen->status }}</span>

                                        </td>

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

