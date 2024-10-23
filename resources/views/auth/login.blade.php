<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('login') }}">
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
                class="rounded text-blue-500 border-blue-600 focus:ring-blue-500 shadow-md"
                name="remember"
            />
            <span class="ms-2 text-sm text-gray-600">
                {{ __('Remember me') }}
            </span>
        </label>

        <!-- Forgot Password -->
        @if (Route::has('password.request'))
            <a class="link-opacity-75-hover fs-6" onclick="forgotPassword()" href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
        @endif
    </div>

    <script>
        function forgotPassword() {
            document.getElementById("welcome.loginForm").classList.add("hidden");
        }
    </script>

    <div class="flex items-center justify-center mt-5">
        <x-primary-button>
            <span class="text-lg">{{ __('Log In') }}</span>
        </x-primary-button>
    </div>
</form>
