<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class AuthUserController extends Controller
{
    public function postLogin(LoginRequest $request) {

        try {
            $response = Http::asForm()->post(config('services.passport.login_endpoint'), [
                'grant_type' => 'password',
                'client_id' => config('services.passport.customer_client_id'),
                'client_secret' => config('services.passport.customer_client_secret'),
                'username' => $request->email ,
                'password' => $request->password ,
                'scope' => '*',
            ]);
            return $response->json();

        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'message' => [$e->getMessage()]
            ]);
        }
    }

    public function register(RegisterUserRequest $request) {
        return response()->json(null, 200);
    }
}
