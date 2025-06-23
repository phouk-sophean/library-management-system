<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// model
use App\Models\Category;
use App\Models\Book;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('books')->get();
        return response()->json($categories, 200);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories',
            'books' => 'array|exists:books,id|nullable',
        ]);

        $category = Category::create([
            'name' => $validated['name'],
        ]);

        if (!empty($validated['books'])) {
            $category->books()->attach($validated['books']);
        }

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category->load('books'),
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
