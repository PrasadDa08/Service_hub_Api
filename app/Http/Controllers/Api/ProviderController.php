<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function providerProfile(Request $request)
    {
        $request->validate([
            'experience' => 'string|required',
            'bio' => 'string|required',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric'
        ]);


        $user = auth('api')->user();
        $provider = Provider::where('user_id', '=',$user->id)->first();

        $provider->update([
            'experience' => $request->experience,
            'bio' => $request->bio,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);

        return response()->json([
            'status' => true,
            'data' => $provider->fresh()
        ]);
    }
}
