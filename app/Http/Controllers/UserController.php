<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Fakultas;
use Spatie\Permission\Models\Role;
use App\DataTables\UsersDataTable;

class UserController extends Controller
{
  public function index(UsersDataTable $dataTable)
  {
    $roles = Role::all()->pluck('name');
    return $dataTable->render('users.index', compact('roles'));
  }

  public function create(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users',
      'role' => 'nullable|in:admin,auditor,prodi',
      'password' => 'required|min:6',
    ]);

    $user = new User;
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->password = bcrypt($validatedData['password']);

    $user->save();

    if (!empty($validatedData['role'])) {
      $user->assignRole($validatedData['role']);
    }

    return redirect()->route('users.index')->with('success', 'Pengguna berhasil dibuat!');
  }


  public function edit(Request $request, User $user)
  {
    if (!$user) {
      session()->flash('error', 'Pengguna tidak ditemukan!');
      return back();
    }
    $validatedData = $request->validate([
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users,email,' . $user->id,
      'role' => 'nullable|in:admin,auditor,prodi',
      'password' => 'nullable|min:6',
    ]);

    if (!empty($validatedData['password'])) {
      $user->password = bcrypt($validatedData['password']);
    }
    if (!empty($validatedData['role'])) {
      $user->syncRoles($validatedData['role']);
    }
    $user->email = $validatedData['email'];
    $user->name = $validatedData['name'];
    $user->save();
    return back()->with('success', 'Berhasil perbarui pengguna!');
  }

  public function delete(Request $request, User $user)
  {
    $user->delete();

    // Return response
    return response()->json($user, 200);
  }
  public function datatables()
  {
    return DataTables::of(User::query())->make(true);
  }
}
