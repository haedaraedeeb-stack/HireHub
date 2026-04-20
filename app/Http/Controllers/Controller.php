<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function success($result, $message, $code = 200) {
        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => $message,
        ],$code);
    }

    protected function failed($errors = null, $message, $code = 400) {
        return response()->json([
            'success' => false,
            'errors' => $errors,
            'message' => $message,
        ],$code);
    }
}
