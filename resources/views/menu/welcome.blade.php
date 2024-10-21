<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- <script type="text/javascript">
            function preventBack() { window.history.forward(); }
            setTimeout("preventBack()", 0);
            window.onunload = function () { null };
        </script> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome Page</title>

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> -->

        <style>
            .hidden {
                display: none;
            }
            .btn {
                background-color: black;  /* Initial background color */
                color: white;  /* Initial text color */
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                /* transition: background-color 0.3s ease, transform 0.3s ease; */
            }
            .btn:hover, .btn:focus {
                background-color: #02753c;
                color: white;
                transform: scale(1.1);
            }
            .btn.active { background-color: #03592E; color: white; }
            .btn.inactive { background-color: white; color: black; border: 1px solid black; }
        </style>
    </head>
    <body>
        <x-guest-layout>
            <!-- Tabs -->
            <div class="flex justify-center p-6">
                <button type="button" id="loginTab" class="btn active" onclick="showLogin()">Login</button>
                <button type="button" id="registerTab" class="btn inactive" onclick="showRegister()">Register</button>
            </div>
            
            <!-- Login Form -->
            <div id="loginForm" class="p-2">
                @include('auth.login')
            </div>

            <!-- Register Form -->
            <div id="registerForm" class="hidden p-2">
                @include('auth.register')
            </div>
        </x-guest-layout>

        <script>
            function showLogin() {
                // Show login form and hide register form
                document.getElementById('loginForm').classList.remove('hidden');
                document.getElementById('registerForm').classList.add('hidden');

                // Toggle button styles for Login
                document.getElementById('loginTab').classList.add('active');
                document.getElementById('registerTab').classList.remove('active');
                document.getElementById('loginTab').classList.remove('inactive');
                document.getElementById('registerTab').classList.add('inactive');
            }

            function showRegister() {
                // Show register form and hide login form
                document.getElementById('loginForm').classList.add('hidden');
                document.getElementById('registerForm').classList.remove('hidden');

                // Toggle button styles for Register
                document.getElementById('registerTab').classList.add('active');
                document.getElementById('loginTab').classList.remove('active');
                document.getElementById('registerTab').classList.remove('inactive');
                document.getElementById('loginTab').classList.add('inactive');
            }
        </script>
    </body>
</html>
