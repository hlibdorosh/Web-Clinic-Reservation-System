<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Department;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('department')->paginate(20);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.services.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'desc' => 'nullable',
            'dep_id' => 'nullable|exists:departments,id',
        ]);

        Service::create($request->only('name', 'price', 'desc', 'dep_id'));

        return redirect()->route('admin.services.index');
    }

    public function edit(Service $service)
    {
        $departments = Department::all();
        return view('admin.services.edit', compact('service', 'departments'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'desc' => 'nullable',
            'dep_id' => 'nullable|exists:departments,id',
        ]);

        $service->update($request->only('name', 'price', 'desc', 'dep_id'));

        return redirect()->route('admin.services.index');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index');
    }
}
