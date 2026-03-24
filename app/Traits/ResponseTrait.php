<?php 

    namespace App\Traits;
    trait ResponseTrait{
        public function successResponse($data =[],$message){
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => $message
            ]);
        }
        
        public function errorResponse($error){
            return response()->json([
                'success' => false,
                'message' => $error
            ]);
        }
    }

?>