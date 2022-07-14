@extends('dosenKoordinator.layouts.admin-master')

@section('title')
Buat Absensi Kelas
@endsection

@section('css')
<link rel="stylesheet" href="/assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Buat Absensi Kelas {{ $kelas->mata_kuliah }}</h1>
    </div>

    <div style="width: 100%;">
        <a style="float: left;" href="/dosen-koordinator/dashboard/{{ $kelas->id_kelas }}"><button class="btn btn-success"><i class="fas fa-reply"></i> Kembali</button></a>
    </div>
    <br><br><br>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Absensi Kelas {{ $kelas->mata_kuliah }}</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ action('dosenKoordinator\AbsensiKelasController@store') }}">
                            @csrf                            
                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Waktu Mulai</div>
                                <div class="col-sm-10">
                                    <input type="datetime-local" class="form-control" name="mulai" placeholder="Waktu Mulai" value="{{ old('mulai') }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-form-label col-sm-2">Waktu Selesai</div>
                                <div class="col-sm-10">
                                    <input type="datetime-local" class="form-control" name="selesai" placeholder="Waktu Selesai" value="{{ old('selesai') }}" required>
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <input type="hidden" name="id_kelas" value="{{ $kelas->id_kelas }}">
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