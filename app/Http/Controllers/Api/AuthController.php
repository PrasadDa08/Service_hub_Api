<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'role' => 'required|in:provider,user,admin',
            'password' => 'required|string|min:6|confirmed',
        ]);


        DB::beginTransaction();

    try{
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        if($request->role === 'provider'){
            Provider::create([
                'user_id' => $user->id
            ]);
        }
        $token = $user->createToken('authToken')->accessToken;

        DB::commit();

        return response()->json([
            'status' => true,
            'data' => new UserResource($user),
        ], 201)->cookie('access_token', $token, 300, '/', null, false, true);

    }catch(\Exception $e){
        DB::rollBack();
        return response()->json([
            'status' => false,
            'data' => $e->getMessage(),
        ], 404);
    }}

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();



        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'data' => new UserResource($user),
        ], 200)->cookie('access_token', $token, 300, '/', null, false, true);
    }

    public function logout(Request $request)
    {

        /** @var \App\Models\User $user */
        /** @var \Laravel\Passport\Token $token */

        $user = auth('api')->user();
        if ($user) {
         $user->token()->revoke();
        }

        return response()->json([
            'status' => true,
            'message' => 'User Logged Out Successfully'
        ], 200)->cookie('access_token', '', -1, '/');
    }
}
