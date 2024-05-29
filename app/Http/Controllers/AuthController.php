<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login() {

    }

    public function register() {
        return view('front.account.register');
    }

    public function processRegister(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->passes()) {

            return response()->json([
                'status' => 'success',
                'message' => 'Registration successful'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()
            ]);
        }
    }
}
