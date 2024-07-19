<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleLoginController;
use App\Livewire\DashBoard;
use App\Livewire\Survey\DimensionsList;
use App\Livewire\Survey\CreateSurvey;
use App\Livewire\Survey\DetailSurvey;
use App\Livewire\Survey\OverviewSurveyAdmin;
use App\Livewire\Survey\FillSurvey;
use App\Livewire\Survey\FillSurveyDetail;
use App\Livewire\Option\CreateAnswerOptionPage;
use App\Livewire\RoleManagement\RoleManagement;
use App\Livewire\TargetResponden\TargetRespondenPage;
use App\Livewire\Survey\Monitoring;
use App\Mail\RespondenSurveyAnnounceFirst;
use App\Livewire\Survey\CopySurvey;
use App\Livewire\Survey\PageCreateSurvey;
use App\Livewire\Survey\CopySurvey\PageCopySurvey;
use App\Livewire\Survey\CopySurvey\EditingCopySurvey;
use App\Livewire\Survey\Resampling;
use App\Livewire\Visualization\VPage;
use Illuminate\Support\Facades\Auth;
use Spatie\Csp\AddCspHeaders;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::get('/', function () {
//     if (Auth::check()) {
//         return redirect('/dashboard');
//     } else {
//         // return view('auth.login'); // Halaman login
//         return redirect('/dashboard');
//     }
// });

Route::get('/', DashBoard::class)->name('dashboard');
Route::get('test', fn () => phpinfo());

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
});

// GoogleLoginController redirect and callback urls
Route::get('/login/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/login/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);

// FOR GUEST USER
// dashboard
Route::get('/dashboard', DashBoard::class)->name('dashboard');
// untuk visualisasi survei
Route::get('survei/visualisasi', VPage::class)->name('survey.visualize');
// untuk mengisi survei
Route::get('/survei/isi', FillSurvey::class)->name('survey.fill.overview');
Route::get('/survei/isi/{uuid}/{uniqueCode?}', FillSurveyDetail::class)->name('survey.fill');
// Route::get('/survei/isi/{surveyID}/{uniqueCode?}', FillSurveyDetail::class)->name('survey.fill');

Route::group(['middleware' => ['auth:sanctum', 'verified', 'role:SuperAdmin|Admin|Operator']], function () {
    Route::get('/resampling', Resampling::class)->name('resampling');
});

Route::group(['middleware' => ['auth:sanctum', 'verified', 'role:SuperAdmin|Admin|Operator']], function () {
    Route::get('/dimensi', DimensionsList::class)->name('dimensi');
    // untuk pembuatan survey
    Route::get('/survei/buat', PageCreateSurvey::class)->name('page.survey.create');
    Route::get('/survei/buat/manual/{oldSurveyID?}', CreateSurvey::class)->name('survey.create');
    Route::get('/survei/buat/salin', PageCopySurvey::class)->name('survey.copy');
    Route::get('/survei/buat/salin/{oldSurveyID}', EditingCopySurvey::class)->name('survey.copy.detail');
    // end
    Route::get('/survei', OverviewSurveyAdmin::class)->name('survey');
    Route::get('/survei/detail/{surveyID}', DetailSurvey::class)->name('survey.detail');
    Route::get('/survei/monitoring/{surveyID}', Monitoring::class)->name('survey.monitoring');
    // untuk nambah option
    Route::get('/tambah-opsi-jawaban', CreateAnswerOptionPage::class)->name('add.option');
    Route::get('/target-responden', TargetRespondenPage::class)->name('target.responden');
    // role management
    Route::get('/role-management', RoleManagement::class)->name('roleManagement.page');

    Route::get('/mailable', function () {
        // $invoice = App\Models\Invoice::find(1);
        $data = [
            'name' => 'Jantinnerezo',
            'email' => 'haniefm19@mgial.com',
            'unqiue_code' => '123456',
            'survey_id' => 1,
        ];
        return new RespondenSurveyAnnounceFirst($data);
    });
});

// untuk error
Route::get('/404', function () {
    return view('errors.404');
})->name('notfound');

// template
Route::view('forms', 'forms')->name('forms');
Route::view('cards', 'cards')->name('cards');
Route::view('charts', 'charts')->name('charts');
Route::view('buttons', 'buttons')->name('buttons');
Route::view('modals', 'modals')->name('modals');
Route::view('tables', 'tables')->name('tables');
Route::view('calendar', 'calendar')->name('calendar');
