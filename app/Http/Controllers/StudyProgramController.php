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
    $validatedData = $this->validateStudyProgram($request);

    $studyProgram = new StudyProgram($validatedData);
    $this->associateEntities($studyProgram, $validatedData);
    $studyProgram->save();

    return redirect()->route('programs.index')->with('success', 'Program studi berhasil dibuat!');
  }

  public function edit(Request $request, StudyProgram $studyProgram)
  {
    $validatedData = $this->validateStudyProgram($request);

    $studyProgram->fill($validatedData);
    $this->associateEntities($studyProgram, $validatedData);
    $studyProgram->save();

    return back()->with('success', 'Program studi berhasil diperbarui!');
  }

  public function delete(StudyProgram $studyProgram)
  {
    $studyProgram->delete();
    return response()->json($studyProgram);
  }

  private function validateStudyProgram(Request $request)
  {
    return $request->validate([
      'name' => 'required|max:255',
      'code' => 'nullable|max:50',
      'degree' => 'nullable|exists:degrees,id',
      'faculty' => 'nullable|exists:faculties,id',
      'vision' => 'nullable|array',
      'vision.*' => 'nullable|string|max:255',
      'mission' => 'nullable|string',
      'description' => 'nullable|string',
    ]);
  }

  private function associateEntities(StudyProgram $studyProgram, array $data)
  {
    if (!empty($data['faculty'])) {
      $studyProgram->faculty()->associate(Faculty::find($data['faculty']));
    } else {
      $studyProgram->faculty()->dissociate();
    }

    if (!empty($data['degree'])) {
      $studyProgram->degree()->associate(Degree::find($data['degree']));
    } else {
      $studyProgram->degree()->dissociate();
    }
  }
}
