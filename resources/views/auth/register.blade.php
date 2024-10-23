<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div>
        <x-input-label for="name">
            {{ __('Name') }}<span class="text-red-600">*</span>
        </x-input-label>
        <x-text-input
            id="name"
            class="block mt-1 w-full outline outline-1 outline-black"
            type="text"
            name="name"
            :value="old('name')"
            required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Department -->
    <div class="mt-3">
        <x-input-label for="department">
            {{ __('Department') }}<span class="text-red-600">*</span>
        </x-input-label>
        <select id="department" class="block mt-1 w-full rounded-md outline outline-1 outline-black" name="department" required>
            <option value="" selected disabled>Select department</option>
            <option value="IT" {{ old('department') === 'IT' ? 'selected' : '' }}>IT</option>
            <option value="Finance" {{ old('department') === 'Finance' ? 'selected' : '' }}>Finance</option>
            <option value="HR"  {{ old('department') === 'HR' ? 'selected' : '' }}>HR</option>
            <option value="Accounting" {{ old('department') === 'Accounting' ? 'selected' : '' }}>Accounting</option>
            <option value="Audit" {{ old('department') === 'Audit' ? 'selected' : '' }}>Audit</option>
            <option value="Marketing" {{ old('department') === 'Marketing' ? 'selected' : '' }}>Marketing</option>
            <option value="Tax" {{ old('department') === 'Tax' ? 'selected' : '' }} >Tax</option>
            <option value="Others" {{ old('department') === 'Others' ? 'selected' : '' }}>Others</option>
        </select>
        <x-input-error :messages="$errors->get('department')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-3">
        <x-input-label for="email">
            {{ __('Email') }}<span class="text-red-600">*</span>
        </x-input-label>
        <x-text-input
            id="email"
            class="block mt-1 w-full outline outline-1 outline-black"
            type="email"
            name="email"
            :value="old('email')"
            required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-3">
        <x-input-label for="password">
            {{ __('Password') }}<span class="text-red-600">*</span>
        </x-input-label>
        <x-text-input
            id="password"
            class="block mt-1 w-full outline outline-1 outline-black"
            type="password"
            name="password"
            required autocomplete="new-password"
        />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-3">
        <x-input-label for="password_confirmation">
            {{ __('Confirm Password') }}<span class="text-red-600">*</span>
        </x-input-label>
        <x-text-input
            id="password_confirmation"
            class="block mt-1 w-full outline outline-1 outline-black"
            type="password"
            name="password_confirmation"
            required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex items-center justify-center mt-5">
        <x-primary-button>
            <span class="text-lg">{{ __('Register') }}</span>
        </x-primary-button>
    </div>
</form>
