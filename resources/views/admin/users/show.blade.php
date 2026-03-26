<x-app-layout>
    <div class="p-6">

        <h1 class="text-2xl mb-4">User Profile</h1>

        {{-- PERSONAL INFO --}}
        <div class="mb-6 p-4 border rounded-lg">
            <h2 class="text-xl mb-2">Personal Information</h2>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>

            {{-- ROLE CHANGE CHECKBOX --}}
            @if($user->role === 'patient')
                @php
                    $hasReservations = $user->reservations()->exists();
                    $canChangeRole = !$hasReservations;
                @endphp

                <div class="mt-4 p-3 border rounded bg-gray-50">
                    <form id="promoteForm" method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="inline">
                        @csrf
                        @method('PATCH')

                        <label class="flex items-center cursor-pointer {{ $canChangeRole ? '' : 'opacity-50 cursor-not-allowed' }}">
                            <input type="checkbox"
                                   id="promoteCheckbox"
                                   name="promote_to_doctor"
                                   value="1"
                                   onchange="showPromoteModal()"
                                   {{ $canChangeRole ? '' : 'disabled' }}
                                   class="form-checkbox">
                            <span class="ml-2 font-medium">
                                Promote to Doctor
                            </span>
                        </label>
                        @if(!$canChangeRole)
                            <p class="text-sm text-red-600 mt-2">
                                ⚠️ Cannot promote user with active reservations
                            </p>
                        @endif
                    </form>
                </div>

                <!-- Confirmation Modal -->
                <div id="promoteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm mx-auto">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Confirm Promotion</h3>
                        <p class="text-gray-600 mb-6">
                            Are you sure you want to promote <strong>{{ $user->name }}</strong> to Doctor?
                        </p>
                        <p class="text-sm text-gray-500 mb-6">
                            This action will give them access to create terms and manage appointments.
                        </p>

                        <div class="flex gap-3 justify-end">
                            <button type="button"
                                    onclick="cancelPromote()"
                                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 font-medium">
                                Cancel
                            </button>
                            <button type="button"
                                    onclick="confirmPromote()"
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
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
                <div class="mt-4 p-3 border rounded bg-blue-50">
                    <label class="flex items-center opacity-50 cursor-not-allowed">
                        <input type="checkbox"
                               checked
                               disabled
                               class="form-checkbox">
                        <span class="ml-2 font-medium">
                            Doctor Role
                        </span>
                    </label>
                </div>
            @endif
        </div>

        {{-- TERMS --}}
        <h2 class="text-xl mb-2">Terms</h2>

        @if($terms->isEmpty())
            <p>No terms</p>
        @else
            <table class="table w-full">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Service</th>
                    <th>Doctor</th>
                    <th>Cabinet</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @foreach($terms as $term)
                    <tr>
                        <td>{{ $term->date }}</td>
                        <td>{{ $term->service?->name }}</td>
                        <td>{{ $term->doctor?->name }}</td>
                        <td>{{ $term->cabinet?->number }}</td>

                        <td class="text-right">
                            <form method="POST"
                                  action="{{ route('admin.users.term.delete', $term) }}"
                                  onsubmit="return confirm('Delete this term?');">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

    </div>
</x-app-layout>
