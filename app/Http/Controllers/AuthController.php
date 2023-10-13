<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
 
/**
 * @OA\Info(
 *     title="DEEZER CLONE API",
 *     version="1.0",
 *     description="Descripción de la API de Ejemplo"
 * ) 
 **/
class AuthController extends Controller
{

    /** 
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Auth"},
     *     summary="Register a new user",
     *     @OA\RequestBody(
    *          required=true,
    *           @OA\JsonContent(
        *             @OA\Property(property="email", type="string", description="User's email"),
        *             @OA\Property(property="name", type="string", description="User's name"),
        *             @OA\Property(property="password", type="string", description="User's password"),
        *             @OA\Property(property="country", type="string", description="User's country")
        *         )
     *      ),
     *     @OA\Response(response="200", description="User registered successfully"),
     *     @OA\Response(response="500", description="Server error")
     * )
    */
    public function register(RegisterRequest $request){
         
        
        try { 
            $request['password'] = Hash::make($request->password);
            $user =  User::create($request->all());
            $token = $user->createToken('Bearer Token')->plainTextToken;
            return response()->json(["token"=>$token],200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json($th->getMessage(),500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="User login",
     *     @OA\RequestBody(
     *             required=true,
     *             @OA\JsonContent(
     *                  @OA\Property(property="email", type="string", format="email", description="User's email"),
     *                  @OA\Property(property="password", type="string", description="User's password")
     *               )     
     *   ),
     *     @OA\Response(response="200", description="User logged in successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="500", description="Server error")
     * )
      */
    public function login(LoginRequest $request){
        


        $user = User::where('email',$request->email)->first();
        if(!$user) 
            return response()->json(["error"=>"Invalid email"],401);
        $isUser = Hash::check($request->password,$user->password); 

        if(!$isUser)
            return response()->json(["error"=>"Invalid password"],401);
         
        $token = $user->createToken('Bearer Token')->plainTextToken;

        return response()->json(["user" => $user, "token" => $token],200);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Auth"},
     *     summary="User logout",
     *     @OA\Response(response="200", description="User logged out successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="500", description="Server error")
     * )
     */
    public function logout(Request $request){

        
        $user = $request->user();
        
        $hasDeleted = $user->tokens()->delete();

        if(!$hasDeleted)
            return response()->json(["mesage"=>"no authorized"],401);
            

        return response()->json(["mesage"=>"user logout successful"],200);
        
    }

}

