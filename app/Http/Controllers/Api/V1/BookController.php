<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// model 
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('categories')->get();

        return response()->json([
            'Status' => 'successfully',
            'Data' => $books
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'copies' => 'required|integer|min:1',
            'category_ids' => 'array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $book = Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'],
            'copies' => $validated['copies'],
        ]);

        // attach category if provided
        $book->categories()->attach($validated['category_ids']);

        return response()->json([
            'status' => 'success',
            'Data' => $book->load('categories') // eager load categories
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Book specified by its id
        $book = Book::find($id);

        // Condition check 
        if (!$book) {
            return response()->json([
                'Status' => 'Error',
                'Message' => 'Book not found'
            ], 404);
        }

        // return data
        return response()->json([
            'Status' => 'Success',
            'Data' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the book or fail
        $book = Book::findOrFail($id);

        // Validate input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $id,
            'copies' => 'required|integer|min:1',
            'category_ids' => 'array|nullable',
            'category_ids.*' => 'exists:categories,id',
        ]);

        // Update book fields
        $book->update([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'],
            'copies' => $validated['copies'],
        ]);

        // Sync categories if provided
        if (!empty($validated['category_ids'])) {
            $book->categories()->sync($validated['category_ids']);
        }

        // Return response with updated book and categories
        return response()->json([
            'message' => 'Book updated successfully',
            'Data' => $book->load('categories'),
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find id specified
        $book = Book::find($id);

        // detach all related books to clean pivot table
        $book->categories()->detach();

        // delete 
        $book->delete();

        // return 
        return response()->json([
            'Message' => 'Book is deleted successfully'
        ], 200);
    }

    // public function getBooksWithCategory()
    // {
    //     $books = Book::with('categories')->get();

    //     return response()->json([
    //         'Status' => 'Success',
    //         'Data' => $books
    //     ], 200);
    // }

}
