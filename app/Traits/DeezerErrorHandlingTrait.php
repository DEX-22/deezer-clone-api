<?php

namespace App\Traits;
 

trait DeezerErrorHandlingTrait
{
    public $DEZZER_API_ERRORS = array(
        "InvalidQueryException"=> 400,
        "OAuthException" => 401,
        "MissingParameterException"=> 403,
        "DataException" => 404,
        "Exception" =>500
    );
    public function response($response){

        $response = json_decode($response);

        if( isset($response->error)){

            $errorType = $response->error->type ;
            $hasError = $this->DEZZER_API_ERRORS[$errorType];
        }
        
        if( !isset($hasError) )
            return response()->json($response,200);
        else 
            return response()->json(['message'=>$response->error->message],$this->DEZZER_API_ERRORS[$response->error->type]);
        
       
    }
    
    
}