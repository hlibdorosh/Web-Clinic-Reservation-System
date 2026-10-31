<x-app-layout>
    <x-slot name="header">
        <h2>
            About InterKlinik
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- General Info Section -->
            <div class="card p-5 sm:p-6">
                <h3 class="text-lg font-medium text-ink-900 mb-3">Welcome to InterKlinik</h3>
                <p class="text-sm text-ink-600 leading-relaxed">
                    InterKlinik is a medical clinic in Bratislava. Our doctors work in the departments listed below, and you can
                    book a visit online with the doctor and service you need.
                </p>
                <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-ink-50 border border-line p-4 rounded-lg">
                        <h4 class="text-xs text-ink-500 mb-1">Address</h4>
                        <p class="text-sm text-ink-900">123 Medical Street, Healthcare City, HC 12345</p>
                    </div>
                    <div class="bg-ink-50 border border-line p-4 rounded-lg">
                        <h4 class="text-xs text-ink-500 mb-1">Phone</h4>
                        <p class="text-sm text-ink-900 tabular-nums">+421 2 1234 5678</p>
                    </div>
                    <div class="bg-ink-50 border border-line p-4 rounded-lg">
                        <h4 class="text-xs text-ink-500 mb-1">Email</h4>
                        <a href="mailto:info@interklinik.sk" class="text-sm text-ocean-700 hover:underline transition-colors">info@interklinik.sk</a>
                    </div>
                </div>
                <div class="mt-4 bg-ink-50 border border-line p-4 rounded-lg">
                    <h4 class="text-xs text-ink-500 mb-3">Opening hours</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-ink-600 tabular-nums">
                        <p><span class="font-medium text-ink-900">Monday - Friday:</span> 08:00 - 18:00</p>
                        <p><span class="font-medium text-ink-900">Saturday:</span> 09:00 - 14:00</p>
                        <p><span class="font-medium text-ink-900">Sunday:</span> Closed</p>
                        <p><span class="font-medium text-ink-900">Emergency:</span> 24/7 available</p>
                    </div>
                </div>
            </div>

            <!-- Departments Section -->
            <div class="card p-5 sm:p-6">
                <h3 class="text-lg font-medium text-ink-900 mb-4">Our departments</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($departments as $dept)
                        <div class="border border-line rounded-lg p-4">
                            <h4 class="text-base font-medium text-ink-900 mb-1">{{ $dept->name }}</h4>
                            <p class="text-ink-600 text-sm">{{ $dept->desc ?? 'Professional medical services available' }}</p>
                            <button type="button" onclick="openServicesModal({{ $dept->id }}, '{{ $dept->name }}', {{ json_encode($dept->services) }})" class="block text-ocean-700 text-sm mt-3 hover:underline font-medium">
                                Services: <span class="tabular-nums">{{ count($dept->services) }}</span> →
                            </button>
                            <a href="{{ route('user.terms.index', ['dep_id' => $dept->id]) }}" class="block text-ocean-700 text-xs mt-2 font-medium hover:underline transition-colors">View available terms →</a>
                        </div>
                    @empty
                        <p class="text-ink-500 text-sm col-span-full">No departments available</p>
                    @endforelse
                </div>
            </div>


            <!-- Doctors Section -->
            <div class="card p-5 sm:p-6">
                <h3 class="text-lg font-medium text-ink-900 mb-4">Our medical team</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($doctors as $doctor)
                        <a href="{{ route('doctors.show', $doctor) }}" class="border border-line rounded-lg p-4 transition-colors hover:bg-ink-50">
                            <div class="flex items-start gap-3 mb-2">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-medium bg-ink-100 text-ink-600">
                                    {{ strtoupper(substr($doctor->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="text-base font-medium text-ink-900">{{ $doctor->name }}</h4>
                                    <p class="text-sm text-ink-500">Dr.</p>
                                </div>
                            </div>
                            <p class="text-ink-600 text-sm mb-2">{{ $doctor->bio ?? 'Specialized medical professional' }}</p>
                            @if($doctor->phone)
                                <p class="text-ink-500 text-xs tabular-nums">{{ $doctor->phone }}</p>
                            @endif
                        </a>
                    @empty
                        <p class="text-ink-500 text-sm col-span-full">No doctors available</p>
                    @endforelse
                </div>
            </div>

            <!-- License/Credentials Section -->
            <div class="card p-5 sm:p-6">
                <h3 class="text-lg font-medium text-ink-900 mb-4">License and credentials</h3>
                <div class="bg-ink-50 border border-line p-4 rounded-lg">
                    <p class="text-sm text-ink-600 mb-2">
                        <span class="font-medium text-ink-900">Business license:</span> CZ12345678
                    </p>
                    <p class="text-sm text-ink-600 mb-2">
                        <span class="font-medium text-ink-900">Medical director:</span> Dr. John Smith, MD
                    </p>
                    <p class="text-sm text-ink-600 mb-4">
                        <span class="font-medium text-ink-900">Accreditation:</span> Fully accredited by the Ministry of Health
                    </p>
                    <p class="text-ink-500 text-xs">
                        InterKlinik is committed to maintaining the highest standards of medical care and patient safety.
                        All our facilities and staff meet or exceed international healthcare standards.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- Services Modal -->
    <div id="servicesModal" class="hidden fixed inset-0 bg-ink-900/40 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl border border-line-strong max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="sticky top-0 flex justify-between items-center p-5 sm:p-6 bg-white border-b border-line">
                <div>
                    <h2 class="text-lg font-medium text-ink-900">Services</h2>
                    <p id="deptNameDisplay" class="text-ink-500 text-sm mt-1"></p>
                </div>
                <button type="button" onclick="closeServicesModal()" class="text-ink-500 hover:bg-ink-50 rounded-lg p-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-5 sm:p-6">
                <div id="servicesContainer" class="space-y-3">
                    <!-- Services will be inserted here -->
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="border-t border-line p-4 bg-ink-50 flex justify-end gap-2">
                <button type="button" onclick="closeServicesModal()" class="btn btn-outline">
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
                servicesContainer.innerHTML = '<p class="text-ink-500 text-sm text-center py-8">No services available for this department</p>';
            } else {
                servicesContainer.innerHTML = services.map(service => `
                    <div class="border border-line rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-base font-medium text-ink-900 flex-1">${service.name}</h3>
                            <span class="text-sm font-medium text-ocean-700 tabular-nums ml-2">
                                €${parseFloat(service.price).toFixed(2)}
                            </span>
                        </div>
                        <p class="text-ink-600 text-sm mb-3">${service.desc || 'Professional medical service'}</p>
                        <div class="flex items-center gap-2 text-xs text-ink-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 01 0 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
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
