<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

 
class ArtistController extends Controller
{
    private $base_url = "https://api.deezer.com/artist";
    
    /**
     * @OA\Get(
     *     path="/api/artist/{id}",
     *     tags={"Artist"},
     *     summary="Get artist by ID",
     *     @OA\Parameter(
     *         name="id",
     *         description="Artist ID",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Artist found"),
     *     @OA\Response(response="404", description="Artist not found"),
     *     @OA\Response(response="500", description="Server error")
     * )
     */

    function getArtistById(Request $request,$id){

        if(!isset($id))
            return response()->json('You have to send id of artist to continue',400);

        $res = Http::withToken(env('DEEZER_API_KEY'))->get("{$this->base_url}/{$id}");
        $res = json_decode($res);
        return response()->json($res,200);
    }
}
