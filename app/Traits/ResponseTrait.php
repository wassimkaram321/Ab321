<?php

namespace App\Traits;

trait ResponseTrait
{
    public function error(){

        return response()->json([
            'data' => [],
            'message'=>"something went wrong"
        ]);
    }
    public function error_message($msg){

        return response()->json([
            'data' => [],
            'message'=>$msg
        ]);
    }

    public function success($data,$message = null){

        return response()->json([
            'data' => $data,
            'message'=>$message
        ]);
    }


}
