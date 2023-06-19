<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiBaseController extends Controller
{
    //
    public function successResponse($data, $message){

        $result = [
            'status' => true,
            'code' => 200,
            'data' => $data,
            'message' => $message
        ];

        return response()->json($result, 200);
    }

    public function errorResponse($errorMessage = 'Error', $message, $code = 500){

        $result = [
            'status' => false,
            'code' => $code,
            'data' => $errorMessage,
            'message' => $message
        ];

        return response()->json($result, $code);
    }
}
