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
        <div class="btn-group dropend">
            <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" style="width: 200px;">
                {{ old('department') ? old('department') : 'Select department' }}
            </button>
            <ul class="dropdown-menu">
                <li><button type="button" class="btn btn-secondary dropdown-item" onclick="changeText('IT')">IT</button></li>
                <li><button type="button" class="btn btn-secondary dropdown-item" onclick="changeText('Finance')">Finance</button></li>
                <li><button type="button" class="btn btn-secondary dropdown-item" onclick="changeText('HR')">HR</button></li>
                <li><button type="button" class="btn btn-secondary dropdown-item" onclick="changeText('Accounting')">Accounting</button></li>
                <li><button type="button" class="btn btn-secondary dropdown-item" onclick="changeText('Audit')">Audit</button></li>
                <li><button type="button" class="btn btn-secondary dropdown-item" onclick="changeText('Marketing')">Marketing</button></li>
                <li><button type="button" class="btn btn-secondary dropdown-item" onclick="changeText('Tax')">Tax</button></li>
                <li><button type="button" class="btn btn-secondary dropdown-item" onclick="changeText('Others')">Others</button></li>
            </ul>
        </div>
        <input type="hidden" id="department" name="department" value="{{ old('department') }}">
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
        <x-primary-button class="w-full">
            <span class="text-lg text-center w-full">{{ __('Register') }}</span>
        </x-primary-button>
    </div>

    <script>
        function changeText(dept) {
            document.querySelector('.dropdown-toggle').textContent = dept;
            document.getElementById('department').value = dept;
        }
    </script>
</form>
