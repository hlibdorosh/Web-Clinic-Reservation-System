<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cabinet;
use App\Models\Department;
use App\Models\User;
use App\Notifications\CabinetCreated;

class CabinetController extends Controller
{
    public function index(Request $request)
    {
        $query = Cabinet::with('department');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('number', 'like', '%' . $search . '%')
                  ->orWhere('desc', 'like', '%' . $search . '%');
        }

        // Department filter
        if ($request->filled('departments') && count($request->input('departments')) > 0) {
            $selectedDepartments = $request->input('departments');
            $query->whereIn('dep_id', $selectedDepartments);
        }

        $cabinets = $query->paginate(20);
        $departments = Department::all();

        return view('admin.cabinets.index', compact('cabinets', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.cabinets.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'desc' => 'nullable',
            'dep_id' => 'required|exists:departments,id',
        ]);

        $cabinet = Cabinet::create($request->only('number', 'desc', 'dep_id'));

        // Notify all admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new CabinetCreated($cabinet));
        }

        return redirect()->route('admin.cabinets.index');
    }

    public function edit(Cabinet $cabinet)
    {
        $departments = Department::all();
        return view('admin.cabinets.edit', compact('cabinet', 'departments'));
    }

    public function update(Request $request, Cabinet $cabinet)
    {
        $request->validate([
            'number' => 'required',
            'desc' => 'nullable',
            'dep_id' => 'required|exists:departments,id',
        ]);

        $cabinet->update($request->only('number', 'desc', 'dep_id'));

        return redirect()->route('admin.cabinets.index');
    }

    public function destroy(Cabinet $cabinet)
    {
        $cabinet->delete();
        return redirect()->route('admin.cabinets.index');
    }
}
