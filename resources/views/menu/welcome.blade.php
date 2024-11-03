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
            .btn.dropdown-toggle {
                background-color: #1F2937;
                color: white;
                transition: background-color 0.3s ease, transform 0.3s ease;
            }
            .btn.dropdown-toggle:hover, .btn.dropdown-toggle:focus {
                background-color: #374151;
                color: white;
                /* transform: scale(1.1); */
            }
        </style>
    </head>
    <body>
        <x-guest-layout>
            <div class="d-flex justify-content-center pt-2 pb-3">
                <img src="{{ asset('images\logo-cjfi.png') }}" alt="Company Logo" width="60" height="60">
            </div>

            <!-- Tabs -->
            <div class="d-flex justify-content-center btn-group pt-2 pb-3" style="width: 100%;">
                <button type="button" id="loginTab" class="btn btn-success active py-2 w-50" onclick="showLogin()">Login</button>
                <button type="button" id="registerTab" class="btn btn-success py-2 w-50" onclick="showRegister()">Register</button>
            </div>
            
            <!-- Dropup -->
            <!-- <div class="d-flex justify-content-center dropup-center pt-6 pb-2">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Login 
                </button>
                <ul class="dropdown-menu">
                    <li><button type="button" class="dropdown-item text-center" onclick="showLogin()">Login</button></li>
                    <li><button type="button" class="dropdown-item text-center" onclick="showRegister()">Register</button></li>
                </ul>
            </div> -->
            
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

            // Dropup Menu
            //     // Show login form and hide register form
            // function showLogin() {
            //     document.getElementById('loginForm').style.display = 'block';
            //     document.getElementById('registerForm').style.display = 'none';
            //     document.querySelector('.dropdown-toggle').textContent = 'Login ';
            // }

            //     // Show register form and hide login form
            // function showRegister() {
            //     document.getElementById('registerForm').style.display = 'block';
            //     document.getElementById('loginForm').style.display = 'none';
            //     document.querySelector('.dropdown-toggle').textContent = 'Register ';
            // }
        </script>
    </body>
</html>
