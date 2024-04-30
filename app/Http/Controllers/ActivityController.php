<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityNote;
use App\Models\Dipa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
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
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        //
    }

    public function checkNote(Activity $activity)
    {
        try {

            $dipa = Dipa::Accessibility(true, $activity->dipa_id, true)->first();
            $note = ActivityNote::where('activity_id', $activity->id)->where('user_id', Auth::user()->id)->first();
            // dd($note);
            return response()->json($note);
        } catch (\Exception $e) {
            Log::error('Error in store function: ' . $e->getMessage());

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function add_note(Activity $activity, Request $request)
    {
        try {
            // $validator = Validator::make($request->all(), [
            //     'catatan_description' => 'required|string',
            //     'activity_id' => 'required|integer',
            //     'catatan_id' => 'sometimes|integer',
            // ]);

            $validator = $request->validate([
                'catatan_description' => 'required|string',
                'activity_id' => 'required|numeric',
                'catatan_id' => 'nullable|numeric',
            ]);

            $activity = Activity::findOrFail($validator['activity_id']);

            $dipa = Dipa::Accessibility(true, $activity->dipa_id, true)->first();
            // dd($dipa);
            // if (empty($validator['catatan_id'])) {
            //     $note = ActivityNote::create([
            //         'description' => $validator['catatan_description'],
            //         'activity_id' => $validator['activity_id'],
            //         'user_id' => Auth::user()->id,
            //     ]);
            // } else {
            //     $note = ActivityNote::where('activity_id', $activity)->where('user_id', Auth::user()->id)->first();
            // }

            $note = ActivityNote::updateOrCreate(
                [
                    'activity_id' => $validator['activity_id'],
                    'user_id' => Auth::user()->id,
                ],
                [
                    'description' => $validator['catatan_description'],

                ]
            );
            return response()->json($note);
        } catch (\Exception $e) {
            Log::error('Error in store function: ' . $e->getMessage());

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
