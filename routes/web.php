<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect('admin/dashboard');
});

Route::get('home', function() {
    return redirect('admin/dashboard');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/login', 'UserController@login')->name('login');
Route::get('/register', 'UserController@create')->name('register');
// Route::post('/login', 'UserController@loginCheck');
Route::post('/register', 'UserController@store');

// Route::get('/admin/user', 'UserController@index');

Route::prefix('admin')->namespace('admin')->middleware(['auth','admin'])->group(function() {
    Route::get('dashboard', 'DashboardController')->name('dashboard');
    Route::get('dashboard/absensi-kelas-refresh', 'DashboardController@absensiKelasRefresh');
    
    Route::resource('absensi-kegiatan', 'AbsensiKegiatanController');
    Route::get('absensi-kegiatan/{id}/delete', ['uses' => 'AbsensiKegiatanController@destroy', 'as' => 'absensi-kegiatan.delete']);
    Route::patch('absensi-kegiatan/{id}/absen', ['uses' => 'AbsensiKegiatanController@absen', 'as' => 'absensi-kegiatan.absen']);
    Route::patch('absensi-kegiatan/{id}/update-status', ['uses' => 'AbsensiKegiatanController@updateStatus', 'as' => 'absensi-kegiatan.update-status']);

    Route::resource('absensi-kelas', 'AbsensiKelasController');
    Route::get('export-excel/{id}/{smt}/download', 'AbsensiKelasController@exportExcel');
    Route::get('export-excel-dosen/{id}/download', 'AbsensiKelasController@exportExcelDosen');

    Route::resource('dosen', 'DosenController');
    Route::get('dosen/{id}/delete', ['uses' => 'DosenController@destroy', 'as' => 'dosen.delete']);

    Route::resource('pengampu', 'PengampuController');
    Route::get('pengampu/{id}/delete', ['uses' => 'PengampuController@destroy', 'as' => 'pengampu.delete']);
    Route::get('pengampu/pengampu/refresh', 'PengampuController@pengampuRefresh');

    Route::resource('mahasiswa', 'MahasiswaController');
    Route::get('mahasiswa/{id}/delete', ['uses' => 'MahasiswaController@destroy', 'as' => 'mahasiswa.delete']);

    Route::resource('detail-kelas', 'DetKelasController');
    Route::get('detail-kelas/{id}/delete', ['uses' => 'DetKelasController@destroy', 'as' => 'detail-kelas.delete']);
    Route::get('detail-kelas/detail-kelas/refresh', 'DetKelasController@detKelasRefresh');

    Route::resource('mata-kuliah', 'MataKuliahController');
    Route::get('mata-kuliah/{id}/delete', ['uses' => 'MataKuliahController@destroy', 'as' => 'mata-kuliah.delete']);

    Route::resource('kelas', 'KelasController');
    Route::get('kelas/{id}/delete', ['uses' => 'KelasController@destroy', 'as' => 'kelas.delete']);
    Route::get('kelas/kelas/refresh', 'KelasController@kelasRefresh');

    Route::resource('staff', 'StaffController');
    Route::get('staff/{id}/delete', ['uses' => 'StaffController@destroy', 'as' => 'staff.delete']);

    Route::get('export-excel/{id}/download', 'AbsensiKegiatanController@exportExcel');

    Route::resource('user', 'UserController');

    Route::resource('prodi', 'ProdiController');
    Route::get('prodi/{id}/delete', ['uses' => 'ProdiController@destroy', 'as' => 'prodi.delete']);

    Route::resource('tahun-akademik', 'TahunAkademikController');
    Route::get('tahun-akademik/{id}/delete', ['uses' => 'TahunAkademikController@destroy', 'as' => 'tahun-akademik.delete']);
});

Route::prefix('staff')->namespace('staff')->middleware(['auth','staff'])->group(function() {
    Route::get('dashboard', 'DashboardController')->name('dashboard');

    Route::resource('absensi-kegiatan', 'AbsensiKegiatanController');
    Route::patch('absensi-kegiatan/{id}/absen', ['uses' => 'AbsensiKegiatanController@absen', 'as' => 'absensi-kegiatan.absen']);

    Route::resource('user', 'UserController');

});

Route::prefix('dosen-koordinator')->namespace('dosenKoordinator')->middleware(['auth','dosenKoordinator'])->group(function() {
    Route::get('dashboard', 'DashboardController')->name('dashboard');
    Route::get('dashboard/absensi-kelas-refresh', 'DashboardController@absensiKelasRefresh');
    Route::get('dashboard/{id}', 'DashboardController@showListAbsensiKelas');

    Route::resource('absensi-kelas', 'AbsensiKelasController');
    Route::get('absensi-kelas/{id}/delete', ['uses' => 'AbsensiKelasController@destroy', 'as' => 'absensi-kelas.delete']);
    Route::patch('absensi-kelas/{id}/update-status', ['uses' => 'AbsensiKelasController@updateStatus', 'as' => 'absensi-kelas.update-status']);
    Route::patch('absensi-kelas/{id}/update-materi-metode', ['uses' => 'AbsensiKelasController@updateMateriMetode', 'as' => 'absensi-kelas.update-materi-metode']);
    Route::patch('absensi-kelas/{id}/absen-dosen', ['uses' => 'AbsensiKelasController@absenDosen', 'as' => 'absensi-kelas.absen-dosen']);
    Route::get('absensi-kelas/{id}/create', ['uses' => 'AbsensiKelasController@create', 'as' => 'absensi-kelas.store']);

    Route::resource('absensi-kegiatan', 'AbsensiKegiatanController');
    Route::patch('absensi-kegiatan/{id}/absen', ['uses' => 'AbsensiKegiatanController@absen', 'as' => 'absensi-kegiatan.absen']);

    Route::get('export-excel/{id}/{smt}/download', 'AbsensiKelasController@exportExcel');
    Route::get('export-excel-dosen/{id}/download', 'AbsensiKelasController@exportExcelDosen');

    Route::resource('user', 'UserController');

});

Route::prefix('dosen')->namespace('dosen')->middleware(['auth','dosen'])->group(function() {
    Route::get('dashboard', 'DashboardController')->name('dashboard');
    Route::get('dashboard/absensi-kelas-refresh', 'DashboardController@absensiKelasRefresh');
    Route::get('dashboard/{id}', 'DashboardController@showListAbsensiKelas');
    
    Route::resource('absensi-kelas', 'AbsensiKelasController');
    Route::patch('absensi-kelas/{id}/update-status', ['uses' => 'AbsensiKelasController@updateStatus', 'as' => 'absensi-kelas.update-status']);
    Route::patch('absensi-kelas/{id}/update-materi-metode', ['uses' => 'AbsensiKelasController@updateMateriMetode', 'as' => 'absensi-kelas.update-materi-metode']);
    Route::patch('absensi-kelas/{id}/absen-dosen', ['uses' => 'AbsensiKelasController@absenDosen', 'as' => 'absensi-kelas.absen-dosen']);

    Route::resource('absensi-kegiatan', 'AbsensiKegiatanController');
    Route::patch('absensi-kegiatan/{id}/absen', ['uses' => 'AbsensiKegiatanController@absen', 'as' => 'absensi-kegiatan.absen']);

    Route::resource('user', 'UserController');

});

Route::namespace('mahasiswa')->middleware(['auth','mahasiswa'])->group(function() {
    Route::get('dashboard', 'DashboardController')->name('dashboard');
    Route::get('dashboard/{id}', 'DashboardController@showListAbsensiKelas');
    
    Route::resource('absensi-kelas', 'AbsensiKelasController');

    Route::resource('user', 'UserController');
});

Route::middleware('auth')->get('logout', function() {
    Auth::logout();
    return redirect(route('login'))->withInfo('You have successfully logged out!');
})->name('logout');

// Auth::routes(['verify' => true]);

Route::name('js.')->group(function() {
    Route::get('dynamic.js', 'JsController@dynamic')->name('dynamic');
});

// Get authenticated user
Route::get('users/auth', function() {
    return response()->json(['user' => Auth::check() ? Auth::user() : false]);
});

Route::get('reset', function (){
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
});