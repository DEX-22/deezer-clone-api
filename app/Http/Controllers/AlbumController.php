<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AlbumController extends Controller
{
    private $base_url = "https://api.deezer.com/album";
    function getAlbumById(Request $request,$id){

        if(!isset($id))
            return response()->json('You have to send id of album to continue',400);

        $res = Http::withToken(env('DEEZER_API_KEY'))->get("{$this->base_url}/{$id}");
        $res = json_decode($res);
        return response()->json($res,200);
    }
}
