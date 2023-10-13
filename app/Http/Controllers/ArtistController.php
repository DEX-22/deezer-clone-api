<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Traits\DeezerErrorHandlingTrait;
 
class ArtistController extends Controller
{
    use DeezerErrorHandlingTrait;

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
     *     @OA\Response(response="400", description="You have to send id of artist to continue"),
     *     @OA\Response(response="404", description="Artist not found"),
     *     @OA\Response(response="500", description="Server error")
     * )
     */

    function getArtistById(Request $request,$id){

        if(!isset($id))
            return response()->json('You have to send id of artist to continue',400);

       try {
        $res = Http::withToken(env('DEEZER_API_KEY'))->get("{$this->base_url}/{$id}");
        // 
        return $this->response($res);
       } catch (\Throwable $th) {
        // dd($th->getMessage());
        return response()->json($th->getMessage(),404);
       }
    }
}
