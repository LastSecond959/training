<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('login') }}" id="login-form">
    @csrf

    <!-- Email Address -->
    <div>
        <x-input-label for="email">
            {{ __('Email') }}<span class="text-red-600">*</span>
        </x-input-label>
        <x-text-input
            id="email"
            class="block mt-1 w-full outline outline-1 outline-black"
            type="email"
            name="email"
            :value="old('email')"
            placeholder="*@mail.com"
            required
            autofocus
            autocomplete="username"
        />
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
            required
            autocomplete="current-password"
        />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div class="flex items-center justify-between mt-2">
        <!-- Remember Me -->
        <label for="remember_me" class="inline-flex items-center">
            <input
                id="remember_me"
                type="checkbox"
                class="rounded text-blue-500 border-black shadow-md"
                name="remember"
            />
            <span class="ms-2 text-sm text-gray-700">
                {{ __('Remember me') }}
            </span>
        </label>

        <!-- Forgot Password -->
        @if (Route::has('password.request'))
            <a class="link-opacity-75-hover fs-6" onclick="forgotPassword()" href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
        @endif
    </div>

    <div class="flex items-center justify-center mt-5">
        <x-primary-button class="w-full">
            <span class="text-lg text-center w-full">{{ __('Log In') }}</span>
        </x-primary-button>
    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const remember = document.getElementById('remember_me').checked;

            fetch('{{ route('login') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ email, password, remember })
            })
            .then(response => location.reload())
            .catch(error => console.error('Error:', error));
        });
    </script>
</form>
