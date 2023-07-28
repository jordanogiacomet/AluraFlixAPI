<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{   


    public function register(Request $request){
       try {
        $credentials = $request->validate([
            'name' => ['required', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required'
        ]);

        $credentials['password'] = bcrypt($credentials['password']);
        $user = User::create($credentials);

        auth()->login($user);

        return response()->json([
            'message' => 'Success'
        ], 200);
       } catch (ValidationException $e){
        return response()->json([
            'errors' => $e->errors()
        ]);
       }
    }


    public function login(Request $request){
       try {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);


        if(auth()->attempt([
            'name' => $credentials['name'],
            'password' => $credentials['password']
        ])) {
            $request->session()->regenerate();
        
        
            return response()->json([
                'message' => 'Success'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Error'
            ], 404);
        }
       } catch (ValidationException $e){
            return response()->json([
                'errors' => $e->errors()
            ], 422);
       }
    }

    public function logout(){
        auth()->logout();
        return response()->json([
            'Message' => 'Success'
        ], 200);
    }



}
