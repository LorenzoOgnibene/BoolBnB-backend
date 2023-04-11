<?php

use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PropertyController as PropertyController;
use Illuminate\Support\Facades\Route;

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
//     return view('layouts.partials.home');
// })->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//TODO IN RF1 L'UTENTE NON DEVE AVERE LA POSSIBILITA' DI CANCELLARE I DATI INSERITI IN FASE DI REGISTRAZIONE


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group( function(){
    Route::get('/', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}/{redirect}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::get('/messages/{message}/{redirect}/displayed', [AdminMessageController::class, 'displayed'])->name('messages.displayed');
    Route::delete('/messages/{message}/{reditect}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');
    Route::get('/properties/{property}/sponsorshipsSelect', [PropertyController::class, 'sponsorshipsSelect'])->name('properties.sponsorshipsSelect');
    Route::post('/properties/{property}/sponsorshipsPay', [PropertyController::class, 'sponsorshipsPay'])->name('properties.sponsorshipsPay');
    Route::post('/properties/{property}/{sponsorship}/sponsorshipsConferm', [PropertyController::class, 'sponsorshipsConferm'])->name('properties.sponsorshipsConferm');
    Route::get('/properties/{property}/messages', [PropertyController::class, 'messages'])->name('properties.messages');
    Route::post('/properties/search', [PropertyController::class, 'search'])->name('properties.search');
    Route::get('/properties/trashed',  [PropertyController::class, 'trashed'] )->name('properties.trashed');
    Route::get('/properties/{property}/restore', [PropertyController::class, 'restore'])->name('properties.restore')->withTrashed();
    Route::delete('/properties/{property}/force-delete', [PropertyController::class, 'forceDelete'])->name('properties.force-delete')->withTrashed();
    Route::resource('/properties', PropertyController::class)->middleware('auth');
    // Route::resource('/messages', AdminMessageController::class)->middleware('auth');
});


require __DIR__.'/auth.php';
