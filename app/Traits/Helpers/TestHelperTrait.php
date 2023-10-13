<?php

namespace App\Traits\Helpers;

use App\Models\User; 

trait TestHelperTrait{
    
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
