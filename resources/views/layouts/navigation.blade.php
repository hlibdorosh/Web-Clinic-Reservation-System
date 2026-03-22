<nav x-data="{ open: false }"
     class="bg-white/95 backdrop-blur-sm border-b-2 border-ocean-200 shadow-ocean-sm sticky top-0 z-50">

    <!-- Top accent stripe -->
    <div class="h-0.5 w-full" style="background: linear-gradient(90deg, #0f546b 0%, #03a2c1 50%, #0fbedd 100%);"></div>

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                        <x-application-logo class="block h-8 w-auto fill-current text-ocean-600 group-hover:text-ocean-500 transition-colors duration-150" />
                        <span class="hidden sm:block text-sm font-bold text-ocean-800 group-hover:text-ocean-600 transition-colors duration-150">
                            {{ config('app.name', 'Clinic') }}
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- USER --}}
                    @if(Auth::user()->role === 'patient')
                        <x-nav-link :href="route('user.terms.index')"
                                    :active="request()->routeIs('user.terms.*')">
                            {{ __('Browse Terms') }}
                        </x-nav-link>

                        <x-nav-link :href="route('user.reservations.index')"
                                    :active="request()->routeIs('user.reservations.*')">
                            {{ __('My Reservations') }}
                        </x-nav-link>

                        <x-nav-link :href="route('user.patient-info.edit')"
                                    :active="request()->routeIs('user.patient-info.*')">
                            {{ __('My Health Info') }}
                        </x-nav-link>
                    @endif

                    {{-- DOCTOR --}}
                    @if(auth()->check() && auth()->user()->role === 'doctor')
                        <x-nav-link :href="route('doctor.terms.index')" :active="request()->routeIs('doctor.terms.index')">
                            {{ __('My Terms') }}
                        </x-nav-link>

                        <x-nav-link :href="route('doctor.terms.create')" :active="request()->routeIs('doctor.terms.create')">
                            {{ __('Add Term') }}
                        </x-nav-link>
                    @endif

                    {{-- ADMIN --}}
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.users.index')"
                                    :active="request()->routeIs('admin.users.*')">
                            {{ __('Users') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.departments.index')"
                                    :active="request()->routeIs('admin.departments.*')">
                            {{ __('Departments') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.cabinets.index')"
                                    :active="request()->routeIs('admin.cabinets.*')">
                            {{ __('Cabinets') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.services.index')"
                                    :active="request()->routeIs('admin.services.*')">
                            {{ __('Services') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 rounded-lg
                                       text-sm font-medium text-ocean-700 bg-transparent
                                       hover:bg-ocean-50 hover:text-ocean-900
                                       focus:outline-none focus:ring-2 focus:ring-ocean-400 focus:ring-offset-1
                                       transition-all duration-150 ease-in-out">
                            <!-- Avatar circle -->
                            <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white"
                                  style="background: linear-gradient(135deg, #0582a3, #0a6884);">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="fill-current h-4 w-4 text-ocean-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-lg
                               text-ocean-400 hover:text-ocean-600 hover:bg-ocean-50
                               focus:outline-none focus:bg-ocean-50 focus:text-ocean-600
                               transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-ocean-100 bg-white/98">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            {{-- USER --}}
            @if(Auth::user()->role === 'patient')
                <x-responsive-nav-link :href="route('user.terms.index')"
                                       :active="request()->routeIs('user.terms.*')">
                    {{ __('Browse Terms') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('user.reservations.index')"
                                       :active="request()->routeIs('user.reservations.*')">
                    {{ __('My Reservations') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('user.patient-info.edit')"
                                       :active="request()->routeIs('user.patient-info.*')">
                    {{ __('My Health Info') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-ocean-100">
            <div class="px-4 flex items-center gap-3">
                <span class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold text-white"
                      style="background: linear-gradient(135deg, #0582a3, #0a6884);">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
                <div>
                    <div class="font-semibold text-base text-ocean-900">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-ocean-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
