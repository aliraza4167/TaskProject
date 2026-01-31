<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Friendship $friendship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Friendship $friendship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Friendship $friendship)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Friendship $friendship)
    {
        //
    }

    public function sendRequest(User $user)
    {
        Friendship::firstOrCreate([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $user->id,
        ], [
            'status' => 'pending',
        ]);

        return redirect()->back()->with('status', 'Friend request sent!');
    }

    public function acceptRequest(Friendship $friendship)
    {
        if ($friendship->receiver_id !== auth()->user()->id) {
            abort(403);
        }

        $friendship->update([
            'status' => 'accepted',
        ]);

        return redirect()->back()->with('status', 'Friend request accepted!');
    }

    public function declineRequest(Friendship $friendship)
    {
        if ($friendship->receiver_id !== auth()->user()->id) {
            abort(403);
        }

        $friendship->update([
            'status' => 'declined',
        ]);

        return redirect()->back()->with('status', 'Friend request declined!');
    }
}
