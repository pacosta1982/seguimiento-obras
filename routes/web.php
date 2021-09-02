<?php

use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    return view('home');
});*/

Route::get('/', 'App\Http\Controllers\Admin\HomeController@dashboard');

Route::get('/projects', 'App\Http\Controllers\Admin\HomeController@index');
Route::get('/projects/{project}/show', 'App\Http\Controllers\Admin\HomeController@show');
Route::get('/visits/{visit}/show', 'App\Http\Controllers\Admin\HomeController@showVisit');
//Expedientes
Route::get('/files', 'App\Http\Controllers\Admin\ExpedienteController@index');
Route::get('files/{numero}', 'App\Http\Controllers\Admin\ExpedienteController@show');
//Potulantes
Route::get('/applicants', 'App\Http\Controllers\Admin\PostulanteController@index');
Route::get('/applicants/{cedula}', 'App\Http\Controllers\Admin\PostulanteController@show');
//Beneficiarios
Route::get('/beneficiaries', 'App\Http\Controllers\Admin\BeneficiarioController@index');
Route::get('/beneficiaries/{cedula}', 'App\Http\Controllers\Admin\BeneficiarioController@show');


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('admin-users')->name('admin-users/')->group(static function () {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('visits')->name('visits/')->group(static function () {
            Route::get('/',                                             'VisitsController@index')->name('index');
            Route::get('/create',                                       'VisitsController@create')->name('create');
            Route::post('/',                                            'VisitsController@store')->name('store');
            Route::get('/{visit}/edit',                                 'VisitsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'VisitsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{visit}',                                     'VisitsController@update')->name('update');
            Route::delete('/{visit}',                                   'VisitsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('projects')->name('projects/')->group(static function () {
            Route::get('/',                                             'ProjectController@index')->name('index');
            Route::get('/{project}/show',                                'ProjectController@show');
            Route::get('/create',                                       'ProjectController@create')->name('create');
            Route::post('/',                                            'ProjectController@store')->name('store');
            Route::get('/{visit}/edit',                                 'ProjectController@edit')->name('edit');
            Route::get('/visit/{project}/create',                       'ProjectController@createvisit');
            Route::post('/bulk-destroy',                                'ProjectController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{visit}',                                     'ProjectController@update')->name('update');
            Route::delete('/{visit}',                                   'ProjectController@destroy')->name('destroy');
        });
    });
});
