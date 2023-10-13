<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
 

class SearchController extends Controller
{
    private $base_url = "https://api.deezer.com/search";
 

    /**
     * @OA\Get(
     *     path="/api/search",
     *     tags={"Search"},
     *     summary="Search for albums or artists",
     *     @OA\Parameter(
     *         name="query",
     *         description="Search query",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Search results found"),
     *     @OA\Response(response="500", description="Server error")
     * )
     */
    public function search(Request $request){ 

    $res = Http::withToken(env('DEEZER_API_KEY'))->get($this->base_url,["q"=>$request['query']] );
    $res = json_decode($res);
    return response()->json($res,200);
    }
}
