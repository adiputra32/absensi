@extends('dosenKoordinator.layouts.admin-master')



@section('title')

Absensi Kegiatan

@endsection



@section('css')

<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">

<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

@endsection



@section('content')

<section class="section">

    <div class="section-header">

        <h1>Absensi Kegiatan</h1>

    </div>



    <div class="section-body">

        <div class="row">

            <div class="col-lg-12">

                <div class="card">

                    <div class="card-header">

                        <h4>Data Absensi Kegiatan</h4>

                    </div>

                    <div class="card-body">

                      <div class="table-responsive">

                        <table class="table table-striped" id="table-1">

                            <thead>

                                <tr>

                                    <th style="width: 5%;">#</th>

                                    <th style="width: 40%;" data-field="kode_kelas">Nama Kegiatan</th>

                                    <th style="width: 15%;" data-field="mulai">Mulai</th>

                                    <th style="width: 15%;" data-field="selesai">Selesai</th>

                                    <th style="width: 10%;" data-field="status">Status</th>

                                    <th style="width: 15%;" data-field="status">Aksi</th>

                                </tr>

                            </thead>

                              <tbody>

                                  @foreach($absens as $key => $absen)

                                      <tr>

                                            <td style="vertical-align: middle;">{{ $key+1 }}</td>

                                            <td style="vertical-align: middle;">{{ $absen->nama_kegiatan }}</td>

                                            <td style="vertical-align: middle;">{{ date('H:i d-m-Y', strtotime($absen->mulai)) }}</td>

                                            <td style="vertical-align: middle;">{{ date('H:i d-m-Y', strtotime($absen->selesai)) }}</td>

                                            @if($absen->status == "Aktif")

                                            <td style="vertical-align: middle;"><span class="badge badge-info">{{ $absen->status }}</span></td>

                                            <td style="vertical-align: middle;">

                                                <form method="POST" action="{{ action('dosenKoordinator\AbsensiKegiatanController@absen', $absen->id_det_absensi_kegiatan) }}">

                                                    @csrf

                                                    {{ method_field('PATCH') }}

                                                    <select class="form-control" name="absensi" onchange="this.form.submit();" required>

                                                    @if($absen->absensi == "Hadir")

                                                    <option value="Hadir" selected>Hadir</option>

                                                    <option value="Akreditasi">Akreditasi</option>

                                                    <option value="Piket">Piket</option>

                                                    <option value="Cuti">Cuti</option>

                                                    <option value="Sakit">Sakit</option>

                                                    <option value="Dispensasi">Dispensasi</option>

                                                    <option value="Dinas Luar">Dinas Luar</option>

                                                    <option value="WFH">WFH</option>

                                                    <option value="Tidak Hadir">Tidak Hadir</option>

                                                    @elseif($absen->absensi == "Tidak Hadir")

                                                    <option value="Hadir" >Hadir</option>

                                                    <option value="Akreditasi">Akreditasi</option>

                                                    <option value="Piket">Piket</option>

                                                    <option value="Cuti">Cuti</option>

                                                    <option value="Sakit">Sakit</option>

                                                    <option value="Dispensasi">Dispensasi</option>

                                                    <option value="Dinas Luar">Dinas Luar</option>

                                                    <option value="Tidak Hadir" selected>Tidak Hadir</option>

                                                    @elseif($absen->absensi == "Piket")

                                                    <option value="Hadir">Hadir</option>

                                                    <option value="Akreditasi">Akreditasi</option>

                                                    <option value="Piket" selected>Piket</option>

                                                    <option value="Cuti">Cuti</option>

                                                    <option value="Sakit">Sakit</option>

                                                    <option value="Dispensasi">Dispensasi</option>

                                                    <option value="Dinas Luar">Dinas Luar</option>

                                                    <option value="WFH">WFH</option>

                                                    <option value="Tidak Hadir">Tidak Hadir</option>

                                                    @elseif($absen->absensi == "Cuti")

                                                    <option value="Hadir">Hadir</option>

                                                    <option value="Akreditasi">Akreditasi</option>

                                                    <option value="Piket">Piket</option>

                                                    <option value="Cuti" selected>Cuti</option>

                                                    <option value="Sakit">Sakit</option>

                                                    <option value="Dispensasi">Dispensasi</option>

                                                    <option value="Dinas Luar">Dinas Luar</option>

                                                    <option value="WFH">WFH</option>

                                                    <option value="Tidak Hadir">Tidak Hadir</option>

                                                    @elseif($absen->absensi == "Sakit")

                                                    <option value="Hadir">Hadir</option>
                                                    
                                                    <option value="Akreditasi">Akreditasi</option>

                                                    <option value="Piket">Piket</option>

                                                    <option value="Cuti">Cuti</option>

                                                    <option value="Sakit" selected>Sakit</option>

                                                    <option value="Dispensasi">Dispensasi</option>

                                                    <option value="Dinas Luar">Dinas Luar</option>

                                                    <option value="WFH">WFH</option>

                                                    <option value="Tidak Hadir">Tidak Hadir</option>

                                                    @elseif($absen->absensi == "Dispensasi")

                                                    <option value="Hadir">Hadir</option>

                                                    <option value="Akreditasi">Akreditasi</option>

                                                    <option value="Piket">Piket</option>

                                                    <option value="Cuti">Cuti</option>

                                                    <option value="Sakit">Sakit</option>

                                                    <option value="Dispensasi" selected>Dispensasi</option>

                                                    <option value="Dinas Luar">Dinas Luar</option>

                                                    <option value="WFH">WFH</option>

                                                    <option value="Tidak Hadir">Tidak Hadir</option>

                                                    @elseif($absen->absensi == "Dinas Luar")

                                                    <option value="Hadir">Hadir</option>

                                                    <option value="Akreditasi">Akreditasi</option>

                                                    <option value="Piket">Piket</option>

                                                    <option value="Cuti">Cuti</option>

                                                    <option value="Sakit">Sakit</option>

                                                    <option value="Dispensasi">Dispensasi</option>

                                                    <option value="Dinas Luar" selected>Dinas Luar</option>

                                                    <option value="WFH">WFH</option>

                                                    <option value="Tidak Hadir">Tidak Hadir</option>

                                                    @elseif($absen->absensi == "Akreditasi")

                                                    <option value="Hadir">Hadir</option>
                                                      
                                                    <option value="Akreditasi" selected>Akreditasi</option>

                                                    <option value="Piket">Piket</option>

                                                    <option value="Cuti">Cuti</option>

                                                    <option value="Sakit">Sakit</option>

                                                    <option value="Dispensasi">Dispensasi</option>

                                                    <option value="Dinas Luar">Dinas Luar</option>

                                                    <option value="WFH">WFH</option>

                                                    <option value="Tidak Hadir">Tidak Hadir</option>

                                                    @elseif($absen->absensi == "WFH")

                                                    <option value="Hadir">Hadir</option>
                                                    
                                                    <option value="Akreditasi">Akreditasi</option>

                                                    <option value="Piket">Piket</option>

                                                    <option value="Cuti">Cuti</option>

                                                    <option value="Sakit">Sakit</option>

                                                    <option value="Dispensasi">Dispensasi</option>

                                                    <option value="Dinas Luar">Dinas Luar</option>

                                                    <option value="WFH" selected>WFH</option>

                                                    <option value="Tidak Hadir">Tidak Hadir</option>

                                                    @else

                                                    <option disabled selected>Pilih</option>

                                                    <option value="Hadir">Hadir</option>

                                                    <option value="Akreditasi">Akreditasi</option>

                                                    <option value="Piket">Piket</option>

                                                    <option value="Cuti">Cuti</option>

                                                    <option value="Sakit">Sakit</option>

                                                    <option value="Dispensasi">Dispensasi</option>

                                                    <option value="Dinas Luar">Dinas Luar</option>

                                                    <option value="WFH">WFH</option>

                                                    <option value="Tidak Hadir">Tidak Hadir</option>

                                                    @endif

                                                    </select>

                                                </form>

                                            </td>

                                            @elseif($absen->status == "Menunggu")

                                            <td style="vertical-align: middle;"><span class="badge badge-secondary">{{ $absen->status }}</span></td>

                                            <td style="vertical-align: middle;"><span class="badge badge-secondary">{{ $absen->absensi }}</span></td>

                                            @elseif($absen->status == "Selesai")

                                            <td style="vertical-align: middle;"><span class="badge badge-success">{{ $absen->status }}</span></td>

                                                @if($absen->absensi == "Hadir")

                                                <td style="vertical-align: middle;"><span class="badge badge-success">{{ $absen->absensi }}</span></td>

                                                @elseif($absen->absensi == "Tidak Hadir")

                                                <td style="vertical-align: middle;"><span class="badge badge-danger">{{ $absen->absensi }}</span></td>

                                                @else

                                                <td style="vertical-align: middle;"><span class="badge badge-info">{{ $absen->absensi }}</span></td>

                                                @endif

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

