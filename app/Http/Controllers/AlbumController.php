<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Traits\DeezerErrorHandlingTrait;
use Illuminate\Support\Facades\Log;

class AlbumController extends Controller
{
    use DeezerErrorHandlingTrait;

    private $base_url = "https://api.deezer.com/album";
    
    
     /**
 * @OA\Get(
 *     path="/api/album/{id}",
 *     tags={"Album"},
 *     summary="Get album by ID",
 *     @OA\Parameter(
 *         name="id",
 *         description="Album ID",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response="200", description="Album found" ), 
 *     @OA\Response(response="400", description="You have to send a valid id of album to continue. this should to be a integer"),
 * *     @OA\Response(response="404", description="Album not found"),
 *     @OA\Response(response="500", description="Server error")
 * )
 */

    function getAlbumById(Request $request,$id){

        if(!$id)
            return response()->json('You have to send id of album to continue',400);
        
        if(!intval($id))
            return response()->json('You have to send a valid id of album to continue. this should to be a integer',400);
            

        try {
            $res = Http::withToken(env('DEEZER_API_KEY'))->get("{$this->base_url}/{$id}");
             
            return $this->response($res); 
         
        } catch (\Throwable $th) {
            return response()->json("Album not found",404);
            
        }
        
       
    }
}
