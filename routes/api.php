<?php




use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; 


 
Route::post('/register',[AuthController::class,'register']) ; 


Route::post('/login', [AuthController::class,'login'])->name('login') ;


Route::group(['middleware'=>'auth:sanctum'],function(){
 
    Route::get('album/{id}', [AlbumController::class,'getAlbumById']);  
    Route::get('artist/{id}', [ArtistController::class,'getArtistById']); 
    Route::get('search',[ SearchController::class,'search']); 
    Route::post('/logout', [AuthController::class,'logout']) ;
});
 

