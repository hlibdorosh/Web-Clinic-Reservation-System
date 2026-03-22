<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Patient Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Please provide your personal health information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('user.patient-info.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="birth_date" :value="__('Birth Date')" />
            <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date', $patientInfo->birth_date?->format('Y-m-d')) }}" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" />
            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="height" :value="__('Height (cm)')" />
            <input id="height" type="number" step="0.01" name="height" value="{{ old('height', $patientInfo->height) }}" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" />
            <x-input-error :messages="$errors->get('height')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="weight" :value="__('Weight (kg)')" />
            <input id="weight" type="number" step="0.01" name="weight" value="{{ old('weight', $patientInfo->weight) }}" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" />
            <x-input-error :messages="$errors->get('weight')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="sex" :value="__('Sex')" />
            <select id="sex" name="sex" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                <option value="">{{ __('Select gender') }}</option>
                <option value="М" {{ old('sex', $patientInfo->sex) === 'М' ? 'selected' : '' }}>{{ __('Male') }}</option>
                <option value="Ж" {{ old('sex', $patientInfo->sex) === 'Ж' ? 'selected' : '' }}>{{ __('Female') }}</option>
            </select>
            <x-input-error :messages="$errors->get('sex')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'patient-info-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

