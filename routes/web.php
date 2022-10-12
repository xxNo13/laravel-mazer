<?php

use App\Http\Livewire\IpcrStaffLivewire;
use App\Http\Livewire\IpcrFacultyLivewire;
use App\Http\Livewire\OpcrLivewire;
use App\Http\Livewire\TtmaLivewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Livewire\StandardStaffLivewire;
use App\Http\Livewire\StandardFacultyLivewire;
use App\Http\Livewire\ConfigureLivewire;
use App\Http\Livewire\OfficemateLivewire;
use App\Http\Livewire\ForapprovalLivewire;

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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/ipcr/staff', IpcrStaffLivewire::class)->name('ipcr.staff');
    Route::get('/ipcr/faculty', IpcrFacultyLivewire::class)->name('ipcr.faculty');
    Route::get('/opcr', OpcrLivewire::class)->name('opcr');
    Route::get('/standard/staff', StandardStaffLivewire::class)->name('standard.staff');
    Route::get('/standard/faculty', StandardFacultyLivewire::class)->name('standard.faculty');
    Route::get('/officemates', OfficemateLivewire::class)->name('officemates');
    Route::get('/for-approval', ForapprovalLivewire::class)->name('for-approval');
    Route::get('/ttma', TtmaLivewire::class)->name('ttma');
    Route::get('/configure', ConfigureLivewire::class)->name('configure');

    Route::get('/print/{print}', [PDFController::class, 'print'])->name('print');
    Route::get('/view', [PDFController::class, 'view'])->name('view');
});
