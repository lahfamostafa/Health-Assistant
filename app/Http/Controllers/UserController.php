<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ResponseTrait;

    public function register(RegisterRequest $request){
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return $this->successResponse($user,'register reusit !');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function login(LoginRequest $request){
        $info = $request->only('email','password');
        if(Auth::attempt($info)){
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->successResponse(['user'=> $user, 'token'=> $token],'login avec success');
        }else
            return $this->errorResponse('données invalide');
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse([],"vous ete déconnecté");
    }

    public function user(){
        $user = User::where('id',Auth::id())->get();
        if($user) return $this->successResponse($user,'mon profile');
        else return $this->errorResponse('vous ete non connecté');
    }
}
