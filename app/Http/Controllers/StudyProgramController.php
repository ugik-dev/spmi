<?php

namespace App\Http\Controllers;

use App\StudyProgram;
use App\Degree;
use App\Faculty;
use Illuminate\Http\Request;
use App\Datatables\StudyProgramsDataTable;

class StudyProgramController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(StudyProgramsDataTable $dataTable)
  {
    $degrees = Degree::select('id', 'name')->get();
    $faculties = Faculty::select('id', 'name')->get();
    return $dataTable->render('study_programs.index', compact('degrees', 'faculties'));
  }

  public function create(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required|max:255',
      'code' => 'nullable|max:50',
      'degree' => 'nullable|exists:degrees,id',
      'faculty' => 'nullable|exists:faculties,id',
      'vision' => 'nullable|array',
      'vision.*' => 'nullable|string|max:255',
      'mission' => 'nullable|string',
      'description' => 'nullable|string',
    ]);

    $studyProgram = new StudyProgram();
    $studyProgram->fill($validatedData);
    $studyProgram->save();

    if (!empty($validatedData['faculty'])) {
      $studyProgram->faculty()->associate(Faculty::find($validatedData['faculty']));
      $studyProgram->save();
    }

    if (!empty($validatedData['degree'])) {
      $studyProgram->degree()->associate(Degree::find($validatedData['degree']));
      $studyProgram->save();
    }


    return redirect()->route('programs.index')->with('success', 'Program studi berhasil dibuat!');
  }

  public function edit(Request $request, StudyProgram $studyProgram)
  {
    if (!$studyProgram) {
      return back()->with('error', 'Program studi tidak ditemukan!');
    }

    // Validation similar to the create method
    $validatedData = $request->validate([
      'name' => 'required|max:255',
      'code' => 'nullable|max:50',
      'degree' => 'nullable|exists:degrees,id',
      'faculty' => 'nullable|exists:faculties,id',
      'vision' => 'nullable|array',
      'vision.*' => 'nullable|string|max:255',
      'mission' => 'nullable|string',
      'description' => 'nullable|string',
    ]);

    $studyProgram->fill($validatedData);
    if (!empty($validatedData['degree'])) {
      $studyProgram->degree()->associate(Degree::find($validatedData['degree']));
    } else {
      $studyProgram->degree()->dissociate();
    }
    if (!empty($validatedData['faculty'])) {
      $studyProgram->faculty()->associate(Faculty::find($validatedData['faculty']));
    } else {
      $studyProgram->faculty()->dissociate();
    }

    $studyProgram->save();


    return back()->with('success', 'Program studi berhasil diperbarui!');
  }

  public function delete(StudyProgram $studyProgram)
  {
    $studyProgram->delete();
    return response()->json($studyProgram);
  }
}
