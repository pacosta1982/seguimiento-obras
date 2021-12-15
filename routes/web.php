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

/*Route::get('/ejemplo', function () {
    $filename = 'temp-image.jpg';
    $tempImage = tempnam(sys_get_temp_dir(), $filename);
    copy('https://movil.stp.gov.py/staticFiles/1631802246615.jpg', $tempImage);
    return response()->download($tempImage, $filename);
});
*/


Route::get('/', 'App\Http\Controllers\Admin\HomeController@dashboard');
Route::get('/download/{name}', 'App\Http\Controllers\Admin\VisitsController@download');



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
            Route::get('/{project}/sync',                               'VisitsController@sync')->name('sync');
            Route::get('/{project}/{rel}/syncstore',                    'VisitsController@syncstore')->name('syncstore');
            Route::get('/{project}/{rel}/syncimage',                    'VisitsController@syncimage')->name('syncimage');
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


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('questionnaires')->name('questionnaires/')->group(static function() {
            Route::get('/',                                             'QuestionnairesController@index')->name('index');
            Route::get('/create',                                       'QuestionnairesController@create')->name('create');
            Route::post('/',                                            'QuestionnairesController@store')->name('store');
            Route::get('/{questionnaire}/edit',                         'QuestionnairesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'QuestionnairesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{questionnaire}',                             'QuestionnairesController@update')->name('update');
            Route::delete('/{questionnaire}',                           'QuestionnairesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('questions')->name('questions/')->group(static function() {
            Route::get('/',                                             'QuestionsController@index')->name('index');
            Route::get('/create',                                       'QuestionsController@create')->name('create');
            Route::post('/',                                            'QuestionsController@store')->name('store');
            Route::get('/{question}/edit',                              'QuestionsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'QuestionsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{question}',                                  'QuestionsController@update')->name('update');
            Route::delete('/{question}',                                'QuestionsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('project-questions')->name('project-questions/')->group(static function() {
            Route::get('/',                                             'ProjectQuestionController@index')->name('index');
            Route::get('/create',                                       'ProjectQuestionController@create')->name('create');
            Route::post('/',                                            'ProjectQuestionController@store')->name('store');
            Route::get('/{projectQuestion}/edit',                       'ProjectQuestionController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ProjectQuestionController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{projectQuestion}',                           'ProjectQuestionController@update')->name('update');
            Route::delete('/{projectQuestion}',                         'ProjectQuestionController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('users')->name('users/')->group(static function() {
            Route::get('/',                                             'UsersController@index')->name('index');
            Route::get('/create',                                       'UsersController@create')->name('create');
            Route::post('/',                                            'UsersController@store')->name('store');
            Route::get('/{user}/edit',                                  'UsersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'UsersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{user}',                                      'UsersController@update')->name('update');
            Route::delete('/{user}',                                    'UsersController@destroy')->name('destroy');
        });
    });
});