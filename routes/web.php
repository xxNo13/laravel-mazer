<?php

use App\Http\Livewire\IpcrLivewire;
use App\Http\Livewire\OpcrLivewire;
use App\Http\Livewire\TtmaLivewire;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\StandardLivewire;
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

    Route::get('/ipcr', IpcrLivewire::class)->name('ipcr');
    Route::get('/opcr', OpcrLivewire::class)->name('opcr');
    Route::get('/standard', StandardLivewire::class)->name('standard');
    Route::get('/officemates', OfficemateLivewire::class)->name('officemates');
    Route::get('/for-approval', ForapprovalLivewire::class)->name('for-approval');
    Route::get('/ttma', TtmaLivewire::class)->name('ttma');
    Route::get('/configure', ConfigureLivewire::class)->name('configure');
});
