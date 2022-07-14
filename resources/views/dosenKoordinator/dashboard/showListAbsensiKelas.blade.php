@extends('dosenKoordinator.layouts.admin-master')

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
        <a style="float: left;" href="/dosen-koordinator/dashboard"><button class="btn btn-success"><i class="fas fa-reply"></i> Kembali</button></a>
    </div>
    <br><br><br>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Absensi Kelas {{ $kelas->mata_kuliah }}</h4>
                        <div class="card-header-action">
                            <a href="/dosen-koordinator/export-excel-dosen/{{ $kelas->id_kelas }}/download" class="btn btn-success">
                                <i class="fas fa-file-excel"></i>
                                Export Excel Absensi Dosen
                            </a>
                            <div class="dropdown">
                                <a href="#" data-toggle="dropdown" class="btn btn-success dropdown-toggle" aria-expanded="false"><i class="fas fa-file-excel"></i> Export Excel Absensi Mahasiswa</a>
                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a href="/dosen-koordinator/export-excel/{{ $kelas->id_kelas }}/UTS/download" class="dropdown-item has-icon"><i class="fas fa-file-excel"></i> UTS</a>
                                    <a href="/dosen-koordinator/export-excel/{{ $kelas->id_kelas }}/UAS/download" class="dropdown-item has-icon"><i class="fas fa-file-excel"></i> UAS</a>
                                </div>
                            </div>
                            <a href="/dosen-koordinator/absensi-kelas/{{ $kelas->id_kelas }}/create" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Buat Absensi Kelas
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="div_table_1">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 16%;" data-field="mulai">Pertemuan</th>
                                        <th style="width: 20%;" data-field="mulai">Mulai</th>
                                        <th style="width: 20%;" data-field="selesai">Selesai</th>
                                        <th style="width: 19%;" data-field="status">Status</th>
                                        <th style="width: 20%;" data-field="status">Aksi</th>
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
                                            @if($absen->status == "Aktif")
                                            <span class="badge badge-info">{{ $absen->status }}</span>
                                            @elseif($absen->status == "Selesai")
                                            <span class="badge badge-success">{{ $absen->status }}</span>
                                            @elseif($absen->status == "Menunggu")
                                            <span class="badge badge-secondary">{{ $absen->status }}</span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <a class="btn btn-info" title="Lihat" href="/dosen-koordinator/absensi-kelas/{{ $absen->id_absensi_kelas }}"><i class="fas fa-eye"></i></a>    
                                            <a class="btn btn-warning" title="Edit" href="/dosen-koordinator/absensi-kelas/{{ $absen->id_absensi_kelas }}/edit"><i class="fas fa-edit"></i></a>
                                            <a class="btn btn-danger" title="Hapus" href="/dosen-koordinator/absensi-kelas/{{ $absen->id_absensi_kelas }}/delete" onclick="return confirm('Apakah anda yakin ingin menghapus?')"><i class="fas fa-trash"></i></a>
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
    function thnAkademikRefresh(){
        var id = document.getElementById("idThnAkademik").value;
        $.ajax({
            type: "get",
            url: "/dosen-koordinator/dashboard/absensi-kelas-refresh",
            dataType: 'json',
            data: {"id" : id}, // serializes the form's elements.
            success: function (msg, status, jqXHR){
                $('#table-1').DataTable().clear().draw();
                $('#table-1').DataTable().destroy();

                var div = '<table class="table table-striped" id="table-1">' +
                    '<thead>' +
                        '<tr>' +
                            '<th style="width: 5%;">#</th>' +
                            '<th style="width: 20%;" data-field="nama_dosen">Pertemuan</th>' +
                            '<th style="width: 20%;" data-field="nama_dosen">Mulai</th>' +
                            '<th style="width: 20%;" data-field="mulai">Selesai</th>' +
                            '<th style="width: 15%;" data-field="selesai">Status</th>' +
                            '<th style="width: 20%;" data-field="status">Aksi</th>' +
                        '</tr>' +
                    '</thead>' +
                    '<tbody>';

                var mulai = "";
                var selesai = "";
                $.each(msg, function(i,obj){
                    console.log(msg[i].mulai);
                    var num = i+1;
                    var stts = "";
                    if (msg[i].status == "Aktif") {
                        stts = '<option value="Menunggu">Menunggu</option>' + 
                            '<option value="Selesai">Selesai</option>';
                    } else if(msg[i].status == "Selesai"){
                        stts = '<option value="Aktif">Aktif</option>' + 
                            '<option value="Menunggu">Menunggu</option>';
                    } else {
                        stts = '<option value="Aktif">Aktif</option>' + 
                            '<option value="Selesai">Selesai</option>';
                    }

                    div += '<tr>' +
                            '<td style="vertical-align: middle;">' + num + '</td>' +
                            '<td style="vertical-align: middle;">Pertemuan ke-' + num + '</td>' +
                            '<td style="vertical-align: middle;">' + moment(msg[i].mulai).format('hh:mm DD-MM-YYYY') + '</td>' +
                            '<td style="vertical-align: middle;">' + moment(msg[i].selesai).format('hh:mm DD-MM-YYYY') + '</td>' +
                            '<td style="vertical-align: middle;">' +
                                '<form method="POST" action="/dosen-koordinator/absensi-kelas/' + msg[i].id_absensi_kelas + '/update-status">' +
                                    '@csrf' +
                                    '{{ method_field("PATCH") }}' +
                                    '<select class="form-control" name="status" onchange="this.form.submit();" required>' +
                                        '<option value="' + msg[i].status + '" selected>' + msg[i].status + '</option>' +
                                        stts +
                                    '</select>' +
                                '</form>' +
                            '</td>' +
                            '<td style="vertical-align: middle;">' +
                                '<a class="btn btn-info" title="Lihat" href="/dosen-koordinator/absensi-kelas/' + msg[i].id_absensi_kelas + '"><i class="fas fa-eye"></i></a>' +
                                '<a class="btn btn-warning" title="Edit" href="/dosen-koordinator/absensi-kelas/' + msg[i].id_absensi_kelas + '/edit"><i class="fas fa-edit"></i></a>' +
                                '<a class="btn btn-danger" title="Hapus" href="/dosen-koordinator/absensi-kelas/' + msg[i].id_absensi_kelas + '/delete"><i class="fas fa-trash"></i></a>' +
                            '</td>' +
                            '</tr>';
                });

                div +='</tbody>' +
                    '</table>';

                console.log(div);
                document.getElementById("div_table_1").innerHTML = div;
                $('#table-1').DataTable();
            }
        });
    }
</script>
@endsection
