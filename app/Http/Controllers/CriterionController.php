<?php

namespace App\Http\Controllers;

use App\Criterion;
use Illuminate\Http\Request;
use App\DataTables\CriteriaDataTable;

class CriterionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(CriteriaDataTable $dataTable)
  {
    return $dataTable->render('criteria.index');
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
  public function getParentCriteria(Request $request)
  {
    $level = $request->input('level');

    // Fetch parent criteria based on level
    $parentCriteria = Criterion::where('level', $level)->get();

    // Format the data as needed
    $formattedCriteria = $parentCriteria->map(function ($criterion) {
      return [
        'id' => $criterion->id,
        'code' => $criterion->full_code,
        'name' => $criterion->name
      ];
    });

    return response()->json($formattedCriteria);
  }
}
