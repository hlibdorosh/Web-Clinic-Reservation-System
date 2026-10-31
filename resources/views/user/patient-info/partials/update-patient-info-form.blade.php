<section>
    <header>
        <h2 class="text-base font-medium text-ink-900">
            {{ __('Patient Information') }}
        </h2>

        <p class="mt-1 text-sm text-ink-600">
            {{ __("Please provide your personal health information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('user.patient-info.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="birth_date" :value="__('Birth date')" />
            <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date', $patientInfo->birth_date?->format('Y-m-d')) }}" class="input mt-1 block w-full" />
            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="height" :value="__('Height (cm)')" />
            <input id="height" type="number" step="0.01" name="height" value="{{ old('height', $patientInfo->height) }}" class="input mt-1 block w-full" />
            <x-input-error :messages="$errors->get('height')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="weight" :value="__('Weight (kg)')" />
            <input id="weight" type="number" step="0.01" name="weight" value="{{ old('weight', $patientInfo->weight) }}" class="input mt-1 block w-full" />
            <x-input-error :messages="$errors->get('weight')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="sex" :value="__('Sex')" />
            <select id="sex" name="sex" class="input mt-1 block w-full">
                <option value="">{{ __('Select gender') }}</option>
                <option value="М" {{ old('sex', $patientInfo->sex) === 'М' ? 'selected' : '' }}>{{ __('Male') }}</option>
                <option value="Ж" {{ old('sex', $patientInfo->sex) === 'Ж' ? 'selected' : '' }}>{{ __('Female') }}</option>
            </select>
            <x-input-error :messages="$errors->get('sex')" class="mt-2" />
        </div>

        @if ($patientInfo->health_data_consent_at === null)
            <div>
                <div class="flex items-start gap-3">
                    <input id="health_data_consent" name="health_data_consent" type="checkbox" value="1" required
                           @checked(old('health_data_consent'))
                           class="mt-0.5 h-4 w-4 rounded border-line-strong text-ocean-700 focus:ring-ocean-500">
                    <label for="health_data_consent" class="text-sm text-ink-600 leading-5">
                        I agree that the clinic may process this health information to manage my visits and care, as described in the <a href="{{ route('legal.privacy') }}#health" class="text-ocean-700 underline hover:no-underline">Privacy policy</a>. You can withdraw consent by deleting your account.
                    </label>
                </div>
                <x-input-error :messages="$errors->get('health_data_consent')" class="mt-2" />
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'patient-info-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-ink-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

