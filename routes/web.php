<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MangaController;

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

Route::get('/', function () {
    return view('welcome');
})->name('accueil');

Route::get('/listerMangas', [MangaController::class, 'listerMangas'])->name('mangas');

Route::get('/ajouterManga', "App\Http\Controllers\MangaController@ajouterManga")->name('ajoutManga');

Route::post('/validerManga', "App\Http\Controllers\MangaController@validerManga")->name('postManga');

Route::get('/modifierManga/{id}', [MangaController::class, 'modifierManga'])->name('majManga');

Route::get('/supprimerManga/{id}', "App\Http\Controllers\MangaController@supprimerManga")->name('supManga');

Route::get('/mangaParGenre', "App\Http\Controllers\MangaController@mangaParGenre")->name('selGenre');

Route::post('/validerGenre', "App\Http\Controllers\MangaController@validerGenre")->name('postGenre');
