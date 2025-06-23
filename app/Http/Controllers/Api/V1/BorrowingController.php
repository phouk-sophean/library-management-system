<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Borrowing;

class BorrowingController extends Controller
{
    // List all borrowings with related book and member info
    public function index()
    {
        $borrowings = Borrowing::with(['book', 'member'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $borrowings
        ]);
    }

    // Create a new borrowing record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        $borrowing = Borrowing::create($validated);

        return response()->json([
            'message' => 'Borrowing created successfully',
            'data' => $borrowing->load(['book', 'member']),
        ], 201);
    }

    // Show a specific borrowing record
    public function show($id)
    {
        $borrowing = Borrowing::with(['book', 'member'])->find($id);

        if (!$borrowing) {
            return response()->json([
                'status' => 'error',
                'message' => 'Borrowing not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $borrowing,
        ]);
    }

    // Update a borrowing record
    public function update(Request $request, $id)
    {
        $borrowing = Borrowing::findOrFail($id);

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        $borrowing->update($validated);

        return response()->json([
            'message' => 'Borrowing updated successfully',
            'data' => $borrowing->load(['book', 'member']),
        ], 200);
    }


    // Delete a borrowing record
    public function destroy($id)
    {
        $borrowing = Borrowing::find($id);

        if (!$borrowing) {
            return response()->json([
                'status' => 'error',
                'message' => 'Borrowing not found',
            ], 404);
        }

        $borrowing->delete();

        return response()->json([
            'message' => 'Borrowing deleted successfully',
        ]);
    }
}
