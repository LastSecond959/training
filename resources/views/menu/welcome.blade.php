<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome Page</title>

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    </head>
    <body>
        <x-guest-layout>
            <div class="d-flex justify-content-center pt-2 pb-3">
                <img src="{{ asset('images/logo-cjfi.png') }}" alt="Company Logo" width="60" height="60">
            </div>

            <!-- Tabs -->
            <div class="d-flex justify-content-center btn-group pt-2 pb-3" style="width: 100%;">
                <button type="button" id="loginTab" class="btn btn-success active py-2 w-50" onclick="showLogin()">Login</button>
                <button type="button" id="registerTab" class="btn btn-success py-2 w-50" onclick="showRegister()">Register</button>
            </div>
            
            <!-- Login Form -->
            <div id="loginForm" class="p-2">
                @include('auth.login')
            </div>

            <!-- Register Form -->
            <div id="registerForm" class="p-2" style="display: none;">
                @include('auth.register')
            </div>
        </x-guest-layout>

        <script>
            // Show login form and hide register form
            function showLogin() {
                document.getElementById('loginForm').style.display = 'block';
                document.getElementById('registerForm').style.display = 'none';
                document.getElementById('loginTab').classList.add('active');
                document.getElementById('registerTab').classList.remove('active');
            }
            
            // Show register form and hide login form
            function showRegister() {
                document.getElementById('registerForm').style.display = 'block';
                document.getElementById('loginForm').style.display = 'none';
                document.getElementById('registerTab').classList.add('active');
                document.getElementById('loginTab').classList.remove('active');
            }
        </script>
    </body>
</html>
