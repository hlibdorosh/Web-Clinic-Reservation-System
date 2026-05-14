<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;

class ClinicInfoController extends Controller
{
    public function index()
    {
        $departments = Department::with('services')->get();
        $doctors = User::where('role', 'doctor')->get();

        return view('user.about', compact('departments', 'doctors'));
    }
}
