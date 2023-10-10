<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    private $base_url = "https://api.deezer.com/search";
 
    public function search(Request $request){ 

    $res = Http::withToken(env('DEEZER_API_KEY'))->get($this->base_url,["q"=>$request['query']] );
    $res = json_decode($res);
    return response()->json($res,200);
    }
}
