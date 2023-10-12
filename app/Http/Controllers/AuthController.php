<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request){
         
        
        try { 
        $user =  User::create($request->all());
        $token = $user->createToken('Bearer Token')->plainTextToken;
        return response()->json(["token"=>$token],200);
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return response()->json($th->getMessage(),500);
        }
    }
    public function login(LoginRequest $request){
        
        $user = User::where('email',$request->email);
        if(!$user->first()) 
            return response()->json(["error"=>"Invalid email"],401);
        
        $user = $user->where('password',$request->password)->first();

        if(!$user)
            return response()->json(["error"=>"Invalid password"],401);
         
        $token = $user->createToken('Bearer Token')->plainTextToken;

        return response()->json(["user" => $user, "token" => $token],200);
    }
    public function logout(){

        
        auth()->user()->tokens()->delete();

        return response()->json(["mesage"=>"user logout successful"]);
        
    }

}

