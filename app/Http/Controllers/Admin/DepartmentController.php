<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department; // ← ЭТО НУЖНО

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::paginate(20);
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'nullable',
        ]);

        Department::create($request->only('name', 'desc'));

        return redirect()->route('admin.departments.index');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'nullable',
        ]);

        $department->update($request->only('name', 'desc'));

        return redirect()->route('admin.departments.index');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('admin.departments.index');
    }

}
