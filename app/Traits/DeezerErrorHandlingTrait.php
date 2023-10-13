<?php

namespace App\Traits;

trait DeezerErrorHandlingTrait
{
    public $TYPE_ERRORS = array(
        "DataException" => 404
    );
    public function response($response){
        
        $hasError = isset($response->error);

        if( !$hasError )
            response()->json($response,200);
        else 
            response()->json(['message'=>$response->error->message],$this->TYPE_ERRORS[$response->error->type]);
       
    }
    
}