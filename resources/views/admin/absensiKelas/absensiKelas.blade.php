@extends('admin.layouts.admin-master')

@section('title')
Absensi Kelas
@endsection

@section('css')
<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Absensi Kelas</h1>
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
                        <h4>Data Absensi Kelas</h4>
                        <div class="card-header-action">
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
                        </div>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive" id="div_table_2">
                        <table class="table table-striped" id="table-2">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 15%;" data-field="mata_kuliah">Kode Mata Kuliah</th>
                                    <th style="width: 45%;" data-field="mata_kuliah">Mata Kuliah</th>
                                    <th style="width: 15%;" data-field="kode_kelas">Kode Kelas</th>
                                    <th style="width: 20%;" data-field="status">Aksi</th>
                                </tr>
                            </thead>
                              <tbody>
                                  @foreach($absens as $key => $absen)
                                      <tr>
                                            <td style="vertical-align: middle;">{{ $key+1 }}</td>
                                            <td style="vertical-align: middle;">{{ $absen->kode_mata_kuliah }}</td>
                                            <td style="vertical-align: middle;">{{ $absen->mata_kuliah }}</td>
                                            <td style="vertical-align: middle;">{{ $absen->kode_kelas }}</td>
                                            <td style="vertical-align: middle;">
                                                <a class="btn btn-info" title="Lihat" href="absensi-kelas/{{ $absen->id_kelas }}"><i class="fas fa-eye"></i></a>    
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
            url: "/admin/dashboard/absensi-kelas-refresh",
            dataType: 'json',
            data: {"id" : id}, // serializes the form's elements.
            success: function (msg, status, jqXHR){
                $('#table-2').DataTable().clear().draw();
                $('#table-2').DataTable().destroy();

                var div = '<table class="table table-striped" id="table-2">' +
                    '<thead>' +
                        '<tr>' +
                            '<th style="width: 5%;">#</th>' +
                            '<th style="width: 15%;" data-field="mata_kuliah">Kode Mata Kuliah</th>' +
                            '<th style="width: 45%;" data-field="mata_kuliah">Mata Kuliah</th>' +
                            '<th style="width: 15%;" data-field="kode_kelas">Kode Kelas</th>' +
                            '<th style="width: 20%;" data-field="status">Aksi</th>' +
                        '</tr>' +
                    '</thead>' +
                    '<tbody>';

                var mulai = "";
                var selesai = "";
                $.each(msg, function(i,obj){
                    var num = i+1;

                    div += '<tr>' +
                            '<td style="vertical-align: middle;">' + num + '</td>' +
                            '<td style="vertical-align: middle;">' + msg[i].kode_mata_kuliah + '</td>' +
                            '<td style="vertical-align: middle;">' + msg[i].mata_kuliah + '</td>' +
                            '<td style="vertical-align: middle;">' + msg[i].kode_kelas + '</td>' +
                            '<td style="vertical-align: middle;">' +
                                '<a class="btn btn-info" title="Lihat" href="absensi-kelas/' + msg[i].id_kelas + '"><i class="fas fa-eye"></i></a>' +
                            '</td>' +
                        '</tr>';
                });

                div +='</tbody>' +
                    '</table>';

                document.getElementById("div_table_2").innerHTML = div;
                $('#table-2').DataTable();
            }
        });
    }
</script>
@endsection

