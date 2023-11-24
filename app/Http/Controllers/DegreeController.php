<?php

namespace App\Http\Controllers;

use App\Degree;
use Illuminate\Http\Request;
use App\DataTables\DegreesDataTable;

class DegreeController extends Controller
{
  public function index(DegreesDataTable $dataTable)
  {
    return $dataTable->render('degrees.index');
  }

  public function create(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required|max:255',
      'code' => 'required|max:50|unique:degrees', // Assuming 'code' is a required field
    ]);

    $degree = new Degree;
    $degree->name = $validatedData['name'];
    $degree->code = $validatedData['code'];
    $degree->save();

    return redirect()->route('degrees.index')->with('success', 'Degree berhasil dibuat!');
  }

  public function edit(Request $request, Degree $degree)
  {
    if (!$degree) {
      return back()->with('error', 'Degree tidak ditemukan!');
    }

    $validatedData = $request->validate([
      'name' => 'required|max:255',
      'code' => 'required|max:50|unique:degrees,code,' . $degree->id,
    ]);

    $degree->name = $validatedData['name'];
    $degree->code = $validatedData['code'];
    $degree->save();

    return back()->with('success', 'Degree berhasil diperbarui!');
  }

  public function delete(Degree $degree)
  {
    $degree->delete();
    return response()->json($degree);
  }
}
