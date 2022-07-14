@extends('admin.layouts.admin-master')

@section('title')
Edit Data Kelas
@endsection

@section('css')
<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Data Kelas</h1>
    </div>

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

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Data Kelas</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ action('admin\KelasController@update', $kelas->id_kelas) }}">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Kode Kelas</div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="kode_kelas" placeholder="Kode Kelas" value="{{ $kelas->kode_kelas }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Program Studi</div>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_prodi" required>
                                        @foreach($prodis as $prodi)
                                        @if($prodi->id_prodi == $kelas->id_prodi)
                                        <option value="{{ $prodi->id_prodi }}" selected>{{ $prodi->prodi }}</option>
                                        @else
                                        <option value="{{ $prodi->id_prodi }}">{{ $prodi->prodi }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Mata Kuliah</div>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_mata_kuliah" required>
                                        <option value="{{ $kelas->id_mata_kuliah }}">{{ $kelas->kode_mata_kuliah }} - {{ $kelas->mata_kuliah }}</option>
                                        @foreach($matkuls as $matkul)
                                        @if($matkul->id_mata_kuliah != $kelas->id_mata_kuliah)
                                        <option value="{{ $matkul->id_mata_kuliah }}">{{ $matkul->kode_mata_kuliah }} - {{ $matkul->mata_kuliah }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Tahun Akademik</div>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_thn_akademik" required>
                                        @foreach($thnAkademiks as $thnAkademik)
                                        @if($thnAkademik->id_thn_akademik == $matkul['id_thn_akademik'])
                                        <option value="{{ $thnAkademik->id_thn_akademik }}" selected>{{ $thnAkademik->thn_akademik_1 }}/{{ $thnAkademik->thn_akademik_2 }} - Semester {{ $thnAkademik->semester }}</option>
                                        @else
                                        <option value="{{ $thnAkademik->id_thn_akademik }}">{{ $thnAkademik->thn_akademik_1 }}/{{ $thnAkademik->thn_akademik_2 }} - Semester {{ $thnAkademik->semester }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                                          
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
              </div>
        </div>
    </div>
</section>
@endsection