@extends('admin.layouts.admin-master')

@section('title')
Data Kelas
@endsection

@section('css')
<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Kelas</h1>
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
                        <h4>Tabel Data Kelas</h4>
                        <div class="card-header-action">
                            <a href="kelas/create" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Tambah Data
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group" style="margin: 0;">
                            <select id="idThnAkademik" class="form-control" name="id" onchange="thnAkademikRefresh();" required>
                                @foreach($thnAkademiks as $thnAkademik)
                                @if($thnAkademik->id_thn_akademik == $thnAkademikSekarang['id_thn_akademik'])
                                <option value="{{ $thnAkademik->id_thn_akademik }}" selected>{{ $thnAkademik->thn_akademik_1 }}/{{ $thnAkademik->thn_akademik_2 }} - Semester {{ $thnAkademik->semester }}</option>
                                @else
                                <option value="{{ $thnAkademik->id_thn_akademik }}">{{ $thnAkademik->thn_akademik_1 }}/{{ $thnAkademik->thn_akademik_2 }} - Semester {{ $thnAkademik->semester }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div> 
                        <br>
                        <div class="table-responsive" id="div_table_1">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 10%;" data-field="kode_kelas">Kode Kelas</th>
                                        <th style="width: 20%;" data-field="nama_dosen">Program Studi</th>
                                        <th style="width: 45%;" data-field="nama_dosen">Mata Kuliah</th>
                                        <th style="width: 20%;" data-field="mulai">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kelass as $key => $kelas)
                                        <tr>
                                            <td style="vertical-align: middle;">{{ $key+1 }}</td>
                                            <td style="vertical-align: middle;">{{ $kelas->kode_kelas }}</td>
                                            <td style="vertical-align: middle;">{{ $kelas->prodi }}</td>
                                            <td style="vertical-align: middle;">{{ $kelas->kode_mata_kuliah }} - {{ $kelas->mata_kuliah }} ({{ $kelas->prodi }})</td>
                                            <td style="vertical-align: middle;">
                                                <a class="btn btn-warning" href="kelas/{{ $kelas->id_kelas }}/edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                                <a class="btn btn-danger" href="kelas/{{ $kelas->id_kelas }}/delete" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus?')"><i class="fas fa-trash"></i></a>
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
<script>
    $(document).ready(function(){
        $('#table-1').DataTable();
    });
    
    function thnAkademikRefresh(){
        var id = document.getElementById("idThnAkademik").value;
        $.ajax({
            type: "get",
            url: "/admin/kelas/kelas/refresh",
            dataType: 'json',
            data: {"id" : id}, // serializes the form's elements.
            success: function (msg, status, jqXHR){
                $('#table-1').DataTable().clear().draw();
                $('#table-1').DataTable().destroy();

                var div = '<table class="table table-striped" id="table-1">' +
                    '<thead>' +
                        '<tr>' +
                            '<th style="width: 5%;">#</th>' +
                            '<th style="width: 10%;" data-field="kode_kelas">Kode Kelas</th>' +
                            '<th style="width: 20%;" data-field="nama_dosen">Program Studi</th>' +
                            '<th style="width: 45%;" data-field="nama_dosen">Mata Kuliah</th>' +
                            '<th style="width: 20%;" data-field="mulai">Aksi</th>' +
                        '</tr>' +
                    '</thead>' +
                    '<tbody>';
                    
                $.each(msg, function(i,obj){
                    var num = i+1;

                    div += "<tr>" +
                        "<td style='vertical-align: middle;'>" + num + "</td>" +
                        "<td style='vertical-align: middle;'>" + msg[i].kode_kelas + "</td>" +
                        "<td style='vertical-align: middle;'>" + msg[i].prodi + "</td>" +
                        "<td style='vertical-align: middle;'>" + msg[i].kode_mata_kuliah + " - " + msg[i].mata_kuliah + " (" + msg[i].prodi + ")" + "</td>" +
                        "<td style='vertical-align: middle;'>" +
                            "<a class='btn btn-warning' href='kelas/" + msg[i].id_kelas + "/edit' title='Edit' ><i class='fas fa-edit'></i></a>" +
                            "<a class='btn btn-danger' href='kelas/" + msg[i].id_kelas + "/delete' title='Hapus' onclick='return confirm(`Apakah anda yakin ingin menghapus?`)'><i class='fas fa-trash'></i></a>" +
                        "</td>" +
                        "</tr>";
                });

                div +='</tbody>' +
                    '</table>';

                document.getElementById("div_table_1").innerHTML = div;
                $('#table-1').DataTable();
            }
        });
    }
</script>

<!-- JS Libraies -->
<script src="/assets/modules/datatables/datatables.min.js"></script>
<script src="/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
<script src="/assets/modules/jquery-ui/jquery-ui.min.js"></script>

<!-- Page Specific JS File -->
<script src="/assets/js/page/modules-datatables.js"></script>

@endsection
