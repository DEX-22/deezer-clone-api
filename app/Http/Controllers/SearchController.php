<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;
use App\Traits\DeezerErrorHandlingTrait;

class SearchController extends Controller
{
    use DeezerErrorHandlingTrait;


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
     *     @OA\Response(response="400", description="Query is required"),
     *     @OA\Response(response="500", description="Failed to retrieve search results")
     * )
     */
    public function search(Request $request){ 

        $query = $request['query'];
        if (empty($query)) 
            return response()->json(['error' => 'Query is required'], 400);

        try{
        $res = Http::withToken(env('DEEZER_API_KEY'))->get($this->base_url,["q"=>$query] );
                    
        return $this->response($res);

        }catch(Throwable $th){
            return response()->json(['error' => 'Failed to retrieve search results'], 500);
        }
    }
}
