<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Cabinet;
use App\Models\Service;
use App\Models\User;

class ClinicInfoController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        $cabinets = Cabinet::with('department')->get();
        $services = Service::with('department')->get();
        $doctors = User::where('role', 'doctor')->get();

        return view('user.about', compact('departments', 'cabinets', 'services', 'doctors'));
    }
}

