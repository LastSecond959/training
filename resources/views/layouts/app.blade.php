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
            .bg-in-progress {
                background-color: blue;
                color: white;
                padding: 10px 12px;
            }
            .bg-closed {
                background-color: black;
                color: white;
                padding: 10px 12px;
            }
            .bg-open {
                background-color: green;
                color: white;
                padding: 10px 12px;
            }
            .bg-on-hold {
                background-color: yellow;
                color: black;
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
            .bg-low, .btn.bg-low:hover, .btn.bg-low:active, .btn.bg-low:focus {
                background-color: #20c997;
                color: white;
                padding: 10px 12px;
            }

            /* Button Active State: Green background with white text */
            .pagination .page-item.active .page-link {
                background-color: #28a745; /* Green */
                border-color: #28a745;
                color: white; /* White text */
            }

            /* Remove focus ring */
            .pagination .page-item.active .page-link:focus {
                outline: none;
                box-shadow: none;
            }

            /* Hover Effect: Darker Green on hover */
            .pagination .page-item:hover .page-link {
                background-color: #218838; /* Darker green */
                color: white;
            }

            /* Default link color (green) */
            .pagination .page-item .page-link {
                color: #28a745;
            }

            /* Disabled state */
            .pagination .page-item.disabled .page-link {
                color: #6c757d;
                background-color: transparent;
                border-color: #6c757d;
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
