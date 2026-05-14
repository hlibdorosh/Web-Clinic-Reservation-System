<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            About InterKlinik
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- General Info Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Welcome to InterKlinik</h3>
                    <p class="text-gray-700 leading-relaxed">
                        InterKlinik is a modern medical facility dedicated to providing comprehensive healthcare services to our community.
                        With state-of-the-art equipment and a team of dedicated healthcare professionals, we are committed to delivering
                        the highest quality medical care to all our patients.
                    </p>
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-900 mb-2">📍 Address</h4>
                            <p class="text-gray-700">123 Medical Street, Healthcare City, HC 12345</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-900 mb-2">📞 Phone</h4>
                            <p class="text-gray-700">+421 2 1234 5678</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-900 mb-2">✉️ Email</h4>
                            <a href="mailto:info@interklinik.sk" class="text-blue-600 hover:text-blue-800 hover:underline transition-colors cursor-pointer">info@interklinik.sk</a>
                        </div>
                    </div>
                    <div class="mt-6 bg-green-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-green-900 mb-3">🕒 Opening Hours</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-gray-700">
                            <p><strong>Monday - Friday:</strong> 08:00 - 18:00</p>
                            <p><strong>Saturday:</strong> 09:00 - 14:00</p>
                            <p><strong>Sunday:</strong> Closed</p>
                            <p><strong>Emergency:</strong> 24/7 Available</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Departments Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">🏥 Our Departments</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($departments as $dept)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-all">
                                <h4 class="font-semibold text-gray-900 mb-2">{{ $dept->name }}</h4>
                                <p class="text-gray-600 text-sm">{{ $dept->desc ?? 'Professional medical services available' }}</p>
                                <button type="button" onclick="openServicesModal({{ $dept->id }}, '{{ $dept->name }}', {{ json_encode($dept->services) }})" class="block text-blue-600 text-sm mt-2 hover:text-blue-800 font-semibold cursor-pointer">
                                    <strong>Services:</strong> {{ count($dept->services) }} →
                                </button>
                                <a href="{{ route('user.terms.index', ['dep_id' => $dept->id]) }}" class="block text-blue-500 text-xs mt-3 font-semibold hover:text-blue-700 transition-colors">View Available Terms →</a>
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-full">No departments available</p>
                        @endforelse
                    </div>
                </div>
            </div>


            <!-- Doctors Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">👨‍⚕️ Our Medical Team</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($doctors as $doctor)
                            <a href="{{ route('doctors.show', $doctor) }}" class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow cursor-pointer hover:border-blue-400">
                                <div class="flex items-start gap-3 mb-2">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold text-white"
                                         style="background: linear-gradient(135deg, #0582a3, #0a6884);">
                                        {{ strtoupper(substr($doctor->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $doctor->name }}</h4>
                                        <p class="text-sm text-blue-600">Dr.</p>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-2">{{ $doctor->bio ?? 'Specialized medical professional' }}</p>
                                @if($doctor->phone)
                                    <p class="text-gray-500 text-xs">📞 {{ $doctor->phone }}</p>
                                @endif
                            </a>
                        @empty
                            <p class="text-gray-500 col-span-full">No doctors available</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- License/Credentials Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">📜 License & Credentials</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700 mb-2">
                            <strong>Business License:</strong> CZ12345678
                        </p>
                        <p class="text-gray-700 mb-2">
                            <strong>Medical Director:</strong> Dr. John Smith, MD
                        </p>
                        <p class="text-gray-700 mb-4">
                            <strong>Accreditation:</strong> Fully accredited by the Ministry of Health
                        </p>
                        <p class="text-gray-600 text-sm">
                            InterKlinik is committed to maintaining the highest standards of medical care and patient safety.
                            All our facilities and staff meet or exceed international healthcare standards.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Services Modal -->
    <div id="servicesModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="sticky top-0 flex justify-between items-center p-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                <div>
                    <h2 class="text-2xl font-bold">Services</h2>
                    <p id="deptNameDisplay" class="text-blue-100 text-sm mt-1"></p>
                </div>
                <button type="button" onclick="closeServicesModal()" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div id="servicesContainer" class="space-y-3">
                    <!-- Services will be inserted here -->
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="border-t border-gray-200 p-4 bg-gray-50 flex justify-end gap-2">
                <button type="button" onclick="closeServicesModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition-all font-medium">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Click outside modal to close -->
    <script>
        const modal = document.getElementById('servicesModal');

        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeServicesModal();
            }
        });

        function openServicesModal(deptId, deptName, services) {
            const deptNameDisplay = document.getElementById('deptNameDisplay');
            const servicesContainer = document.getElementById('servicesContainer');

            deptNameDisplay.textContent = deptName;

            if (services.length === 0) {
                servicesContainer.innerHTML = '<p class="text-gray-500 text-center py-8">No services available for this department</p>';
            } else {
                servicesContainer.innerHTML = services.map(service => `
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all hover:border-blue-300">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-900 flex-1">${service.name}</h3>
                            <span class="bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-bold px-3 py-1 rounded-full ml-2">
                                €${parseFloat(service.price).toFixed(2)}
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-3">${service.desc || 'Professional medical service'}</p>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 01 0 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span>Department</span>
                        </div>
                    </div>
                `).join('');
            }

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeServicesModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeServicesModal();
            }
        });
    </script>
</x-app-layout>
