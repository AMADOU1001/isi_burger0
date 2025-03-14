<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BurgerController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsClient;
use App\Http\Middleware\IsManager;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Mail\OrderValidatedMail;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



// Route pour le tableau de bord
Route::get('/home', [HomeController::class, 'index'])->name('home');


// Routes pour les burgers
Route::middleware(IsManager::class)->group(function () {
    Route::get('/burgers', [BurgerController::class, 'index'])->name('burgers.index');
    Route::post('/burgers/{burger}/toggle-publish', [BurgerController::class, 'togglePublish'])->name('burgers.togglePublish');
    Route::get('/burgers/create', [BurgerController::class, 'create'])->name('burgers.create');
    Route::post('/burgers/store', [BurgerController::class, 'store'])->name('burgers.store');
    Route::get('/burgers/edit', [BurgerController::class, 'edit'])->name('burgers.edit');
    Route::post('/burgers/update', [BurgerController::class, 'update'])->name('burgers.update');
    Route::post('/burgers/destroy', [BurgerController::class, 'destroy'])->name('burgers.destroy');
    Route::post('/orders/{order}/validate', [OrderController::class, 'validateOrder'])->name('orders.validate');
    Route::get('/gestionnaire/home', [HomeController::class, 'index'])->name('gestionnaire.home');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');
});


// Routes pour les commandes
Route::middleware(IsClient::class)->group(function () {
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::post('/orders/{order}/validate', [OrderController::class, 'validateOrder'])->name('orders.validate');
});


// Routes pour les paiements
Route::get('/orders/{order}/payment', [OrderController::class, 'payment'])->name('orders.payment');
Route::post('/orders/{order}/payment', [OrderController::class, 'processPayment'])->name('orders.processPayment');

// Routes pour les publications
Route::post('/burgers/{burger}/toggle-publish', [BurgerController::class, 'togglePublish'])->name('burgers.togglePublish');


Route::middleware('auth')->group(function () {
    Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::delete('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});


Route::get('/test-pdf', [TestController::class, 'testPdf']);
