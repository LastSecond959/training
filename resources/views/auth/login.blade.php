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
            required
            autofocus
            autocomplete="username"
        />
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
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                name="remember"
            />
            <span class="ms-2 text-sm text-gray-600">
                {{ __('Remember me') }}
            </span>
        </label>

        <!-- Forgot Password -->
        @if (Route::has('password.request'))
            <!-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                {{ __('Forgot password?') }}
            </a> -->
            <button id="forgotPassword" onclick="forgotPassword()" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Forgot Password</button>
        @endif
    </div>

    <script>
        function forgotPassword() {
            document.getElementById("welcome.loginForm").classList.add("hidden");
        }
    </script>

    <div class="flex items-center justify-center mt-4">
        <x-primary-button>
            {{ __('Log in') }}
        </x-primary-button>
    </div>
</form>
