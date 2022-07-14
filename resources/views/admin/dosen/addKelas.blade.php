@extends('admin.layouts.admin-master')

@section('title')
Data Kelas Dosen
@endsection

@section('css')
<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $dosen->nama_dosen }}</h1>
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
        <a style="float: left;" href="/admin/dosen"><button class="btn btn-success"><i class="fas fa-reply"></i> Kembali</button></a>
    </div>
    <br><br><br>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Data Kelas Dosen</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ action('admin\PengampuController@store') }}">
                            @csrf

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Mata Kuliah</div>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_kelas[]" required>
                                        @foreach($matkuls as $matkul)
                                            <option value="{{ $matkul['id_kelas'] }}">{{ $matkul['kode_mata_kuliah'] }} - {{ $matkul['mata_kuliah'] }} ({{ $matkul['kode_kelas'] }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div id="newForm"></div>

                            <script>
                                var i = 1;
                                function duplicate(){
                                    i = i+1;
                                    
                                    var div = document.createElement("div");
                                    div.innerHTML = `<div class="form-group row" id="newForm`+i+`">`+
                                        `<div class="col-form-label col-sm-2">Mata Kuliah</div>`+
                                        `<div class="col-sm-9">`+
                                            `<select class="form-control" name="id_kelas[]" required>`+
                                                `@foreach($matkuls as $matkul)`+
                                                    `<option value="{{ $matkul['id_kelas'] }}">{{ $matkul['kode_mata_kuliah'] }} - {{ $matkul['mata_kuliah'] }} ({{ $matkul['kode_kelas'] }})</option>`+
                                                `@endforeach`+                                    
                                            `</select>`+
                                        `</div>`+
                                        `<div class="col-sm-1">`+
                                        `<button type="button" class="btn btn-danger" onclick="deleteForm(`+i+`)"><i class="fas fa-trash"></i></button>`+
                                        `</div>`+
                                    `</div>`;
                                    document.getElementById("newForm").appendChild(div); 
                                }
                            
                                function deleteForm(id){
                                    document.getElementById('newForm'+id).parentNode.removeChild(document.getElementById('newForm'+id));
                                }
                            </script>

                            <div class="form-group">
                                <center><button class="btn btn-primary" type="button" onclick="duplicate()"><i class="fas fa-plus"></i> Tambah Kelas</button></center>
                            </div>
                            
                            <div class="modal-footer">
                                <input type="hidden" name="id_dosen" value="{{ $dosen->id_dosen }}">
                                @if(empty($matkuls))
                                <button type="submit" class="btn btn-primary" disabled>Simpan</button>
                                @else
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Data Kelas Dosen </h4>
                        <div class="card-header-action">
                            <div class="form-group" style="margin: 0;">
                                <script>
                                    function thnAkademikRefresh(){
                                        var id_thn_akademik = document.getElementById("idThnAkademik").value;
                                        var id_dosen = document.getElementById("idDosen").value;
                                        $.ajax({
                                            type: "get",
                                            url: "/admin/pengampu/pengampu/refresh",
                                            dataType: 'json',
                                            data: {"id_thn_akademik" : id_thn_akademik, "id_dosen" : id_dosen}, // serializes the form's elements.
                                            success: function (msg, status, jqXHR){
                                                console.log(msg);
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
                                                                '<a class="btn btn-danger" href="/admin/kelas/' + msg[i].id_pengampu + '/delete" onclick="return confirm(`Apakah anda yakin ingin menghapus?`)"><i class="fas fa-trash"></i></a>' +
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

                                <select id="idThnAkademik" class="form-control" name="id" onchange="thnAkademikRefresh();" required>
                                    @foreach($thnAkademiks as $thnAkademik)
                                    @if($thnAkademik->id_thn_akademik == $thnAkademikSekarang['id_thn_akademik'])
                                    <option value="{{ $thnAkademik->id_thn_akademik }}" selected>{{ $thnAkademik->thn_akademik_1 }}/{{ $thnAkademik->thn_akademik_2 }} - Semester {{ $thnAkademik->semester }}</option>
                                    @else
                                    <option value="{{ $thnAkademik->id_thn_akademik }}">{{ $thnAkademik->thn_akademik_1 }}/{{ $thnAkademik->thn_akademik_2 }} - Semester {{ $thnAkademik->semester }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <input type="hidden" id="idDosen" value="{{ $dosen->id_dosen }}">
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
                                    @foreach($kelass as $key => $kelas)
                                        <tr>
                                            <td style="vertical-align: middle;">{{ $key+1 }}</td>
                                            <td style="vertical-align: middle;">{{ $kelas->kode_mata_kuliah }}</td>
                                            <td style="vertical-align: middle;">{{ $kelas->mata_kuliah }}</td>
                                            <td style="vertical-align: middle;">{{ $kelas->kode_kelas }}</td>  
                                            <td style="vertical-align: middle;">
                                                <a class="btn btn-danger" href="/admin/pengampu/{{ $kelas->id_pengampu }}/delete" onclick="return confirm('Apakah anda yakin ingin menghapus?')"><i class="fas fa-trash"></i></a>
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
