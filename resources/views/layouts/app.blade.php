<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        <style>
            /* Buttons */
            .bg-open {
                background-color: green;
                color: white;
                padding: 10px 12px;
            }
            .bg-in-progress, .btn.bg-in-progress:hover, .btn.bg-in-progress:active, .btn.bg-in-progress:focus {
                background-color: blue;
                color: white;
                padding: 10px 12px;
            }
            .bg-on-hold, .btn.bg-on-hold:hover, .btn.bg-on-hold:active, .btn.bg-on-hold:focus {
                background-color: yellow;
                color: black;
                padding: 10px 12px;
            }
            .bg-closed, .btn.bg-closed:hover, .btn.bg-closed:active, .btn.bg-closed:focus {
                background-color: black;
                color: white;
                padding: 10px 12px;
            }
            
            .bg-low, .btn.bg-low:hover, .btn.bg-low:active, .btn.bg-low:focus {
                background-color: #20c997;
                color: white;
                padding: 10px 12px;
            }
            .bg-urgent, .btn.bg-urgent:hover, .btn.bg-urgent:active, .btn.bg-urgent:focus {
                background-color: #ee7d21;
                color: white;
                padding: 10px 12px;
            }
            .bg-emergency, .btn.bg-emergency:hover, .btn.bg-emergency:active, .btn.bg-emergency:focus {
                background-color: #e5192e;
                color: white;
                padding: 10px 12px;
            }

            /* Pagination */
            .pagination {
                --bs-pagination-color: #198754;
                --bs-pagination-border-color: #dee2e6;
                --bs-pagination-hover-color: #157347;
                --bs-pagination-hover-bg: #e2e3e5;
                --bs-pagination-hover-border-color: #6c757d;
                --bs-pagination-focus-color: #157347;
                --bs-pagination-focus-bg: #dee2e6;
                --bs-pagination-focus-box-shadow: 0 0 0 .05rem #6c757d;
                --bs-pagination-active-bg: #146c43;
                --bs-pagination-active-border-color: #13653f;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </body>
</html>
