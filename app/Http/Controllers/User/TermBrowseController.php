<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Term;
use Illuminate\Http\Request;

class TermBrowseController extends Controller
{
    public function index(Request $request)
    {
        $query = Term::query()
            ->where('is_taken', 0)
            ->with(['doctor', 'cabinet', 'department'])
            ->orderBy('date')
            ->orderBy('start_time');

        // фильтр по дате
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        } else {
            // по умолчанию показываем от сегодня и дальше
            $query->whereDate('date', '>=', now()->toDateString());
        }

        // фильтр по департаменту
        if ($request->filled('dep_id')) {
            $query->where('dep_id', $request->dep_id);
        }

        // фильтр по доктору (по имени)
        if ($request->filled('doctor')) {
            $doctor = $request->doctor;
            $query->whereHas('doctor', function ($q) use ($doctor) {
                $q->where('name', 'like', "%{$doctor}%");
            });
        }

        $terms = $query->paginate(20)->withQueryString();
        $departments = Department::orderBy('name')->get();

        return view('user.terms.index', compact('terms', 'departments'));
    }
}

