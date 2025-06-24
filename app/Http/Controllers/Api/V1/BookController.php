<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Requests\StoreBookRequest;


// model 
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $book = Book::all();

        return response()->json([
            'Status' => 'successfully',
            'Data' => $book
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        // Find the book or fail

        // Validate input
        $validated = $request->validated();

        //Store book all
        $book = Book::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $book->load('categories') // eager load categories
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
    public function update(UpdateBookRequest $request, string $id)
    {
        // Find the book or fail
        $book = Book::findOrFail($id);

        // Validate input
        $validated = $request->validated();
        // Update book with validated data
        $book->update($validated);

        // Return response with updated book and categories
        return response()->json([
            'message' => 'Book updated successfully',
            'data' => $book->load('categories'),
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

    public function getBooksWithCategory()
    {
        $book = Book::with('categories')->get();
        return response()->json([
            'Status' => 'Success',
            'Data' => $book
        ], 200);
    }
}
