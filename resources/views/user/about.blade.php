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
                            <p class="text-gray-700">info@interklinik.sk</p>
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
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow">
                                <h4 class="font-semibold text-gray-900 mb-2">{{ $dept->name }}</h4>
                                <p class="text-gray-600 text-sm">{{ $dept->desc ?? 'Professional medical services available' }}</p>
                                <p class="text-blue-600 text-sm mt-2">
                                    <strong>Services:</strong> {{ $dept->services()->count() }}
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-full">No departments available</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Services Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">⚕️ Our Services</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($services as $service)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-semibold text-gray-900">{{ $service->name }}</h4>
                                    <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-2 py-1 rounded">
                                        €{{ number_format($service->price, 2) }}
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm mb-2">{{ $service->desc ?? 'Professional service' }}</p>
                                <p class="text-gray-500 text-xs">
                                    <strong>Department:</strong> {{ $service->department?->name ?? 'General' }}
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-full">No services available</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Cabinets Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">🚪 Our Medical Cabinets</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($cabinets as $cabinet)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow">
                                <h4 class="font-semibold text-gray-900 mb-2">Cabinet {{ $cabinet->number }}</h4>
                                <p class="text-gray-600 text-sm mb-2">{{ $cabinet->desc ?? 'Medical examination room' }}</p>
                                <p class="text-blue-600 text-sm font-semibold">
                                    📋 {{ $cabinet->department?->name ?? 'General' }}
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-full">No cabinets available</p>
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
</x-app-layout>

