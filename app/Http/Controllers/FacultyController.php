<?php

namespace App\Http\Controllers;

use App\Faculty; // Ensure this uses the correct namespace for your Faculty model
use Illuminate\Http\Request;

class FacultyController extends Controller
{
  public function index()
  {
    $faculties = Faculty::all();
    return view('faculties.index', compact('faculties'));
  }

  public function create(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required|max:255',
      'abbr' => 'nullable|max:50',
      'vision' => 'nullable|array',
      'vision.*' => 'nullable|string|max:255', // each item in the vision array should be a string
      'mission' => 'nullable|string',
      'description' => 'nullable|string',
    ]);

    $faculty = new Faculty();
    $faculty->name = $validatedData['name'];
    $faculty->abbr = $validatedData['abbr'];
    $faculty->vision = json_encode($validatedData['vision'] ?? []);
    $faculty->mission = $validatedData['mission'];
    $faculty->description = $validatedData['description'];
    $faculty->save();

    return redirect()->route('faculties.index')->with('success', 'Fakultas berhasil dibuat!');
  }

  public function edit(Request $request, Faculty $faculty)
  {
    if (!$faculty) {
      return back()->with('error', 'Fakultas tidak ditemukan!');
    }

    // Validation similar to the create method
    $validatedData = $request->validate([
      'name' => 'required|max:255',
      'abbr' => 'nullable|max:50',
      'vision' => 'nullable|array',
      'vision.*' => 'nullable|string|max:255',
      'mission' => 'nullable|string',
      'description' => 'nullable|string',
    ]);

    // Update the faculty with validated data
    $faculty->name = $validatedData['name'];
    $faculty->abbr = $validatedData['abbr'];
    $faculty->vision = json_encode($validatedData['vision'] ?? []);
    $faculty->mission = $validatedData['mission'];
    $faculty->description = $validatedData['description'];
    $faculty->save();

    return back()->with('success', 'Fakultas berhasil diperbarui!');
  }

  public function delete(Faculty $faculty)
  {
    $faculty->delete();
    return response()->json($faculty);
  }
}
