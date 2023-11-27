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
    $levels = Criterion::getMinMaxLevels();
    return $dataTable->render('criteria.index', compact('levels'));
  }

  public function create(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required|max:255',
      'code' => 'required|max:150',
      'parent' => 'nullable|exists:criteria,id',
    ]);

    // Create a new Criterion instance
    $criterion = new Criterion([
      'name' => $validatedData['name'],
      'parent_id' => $validatedData['parent'] ?? null,
    ]);

    // Check if parent_id is set and valid
    if (!empty($validatedData['parent'])) {
      $parent = Criterion::find($validatedData['parent']);
      if ($parent) {
        // Concatenate parent code with the new code
        $criterion->code = $parent->code . '.' . $validatedData['code'];
      }
    } else {
      // If no parent, use the provided code and set level to 1
      $criterion->code = $validatedData['code'];
    }

    $criterion->save();

    return redirect()->route('criteria.index')->with('success', 'Kriteria baru berhasil dibuat!');
  }

  public function edit(Request $request, Criterion $criterion)
  {
    $validatedData = $request->validate([
      // Validation rules for editing a criterion
    ]);

    $criterion->update($validatedData);

    return back()->with('success', 'Kriteria berhasil diperbarui!');
  }

  public function delete(Criterion $criterion)
  {
    $criterion->delete();
    return response()->json($criterion);
  }
  public function getParentCriteria(Request $request)
  {
    $maxLevel = Criterion::getMinMaxLevels()['max_level'] ?? 1;

    $validatedData = $request->validate([
      'level' => 'required|integer|min:1|max:' . $maxLevel
    ]);

    $level = $validatedData['level'];

    // Fetch parent criteria based on level
    $parentCriteria = Criterion::where('level', $level)->get();

    return response()->json($parentCriteria);
  }
}
