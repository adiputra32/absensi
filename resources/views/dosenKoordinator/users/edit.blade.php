@extends('dosenKoordinator.layouts.admin-master')

@section('title')
Ubah Password
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Ubah Password</h1>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Form Ubah Password</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ action('dosenKoordinator\UserController@update', $user->id_user) }}">
                    @csrf
                    {{ method_field('PATCH') }}
                    <div class="form-group row">
                        <div class="col-form-label col-sm-2">Password Baru</div>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" placeholder="Password Baru" required>
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
