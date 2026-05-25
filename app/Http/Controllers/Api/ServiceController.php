<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Service;

class ServiceController extends Controller
{

public function index(){
    $services = Service::with('category')->get();

    return response()->json([
        'status' => true,
        'data' => $services,
    ],200);
}


    public function store(Request $request, Category $category){
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'base_price' => 'required|numeric',
        ]);


        $service = Service::create([
            'category_id' => $category->id,
            'name' => $request->name,
            'description' => $request->description,
            'base_price' => $request->base_price
        ]);

        return response()->json([
            'status' => true,
            'data' => $service
        ],201);
    }

    public function show(Service $service){
        return response()->json([
            'status' => true,
            'data' => $service->load('category')
        ],200);
    }

    public function showCategoryServices(Category $category){
        $services = $category->load('services');

        return response()->json([
            'status' => true,
            'data' => $services,
        ],200);
    }
}
