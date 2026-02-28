<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $query = User::query();

    if ($request->archived === 'true') {
        $query->onlyTrashed();
    } else {
        $query->latest();
    }

    $users = $query->paginate(10)->withQueryString();

    return view('user.index', compact('users'));
}

    public function edit(string $id)
{
    $user = User::findOrFail($id);

    return view('user.edit', compact('user'));
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'password' => ['nullable', 'min:6', 'confirmed'],
    ]);

    if (!empty($validated['password'])) {
        $user->update([
            'password' => $validated['password'], // hashed تلقائياً بسبب cast
        ]);
    }

    return redirect()
        ->route('users.index')
        ->with('success', 'Password updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $user = User::findOrFail($id);
      $user->delete();
      return redirect()->route('users.index')->with('success','User Archived Successfully');
        //
    }

        public function restore(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()
            ->route('users.index')
            ->with('success', 'user restored successfully');
    }
}
