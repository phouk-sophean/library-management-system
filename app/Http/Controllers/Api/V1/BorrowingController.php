<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Borrowing;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $borrow = Borrowing::all();
        return response()->json($borrow, 200); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrowed_at' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrowed_at',
        ]);

        $borrowing = Borrowing::create($validated);

        return response()->json([
            'message' => 'Borrowing created successfully',
            'data' => $borrowing,
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
         public function getMemberWithBorrowings()
    {
        $borrows = Borrowing::with('')->get();

        return response()->json([
            'status' => 'success',
            'data' => $borrows
        ], 200);
    }
}
