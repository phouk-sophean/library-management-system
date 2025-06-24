<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBorrowRequest;
use App\Http\Requests\UpdateBorrowRequest;
use App\Models\Borrowing;

class BorrowingController extends Controller
{
    // List all borrowings with related book and member info
    public function index()
    {
        $borrowings = Borrowing::with(['book', 'member'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $borrowings,
        ]);
    }

    // Create a new borrowing record
    public function store(StoreBorrowRequest $request)
    {
        $validated = $request->validated();
        
        $borrowing = Borrowing::create($validated);

        return response()->json([
            'status' => 'success',
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
    public function update(UpdateBorrowRequest $request, $id)
    {
        // Find the borrowing or fail
        $borrowing = Borrowing::findOrFail($id);

        $validated = $request->validated();

        $borrowing->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Borrowing updated successfully',
            'data' => $borrowing->load(['book', 'member']),
        ]);
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
            'status' => 'success',
            'message' => 'Borrowing deleted successfully',
        ]);
    }
}
