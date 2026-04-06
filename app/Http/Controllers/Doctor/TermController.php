<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Department;
use App\Models\Cabinet;
use App\Models\Term;
use App\Notifications\TermCreated;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;


class TermController extends Controller
{
    public function index()
    {
        $terms = Term::where('doc_id', auth()->id())
            ->with(['reservations.patient', 'reservations.service', 'cabinet', 'department'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time')
            ->get();

        return view('doctor.terms.index', compact('terms'));
    }

    public function calendar()
    {
        $terms = Term::where('doc_id', auth()->id())
            ->with(['reservations.patient', 'reservations.service', 'cabinet', 'department'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time')
            ->get();

        // Prepare calendar data
        $currentDate = Carbon::now();
        $calendarData = $this->generateCalendarData($terms, $currentDate);

        return view('doctor.terms.calendar', compact('terms', 'calendarData', 'currentDate'));
    }

    private function generateCalendarData($terms, $currentDate)
    {
        $year = $currentDate->year;
        $month = $currentDate->month;

        $firstDay = Carbon::create($year, $month, 1);
        $lastDay = $firstDay->copy()->endOfMonth();

        $calendarDays = [];
        $dayOfWeek = $firstDay->dayOfWeek; // 0 = Sunday, 6 = Saturday

        // Add empty cells for days before month starts
        for ($i = 0; $i < $dayOfWeek; $i++) {
            $calendarDays[] = null;
        }

        // Add days of the month
        for ($day = 1; $day <= $lastDay->day; $day++) {
            $date = Carbon::create($year, $month, $day);
            $dayTerms = $terms->filter(function ($term) use ($date) {
                $termDate = $term->date instanceof \DateTime ? $term->date : Carbon::parse($term->date);
                return $termDate->format('Y-m-d') === $date->format('Y-m-d');
            })->values();

            $calendarDays[] = [
                'date' => $date,
                'day' => $day,
                'terms' => $dayTerms,
                'hasTerms' => $dayTerms->count() > 0,
            ];
        }

        return [
            'days' => $calendarDays,
            'month' => $firstDay->format('F Y'),
            'monthNum' => $month,
            'year' => $year,
        ];
    }

    public function create()
    {
        // кабинет определяется по врачу? если нет — показываем все
        $cabinets = Cabinet::all();
        $departments = \App\Models\Department::all();

        return view('doctor.terms.create', compact('cabinets', 'departments'));
    }

    public function edit(Term $term)
    {
        $cabinets = Cabinet::all();
        $departments = Department::all();

        return view('doctor.terms.edit', compact('term', 'cabinets', 'departments'));
    }

    public function update(Request $request, Term $term)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'dep_id' => 'required|exists:departments,id',
            'cab_id' => 'required|exists:cabinets,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'desc' => 'nullable',
        ]);

        // Ensure time format is H:i with proper padding
        $start_time = $this->normalizeTimeFormat($request->start_time);
        $end_time = $this->normalizeTimeFormat($request->end_time);

        // Проверка конфликта термина, исключая сам себя
        $conflict = Term::where('id', '!=', $term->id)
            ->where('date', $request->date)
            ->where(function ($q) use ($term, $request) {
                $q->where('doc_id', $term->doc_id)
                    ->orWhere('cab_id', $request->cab_id);
            })
            ->where(function ($q) use ($start_time, $end_time) {
                $q->whereBetween('start_time', [$start_time, $end_time])
                    ->orWhereBetween('end_time', [$start_time, $end_time])
                    ->orWhere(function ($x) use ($start_time, $end_time) {
                        $x->where('start_time', '<=', $start_time)
                            ->where('end_time', '>=', $end_time);
                    });
            })
            ->first();

        if ($conflict) {
            return back()
                ->withErrors(['time' => 'This time slot is already occupied'])
                ->withInput();
        }

        $term->update([
            'date' => $request->date,
            'dep_id' => $request->dep_id,
            'cab_id' => $request->cab_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'desc' => $request->desc,
        ]);

        return redirect()->route('doctor.terms.index')->with('success', 'Term updated');
    }


    public function store(Request $request)
    {
        $request->validate([
            'cab_id' => 'required|exists:cabinets,id',
            'dep_id' => 'required|exists:departments,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'desc' => 'nullable',
        ]);

        $doctorId = auth()->id();

        // Ensure time format is H:i with proper padding
        $start_time = $this->normalizeTimeFormat($request->start_time);
        $end_time = $this->normalizeTimeFormat($request->end_time);

        // Проверяем конфликт времени: тот же врач или тот же кабинет
        $conflict = Term::where('date', $request->date)
            ->where(function ($q) use ($doctorId, $request) {
                $q->where('doc_id', $doctorId)
                    ->orWhere('cab_id', $request->cab_id);
            })
            ->where(function ($q) use ($start_time, $end_time) {
                $q->whereBetween('start_time', [$start_time, $end_time])
                    ->orWhereBetween('end_time', [$start_time, $end_time])
                    ->orWhere(function ($x) use ($start_time, $end_time) {
                        $x->where('start_time', '<=', $start_time)
                            ->where('end_time', '>=', $end_time);
                    });
            })
            ->first();


        if ($conflict) {
            return back()
                ->withErrors(['time' => 'This time slot is already occupied'])
                ->withInput();
        }

        // Создание слота
        $term = Term::create([
            'doc_id' => $doctorId,
            'dep_id' => $request->dep_id,   // ✔ теперь выбирает доктор
            'cab_id' => $request->cab_id,
            'date' => $request->date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'is_taken' => 0,
            'desc' => $request->desc,
        ]);


        $term->load(['department', 'cabinet']);
        auth()->user()->notify(new TermCreated($term));

        return redirect()->route('doctor.terms.index')
            ->with('success', 'Term created');

    }

    public function destroy(Term $term)
    {
        // Убедиться, что это термин текущего врача
        if ($term->doc_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Проверить, есть ли зарезервированные слоты
        if ($term->reservations()->count() > 0) {
            return back()
                ->withErrors(['delete' => 'Cannot delete a term with existing reservations']);
        }

        $term->delete();

        return redirect()->route('doctor.terms.index')
            ->with('success', 'Term deleted successfully');
    }

    /**
     * Normalize time format to ensure it's always HH:mm
     * Handles cases like "9:30" -> "09:30", "00:0" -> "00:00", and "15:00:00" -> "15:00"
     */
    private function normalizeTimeFormat($time)
    {
        if (empty($time)) {
            return '00:00';
        }

        // Remove seconds if present (HH:mm:ss -> HH:mm)
        $time = substr($time, 0, 5);

        // Split and pad
        $parts = explode(':', $time);
        if (count($parts) !== 2) {
            return '00:00';
        }

        $hours = str_pad($parts[0], 2, '0', STR_PAD_LEFT);
        $minutes = str_pad($parts[1], 2, '0', STR_PAD_LEFT);

        return $hours . ':' . $minutes;
    }
}


