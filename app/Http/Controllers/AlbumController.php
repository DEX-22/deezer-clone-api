<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Traits\DeezerErrorHandlingTrait;


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
 *     @OA\Response(response="200", description="Album found"),
 *     @OA\Response(response="404", description="Album not found"),
 *     @OA\Response(response="500", description="Server error")
 * )
 */

    function getAlbumById(Request $request,$id){

        if(!$id)
            return response()->json('You have to send id of album to continue',400);

        $res = Http::withToken(env('DEEZER_API_KEY'))->get("{$this->base_url}/{$id}");
        $res = json_decode($res,true); 
        // dd($res->get);
        $res = isset($res->title)? $res->title : $res->error;
        $status = isset($res->title)? 200 : 404;
 
        response()->json($res,$status);
        
       
    }
}
