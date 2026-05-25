<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();

        return response()->json([
            'status' => true,
            'data' => $categories,
        ],200);
    }


    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'icon' => 'string|nullable'
        ]);

        $category = Category::create([
            'name' => $request->name,
            'icon' => $request->icon ?? null
        ]);

        return response()->json([
            'status' => true,
            'data' => $category
        ],201);
    }


    public function show(Category $category){
        return response()->json([
            'status' => true,
            'data' => $category,
        ],200);
    }
}
