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
    <div class="mt-4">
        <x-input-label for="department">
            {{ __('Department') }}<span class="text-red-600">*</span>
        </x-input-label>
        <select id="department" class="block mt-1 w-full rounded-md outline outline-1 outline-black" name="department" required>
            <option value="" selected disabled>Select department</option>
            <option value="IT">IT</option>
            <option value="Finance">Finance</option>
            <option value="HR">HR</option>
            <option value="Accounting">Accounting</option>
            <option value="Audit">Audit</option>
            <option value="Marketing">Marketing</option>
            <option value="Tax">Tax</option>
            <option value="Others">Others</option>
        </select>
        <x-input-error :messages="$errors->get('department')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
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
    <div class="mt-4">
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
    <div class="mt-4">
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

    <div class="flex items-center justify-center mt-4">
        <!-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a> -->

        <x-primary-button>
            {{ __('Register') }}
        </x-primary-button>
    </div>
</form>
