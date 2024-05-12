<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    public function index()
    {
        $title = 'Time Line';
        $timelines = Timeline::all();
        return view('app.timeline', compact('title', 'timelines'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'category' => 'required|in:creat,revision',
            'metode' => 'required|in:ppk,kpa',
            'year' => 'required|date_format:Y',
            'start' => 'required|date_format:Y-m-d\TH:i',
            'end' => 'required|date_format:Y-m-d\TH:i',
        ]);

        try {
            Timeline::create([
                'user_id' => Auth::user()->id,
                'category' => $validatedData['category'],
                'metode' => $validatedData['metode'],
                'year' => $validatedData['year'],
                'start' => $validatedData['start'],
                'end' => $validatedData['end'],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => true,  'message' => $e->getMessage()], 500);

            // return back()->with('error', $e->getMessage());
        }
        return response()->json(['error' => false,  'message' => 'Success'], 200);

        // return redirect()->back()->with('success', 'Berhasil menambahkan data Bendahara.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Timeline $timeline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timeline $timeline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function store_update(Request $request)
    {
        $validatedData = $this->validate($request, [
            'category' => 'required|in:creat,revision',
            'metode' => 'required|in:ppk,kpa',
            'year' => 'required|date_format:Y',
            'start' => 'required|date_format:Y-m-d\TH:i',
            'end' => 'required|date_format:Y-m-d\TH:i',
            'id' => 'required|integer',
        ]);
        try {
            $timeline = Timeline::find($validatedData['id']);
            $timeline->update($validatedData);
        } catch (\Exception $e) {
            return response()->json(['error' => true,  'message' => 'Anda tidak berhak melalukan aksi ini'], 500);
        }

        return redirect()->back()->with('success', 'Berhasil mengupdate data Bendahara.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timeline $timeline)
    {
        try {
            $timeline->delete();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Data bendahara berhasil dihapus.');
    }
}
