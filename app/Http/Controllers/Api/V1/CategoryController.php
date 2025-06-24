<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

// model
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('books')->get();
        return response()->json([
            'Status' => 'Success',
            'Data' => $categories
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
       
         $validated = $request->validated();
        
        $category = Category::create($validated);
        
        return response()->json([
            'status' => 'success',
            'Data' => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        $category = Category::create($category);

        // Condition check
        if (!$category) {
            return response()->json([
                'Status' => 'Error',
                'Message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'Status' => 'Success',
            'Category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        // Find id specified
        $category = Category::findOrFail($id);

        // validate input
        $validated = $request->validated();

        // update 
        $category->update([
            'name' => $validated['name'],
        ]);

        // sync books (remove old and attach new)
        if (isset($validated['books'])) {
            $category->books()->sync($validated['books']);
        }

        // return 
        return response()->json([
            'Message' => 'Category is updated successfully',
            'Data' => $category->load('books')
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // find category by its id
        $category = Category::find($id);

        // detach all related books to clean pivot table
        $category->books()->detach();

        // delete 
        $category->delete();

        // return 
        return response()->json([
            'Message' => 'Category is deleted successfully',
        ], 200);
    }

    /**
     * Show all related
     */
    // public function getCategoriesWithBooks()
    // {
    //     $categories = Category::with('books')->get();

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $categories
    //     ], 200);
    // }
}
