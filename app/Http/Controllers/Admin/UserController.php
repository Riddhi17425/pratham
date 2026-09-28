<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * REFERENCE MODULE: baaki saare modules isi pattern par banenge
 * (list + search, create/edit, status toggle, soft delete, trash, restore, force delete).
 */
class UserController extends Controller
{
    public function index(Request $request)
    {
        $trashed = $request->boolean('trashed');

        $users = User::query()
            ->whereIn('role', [1, 2])
            ->when($trashed, fn ($q) => $q->onlyTrashed())
            ->when($request->q, fn ($q, $s) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%$s%")->orWhere('email', 'like', "%$s%")))
            ->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users', 'trashed'));
    }

    public function create()
    {
        return view('admin.users.create', ['user' => new User(['role' => User::ROLE_ADMIN, 'status' => true])]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', Rule::in([1, 2])],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
        $data['status'] = $request->boolean('status');

        User::create($data);

        return redirect()->route('users.index')->with('toast_success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in([1, 2])],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);
        $data['status'] = $request->boolean('status');

        if (empty($data['password'])) {
            unset($data['password']);
        }
        // You cannot change your own role or status
        if ($user->id === $request->user()->id) {
            unset($data['role'], $data['status']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('toast_success', 'User updated successfully.');
    }

    public function updateStatus(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('toast_error', 'You cannot change your own status.');
        }

        $user->update(['status' => ! $user->status]);

        return back()->with('toast_success', 'Status updated successfully.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('toast_error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('toast_success', 'User moved to trash successfully.');
    }

    public function restore($id)
    {
        User::onlyTrashed()->findOrFail($id)->restore();

        return back()->with('toast_success', 'User restored successfully.');
    }

    public function forceDelete($id)
    {
        User::onlyTrashed()->findOrFail($id)->forceDelete();

        return back()->with('toast_success', 'User permanently deleted.');
    }
}
