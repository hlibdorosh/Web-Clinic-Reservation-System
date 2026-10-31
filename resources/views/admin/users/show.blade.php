<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <h1 class="page-title mb-6">User profile</h1>

        {{-- PERSONAL INFO --}}
        <div class="card p-6 mb-8 max-w-xl">
            <h2 class="text-lg font-medium text-ink-900 mb-3">Personal information</h2>
            <div class="space-y-1 text-sm">
                <p><span class="text-ink-500">Name</span> <span class="text-ink-900">{{ $user->name }}</span></p>
                <p><span class="text-ink-500">Email</span> <span class="text-ink-900">{{ $user->email }}</span></p>
                <p><span class="text-ink-500">Role</span> <span class="text-ink-900">{{ ucfirst($user->role) }}</span></p>
            </div>

            {{-- ROLE CHANGE CHECKBOX --}}
            @if($user->role === 'patient')
                @php
                    $hasReservations = $user->reservations()->exists();
                    $canChangeRole = !$hasReservations;
                @endphp

                <div class="mt-4 p-4 border border-line rounded-lg bg-ink-50">
                    <form id="promoteForm" method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="inline">
                        @csrf
                        @method('PATCH')

                        <label class="flex items-center gap-2 text-sm cursor-pointer {{ $canChangeRole ? '' : 'opacity-50 cursor-not-allowed' }}">
                            <input type="checkbox"
                                   id="promoteCheckbox"
                                   name="promote_to_doctor"
                                   value="1"
                                   onchange="showPromoteModal()"
                                   {{ $canChangeRole ? '' : 'disabled' }}
                                   class="form-checkbox">
                            <span class="font-medium text-ink-900">
                                Promote to doctor
                            </span>
                        </label>
                        @if(!$canChangeRole)
                            <p class="text-sm text-red-600 mt-2">
                                Cannot promote user with active reservations
                            </p>
                        @endif
                    </form>
                </div>

                <!-- Confirmation modal -->
                <div id="promoteModal" class="fixed inset-0 bg-ink-900/40 hidden flex items-center justify-center z-50">
                    <div class="bg-white rounded-xl border border-line p-6 max-w-sm mx-auto">
                        <h3 class="text-lg font-medium text-ink-900 mb-2">Confirm promotion</h3>
                        <p class="text-sm text-ink-600 mb-3">
                            Are you sure you want to promote <strong class="font-medium">{{ $user->name }}</strong> to Doctor?
                        </p>
                        <p class="text-sm text-ink-500 mb-6">
                            This action will give them access to create terms and manage appointments.
                        </p>

                        <div class="flex gap-3 justify-end">
                            <button type="button"
                                    onclick="cancelPromote()"
                                    class="btn-outline">
                                Cancel
                            </button>
                            <button type="button"
                                    onclick="confirmPromote()"
                                    class="btn">
                                Promote
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    function showPromoteModal() {
                        document.getElementById('promoteModal').classList.remove('hidden');
                    }

                    function cancelPromote() {
                        document.getElementById('promoteCheckbox').checked = false;
                        document.getElementById('promoteModal').classList.add('hidden');
                    }

                    function confirmPromote() {
                        document.getElementById('promoteModal').classList.add('hidden');
                        document.getElementById('promoteForm').submit();
                    }
                </script>
            @elseif($user->role === 'doctor')
                <div class="mt-4 p-4 border border-line rounded-lg bg-ink-50">
                    <label class="flex items-center gap-2 text-sm opacity-50 cursor-not-allowed">
                        <input type="checkbox"
                               checked
                               disabled
                               class="form-checkbox">
                        <span class="font-medium text-ink-900">
                            Doctor role
                        </span>
                    </label>
                </div>
            @endif
        </div>

        {{-- TERMS (FOR DOCTORS) --}}
        @if($user->role === 'doctor')
            <h2 class="text-lg font-medium text-ink-900 mb-3">Terms</h2>

            @if($terms->isEmpty())
                <p class="text-sm text-ink-500">No terms</p>
            @else
                <div class="card overflow-hidden">
                    <table class="table w-full">
                        <thead>
                        <tr>
                            <th class="text-left">Date</th>
                            <th class="text-left">Service</th>
                            <th class="text-left">Cabinet</th>
                            <th class="text-left">Department</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($terms as $term)
                            <tr>
                                <td class="text-ink-900 tabular-nums">{{ $term->date }}</td>
                                <td class="text-ink-600">{{ $term->service?->name }}</td>
                                <td class="text-ink-600 tabular-nums">{{ $term->cabinet?->number }}</td>
                                <td class="text-ink-600">{{ $term->department?->name }}</td>

                                <td class="text-right">
                                    <form method="POST"
                                          action="{{ route('admin.users.term.delete', $term) }}"
                                          onsubmit="return confirm('Delete this term?');">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn-outline btn-sm text-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        {{-- RESERVATIONS (FOR PATIENTS) --}}
        @else
            <h2 class="text-lg font-medium text-ink-900 mb-3">Reservations</h2>

            @if($reservations->isEmpty())
                <p class="text-sm text-ink-500">No reservations</p>
            @else
                <div class="card overflow-hidden">
                    <table class="table w-full">
                        <thead>
                        <tr>
                            <th class="text-left">Date</th>
                            <th class="text-left">Service</th>
                            <th class="text-left">Doctor</th>
                            <th class="text-left">Cabinet</th>
                            <th class="text-left">Status</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($reservations as $reservation)
                            @php
                                $dot = match($reservation->state) {
                                    'confirmed' => 'bg-emerald-600',
                                    'cancelled', 'canceled' => 'bg-red-600',
                                    'pending' => 'bg-amber-600',
                                    default => 'bg-ink-400',
                                };
                            @endphp
                            <tr>
                                <td class="text-ink-900 tabular-nums">{{ $reservation->term?->date }}</td>
                                <td class="text-ink-600">{{ $reservation->service?->name }}</td>
                                <td class="text-ink-600">{{ $reservation->term?->doctor?->name }}</td>
                                <td class="text-ink-600 tabular-nums">{{ $reservation->term?->cabinet?->number }}</td>
                                <td class="text-ink-600">
                                    <span class="inline-flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span>
                                        {{ ucfirst($reservation->state) }}
                                    </span>
                                </td>

                                <td class="text-right">
                                    <form method="POST"
                                          action="{{ route('admin.users.term.delete', $reservation->term) }}"
                                          onsubmit="return confirm('Delete this reservation?');">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn-outline btn-sm text-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif

    </div>
</x-app-layout>
