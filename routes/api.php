<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieSearchController;

Route::get('/movies/search', [MovieSearchController::class, 'search'])->name('movies.search');