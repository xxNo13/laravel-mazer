<?php

use App\Http\Livewire\OpcrLivewire;
use App\Http\Livewire\TtmaLivewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Livewire\ConfigureLivewire;
use App\Http\Livewire\DashboardLivewire;
use App\Http\Livewire\IpcrStaffLivewire;
use App\Http\Livewire\OfficemateLivewire;
use App\Http\Livewire\FacultyIpcrLivewire;
use App\Http\Livewire\ForapprovalLivewire;
use App\Http\Livewire\IpcrFacultyLivewire;
use App\Http\Livewire\StandardStaffLivewire;
use App\Http\Livewire\StandardFacultyLivewire;
use App\Http\Livewire\TrainingRecommendationLivewire;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

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

Route::get('/', function () {
    return redirect('dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardLivewire::class)->name('dashboard');

    // Where Head of Agency can add the IPCR for Faculty
    Route::get('/ipcr/add/faculty', IpcrFacultyLivewire::class)->name('ipcr.add.faculty');
    // Where Faculty can view their choosen target of IPCR
    Route::get('/ipcr/faculty', FacultyIpcrLivewire::class)->name('ipcr.faculty');

    Route::get('/training-recommendation', TrainingRecommendationLivewire::class)->name('training.recommendation');

    Route::get('/ipcr/staff', IpcrStaffLivewire::class)->name('ipcr.staff');
    Route::get('/opcr', OpcrLivewire::class)->name('opcr');
    Route::get('/standard/staff', StandardStaffLivewire::class)->name('standard.staff');
    Route::get('/standard/faculty', StandardFacultyLivewire::class)->name('standard.faculty');
    Route::get('/officemates', OfficemateLivewire::class)->name('officemates');
    Route::get('/for-approval', ForapprovalLivewire::class)->name('for-approval');
    Route::get('/ttma', TtmaLivewire::class)->name('ttma');
    Route::get('/configure', ConfigureLivewire::class)->name('configure');

    Route::get('/print/{print}', [PDFController::class, 'print'])->name('print');
    Route::get('/view', [PDFController::class, 'view'])->name('view');

    // Registration...
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register.user');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});
