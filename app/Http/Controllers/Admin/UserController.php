<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Term;

class UserController extends Controller
{
    // LIST + FILTERS
    public function index(Request $request)
    {
        $query = User::query();

        // FILTER BY ROLE
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // SEARCH BY NAME OR EMAIL
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    // PROFILE PAGE
    public function show(User $user)
    {
        $terms = $user->terms()->with(['doctor', 'cabinet', 'department'])->get();


        return view('admin.users.show', compact('user', 'terms'));
    }

    // DELETE A TERM
    public function deleteTerm(Term $term)
    {
        $term->delete();

        return back()->with('success', 'Term deleted.');
    }

    public function destroy(User $user)
    {
        // Запрещаем удалять себя самого
        if (auth()->id() === $user->id) {
            return back()->withErrors(['error' => 'You cannot delete yourself.']);
        }
        if ($user->role === 'admin') {
            return back()->withErrors(['error' => 'Cannot delete other admins.']);
        }


        // Удаляем
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

}
