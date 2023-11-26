<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Fakultas;
use App\StudyProgram;
use Spatie\Permission\Models\Role;
use App\DataTables\UsersDataTable;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public function index(UsersDataTable $dataTable)
  {
    $roles = Role::pluck('name');
    $studyPrograms = StudyProgram::select('id', 'name', 'code')->get();
    return $dataTable->render('users.index', compact('roles', 'studyPrograms'));
  }

  public function create(Request $request)
  {
    $validatedData = $this->validateUser($request);
    $user = new User([
      'name' => $validatedData['name'],
      'email' => $validatedData['email'],
    ]);
    if (isset($validatedData['password'])) {
      $user->password = Hash::make($validatedData['password']);
    }
    $user->save();

    $this->handleUserRolesAndStudyProgram($user, $validatedData);

    return redirect()->route('users.index')->with('success', 'Pengguna berhasil dibuat!');
  }

  public function edit(Request $request, User $user)
  {
    $validatedData = $this->validateUser($request, $user);

    $user->fill($validatedData);
    if (!empty($validatedData['password'])) {
      $user->password = Hash::make($validatedData['password']);
    }
    $user->save();

    $this->handleUserRolesAndStudyProgram($user, $validatedData);

    return back()->with('success', 'Berhasil perbarui pengguna!');
  }

  public function delete(User $user)
  {
    $user->delete();
    return response()->json($user, 200);
  }

  private function validateUser(Request $request, User $user = null)
  {
    return $request->validate([
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users,email,' . ($user->id ?? ''),
      'roles' => 'nullable|in:admin,auditor,prodi',
      'password' => $user ? 'nullable|min:6' : 'required|min:6',
      'study_program' => 'nullable|exists:study_programs,id',
    ]);
  }

  private function handleUserRolesAndStudyProgram(User $user, array $data)
  {
    if (!empty($data['roles'])) {
      $user->syncRoles($data['roles']);
    }
    if (!empty($data['study_program'])) {
      $user->studyProgram()->associate(StudyProgram::find($data['study_program']));
    }
    $user->save();
  }
}
