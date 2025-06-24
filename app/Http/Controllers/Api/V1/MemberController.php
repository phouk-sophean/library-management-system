<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    try {
        $members = Member::all();
        return response()->json([
            'status' => 'success',
            'data' => $members
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
       
        $validated = $request->validated();

        $member = Member::create($validated);

        return response()->json([
            'message' => 'Member created successfully',
            'data' => $member,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $member
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, string $id)
    {
        $member = Member::findOrFail($id);

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member not found'
            ], 404);
        }

       $validated = $request->validated();
       

        $member->update($validated);

        return response()->json([
            'message' => 'Member updated successfully',
            'data' => $member,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member not found'
            ], 404);
        }

        $member->delete();

        return response()->json([
            'message' => 'Member deleted successfully'
        ], 200);
    }

    public function getMemberWithBorrowings()
    {
        $members = Member::with('borrowings')->get();

        return response()->json([
            'status' => 'success',
            'data' => $members
        ], 200);
    }
 
}
