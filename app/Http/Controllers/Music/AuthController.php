<?php

namespace App\Http\Controllers\Music;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Admin;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Music\Register;

class AuthController extends Controller
{
    public function register(Register $request)
    {
        $input = $request->validated();
        $input['group'] = 'ADMIN';

        Admin::create($input);

        return response()->json([
            'status' => true,
            'message' => '註冊成功'
        ]);
    }

    public function login(Request $request)
    {
        $client = Client::where('password_client', true)->first();

        if (!$client) {
            response()->json([
                'status' => false,
                'message' => '伺服器錯誤，請洽管理員'
            ], 500);
        }

        $response = Http::post(url('/oauth/token'), [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ]);

        if (!$response->ok()) {
            return response()->json([
                'status' => false,
                'message' => $response->offsetGet('message')
            ], 400);
        }

        return $response->json();
    }

    public function refresh(Request $request)
    {
        $client = Client::where('password_client', true)->first();

        if (!$client) {
            response()->json([
                'status' => false,
                'message' => '伺服器錯誤，請洽管理員'
            ], 500);
        }

        $response = Http::post(url('/oauth/token'), [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->input('refresh_token'),
            'client_id' => $client->id,
            'client_secret' => $client->secret
        ]);

        if (!$response->ok()) {
            return response()->json([
                'status' => false,
                'message' => $response->offsetGet('message')
            ], 400);
        }

        return $response->json();
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();

            return response()->json([
                'status' => true,
                'message' => 'Success'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => '錯誤'
        ], 400);
    }

    public function me()
    {
        if (Auth::check()) {
            $admin = Auth::user();
            return response()->json([
                'status' => true,
                'data' => [
                    'name' => $admin->name,
                    'username' => $admin->username
                ]
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => '錯誤'
        ], 400);
    }
}
