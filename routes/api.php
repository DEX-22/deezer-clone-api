<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Info(
 *     title="DEEZER CLONE API",
 *     version="1.0",
 *     description="Descripción de la API de Ejemplo"
 * )
 */

Route::middleware('auth:sanctum')->group(function(){

Route::get('album/{id}', [AlbumController::class,'getAlbumById']);
Route::get('artist/{id}', [ArtistController::class,'getArtistById']);
Route::get('search',[ SearchController::class,'search']);

});
 

