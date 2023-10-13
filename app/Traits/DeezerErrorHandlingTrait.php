<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Log;

trait DeezerErrorHandlingTrait
{
    public $DEZZER_API_ERRORS = array(
        "InvalidQueryException"=> 400,
        "OAuthException" => 401,
        "MissingParameterException"=> 403,
        "DataException" => 404,
        "Exception" =>500,
        "NONE" => 0
    );
    public function response($response){

        $response = json_decode($response);

        if( isset($response->error)){

            $errorType = $response->error->type ;
            $hasError = $this->DEZZER_API_ERRORS[$errorType] != -1;
        }
        
        if( !isset($hasError) )
            return response()->json($response,200);
        else 
            return response()->json(['message'=>$response->error->message],$this->DEZZER_API_ERRORS[$response->error->type]);
        
       
    }
    public function getUser(){
        $user = User::factory()->create()->first(); 

        $token = $user->createToken('Bearer Token')->plainTextToken;
         

        return [ $user, $token];
    }
    public function withTokenHeader($token)
    {
        return $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ]);
    }
    
}