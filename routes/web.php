<?php

use Laravel\Fortify\Features;
use App\Http\Livewire\OpcrLivewire;
use App\Http\Livewire\TtmaLivewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Livewire\TrainingLivewire;
use App\Http\Livewire\ConfigureLivewire;
use App\Http\Livewire\DashboardLivewire;
use App\Http\Livewire\IpcrStaffLivewire;
use App\Http\Livewire\OfficemateLivewire;
use App\Http\Livewire\FacultyIpcrLivewire;
use App\Http\Livewire\ForapprovalLivewire;
use App\Http\Livewire\IpcrFacultyLivewire;
use App\Http\Livewire\AgencyTargetLivewire;
use App\Http\Livewire\StandardOpcrLivewire;
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
    Route::get('/training-recommendation', TrainingRecommendationLivewire::class)->name('training.recommendation');
    Route::get('/ttma', TtmaLivewire::class)->name('ttma');
    Route::get('/print/{print}', [PDFController::class, 'print'])->name('print');


    // Head of Agency Route
    Route::middleware(['headagency'])->group(function () {
        // Where Head of Agency can add the IPCR for Faculty
        Route::get('/ipcr/add/faculty', IpcrFacultyLivewire::class)->name('ipcr.add.faculty');
        Route::get('/configure', ConfigureLivewire::class)->name('configure');
    });

    // Head of Office and Delivery Unit Route
    Route::middleware(['headoordu'])->group(function () {
        Route::get('/trainings', TrainingLivewire::class)->name('trainings');
        Route::get('/for-approval', ForapprovalLivewire::class)->name('for-approval');
        Route::get('/opcr', OpcrLivewire::class)->name('opcr');
        Route::get('/standard/opcr', StandardOpcrLivewire::class)->name('standard.opcr');
        Route::get('/subordinates', OfficemateLivewire::class)->name('officemates');
    });

    // Staff Route
    Route::middleware(['staff'])->group(function () {
        Route::get('/standard/staff', StandardStaffLivewire::class)->name('standard.staff');
        Route::get('/ipcr/staff', IpcrStaffLivewire::class)->name('ipcr.staff');
    });

    // Faculty Route
    Route::middleware(['faculty'])->group(function () {
        // Where Faculty can view their choosen target of IPCR
        Route::get('/ipcr/faculty', FacultyIpcrLivewire::class)->name('ipcr.faculty');
        Route::get('/standard/faculty', StandardFacultyLivewire::class)->name('standard.faculty');
    });

    // Office PMO Route
    Route::middleware(['pmo'])->group(function () {
        Route::get('/agency/target', AgencyTargetLivewire::class)->name('agency.target');
    });

    // Office HRMO Route
    Route::middleware(['hrmo'])->group(function () {
        // Registration...
        $enableViews = config('fortify.views', true);
        if (Features::enabled(Features::registration())) {
            if ($enableViews) {
                Route::get('/register', [RegisteredUserController::class, 'create'])
                    ->middleware(['verified:' . config('fortify.guard')])
                    ->name('register.user');
            }

            Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware(['verified:' . config('fortify.guard')]);
        }
    });
});
