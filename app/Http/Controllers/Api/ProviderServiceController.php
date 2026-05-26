<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProviderService;
use App\Models\Provider;
use App\Models\Service;
use Illuminate\Http\Request;

class ProviderServiceController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'service_id' => 'required|numeric',
            'custom_price' => 'numeric',
        ]);

        $user = auth('api')->user();

        $provider = Provider::where('user_id', '=', $user->id)->first();

        $providerServices = $provider->services()->attach($request->service_id, ['custom_price' => $request->custom_price]);


        return response()->json([
            'status' => true,
            'data' => $provider->load('services'),
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'custom_price' => 'numeric',
        ]);

        $user = auth('api')->user();

        $provider = Provider::Where('user_id', '=', $user->id)->first();

        $provider->services()->updateExistingPivot($service->id, ['custom_price' => $request->custom_price]);

        return response()->json([
            'status' => true,
            'message' => 'Service Price updated successfully',
        ]);
    }
}
