<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SystemController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Home');
})->name('home');

Route::get('/systems/{page?}', function ($page = null) {
    return Inertia::render('Systems/Index', [ 'page' => $page ]);    
})->whereNumber('page')->name('systems.index');

Route::get('/systems/{name?}', function ($name) {
    return Inertia::render('Systems/Show', [ 'name' => $name ]);    
})->name('systems.show');

Route::get('/stations', function () {
    return Inertia::render('Home');
})->name('stations');

Route::get('/shipyard', function () {
    return Inertia::render('Home');
})->name('shipyard');

Route::get('/outfitting', function () {
    return Inertia::render('Home');
})->name('outfitting');

Route::get('/galaxy', function () {
    return Inertia::render('Home');
})->name('galaxy');

Route::group(['prefix' => 'market'], function () {
    Route::get('/', function () {
        return Inertia::render('Home');
    })->name('market');

    Route::get('/commodities', function () {
        return Inertia::render('Home');
    })->name('market.commodities');

    Route::get('/rare', function () {
        return Inertia::render('Home');
    })->name('market.rare-commodities');

    Route::get('/traderoutes', function () {
        return Inertia::render('Home');
    })->name('market.traderoutes');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
