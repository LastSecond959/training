<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <link href="https://fonts.bunny.net" rel="preconnect">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.css" rel="stylesheet">
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.js"></script>

        <!-- Styles -->
        <style>
            /* Status */
            .btn-open {
                --bs-btn-color: white;
                --bs-btn-bg: #008000;
                --bs-btn-border-color: #008000;
                --bs-btn-hover-color: white;
                --bs-btn-hover-bg: #007500;
                --bs-btn-hover-border-color: #006700;
                --bs-btn-focus-shadow-rgb: 225, 83, 97;
                --bs-btn-active-color: white;
                --bs-btn-active-bg: #006700;
                --bs-btn-active-border-color: #005a00;
                --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
                --bs-btn-disabled-color: white;
                --bs-btn-disabled-bg: #008000;
                --bs-btn-disabled-border-color: #008000;
            }
            .text-bg-open {
                cursor: default;
                background-color: #008000;
                color: white;
                padding: 10px 12px;
            }

            .btn-on-hold {
                --bs-btn-color: black;
                --bs-btn-bg: #ffc107;
                --bs-btn-border-color: #ffc107;
                --bs-btn-hover-color: black;
                --bs-btn-hover-bg: #ffca2c;
                --bs-btn-hover-border-color: #ffc720;
                --bs-btn-focus-shadow-rgb: 217, 164, 6;
                --bs-btn-active-color: black;
                --bs-btn-active-bg: #ffcd39;
                --bs-btn-active-border-color: #ffc720;
                --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
                --bs-btn-disabled-color: black;
                --bs-btn-disabled-bg: #ffc107;
                --bs-btn-disabled-border-color: #ffc107;
            }
            .text-bg-on-hold {
                cursor: default;
                background-color: #ffc107;
                color: black;
                padding: 10px 12px;
            }

            .btn-in-progress {
                --bs-btn-color: white;
                --bs-btn-bg: #0000ff;
                --bs-btn-border-color: #0000ff;
                --bs-btn-hover-color: white;
                --bs-btn-hover-bg: #0000e5;
                --bs-btn-hover-border-color: #0000d0;
                --bs-btn-focus-shadow-rgb: 225, 83, 97;
                --bs-btn-active-color: white;
                --bs-btn-active-bg: #0000d0;
                --bs-btn-active-border-color: #0000af;
                --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
                --bs-btn-disabled-color: white;
                --bs-btn-disabled-bg: #0000ff;
                --bs-btn-disabled-border-color: #0000ff;
            }
            .text-bg-in-progress {
                cursor: default;
                background-color: #0000ff;
                color: white;
                padding: 10px 12px;
            }

            .btn-closed {
                --bs-btn-color: white;
                --bs-btn-bg: #212529;
                --bs-btn-border-color: #212529;
                --bs-btn-hover-color: white;
                --bs-btn-hover-bg: #424649;
                --bs-btn-hover-border-color: #373b3e;
                --bs-btn-focus-shadow-rgb: 66, 70, 73;
                --bs-btn-active-color: white;
                --bs-btn-active-bg: #4d5154;
                --bs-btn-active-border-color: #373b3e;
                --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
                --bs-btn-disabled-color: white;
                --bs-btn-disabled-bg: #212529;
                --bs-btn-disabled-border-color: #212529;
            }
            .text-bg-closed {
                cursor: default;
                background-color: #212529;
                color: white;
                padding: 10px 12px;
            }

            /* Priority */
            .btn-standard {
                --bs-btn-color: white;
                --bs-btn-bg: #15b585;
                --bs-btn-border-color: #15b585;
                --bs-btn-hover-color: white;
                --bs-btn-hover-bg: #14ae80;
                --bs-btn-hover-border-color: #13a579;
                --bs-btn-focus-shadow-rgb: 225, 83, 97;
                --bs-btn-active-color: white;
                --bs-btn-active-bg: #13a579;
                --bs-btn-active-border-color: #129e74;
                --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
                --bs-btn-disabled-color: white;
                --bs-btn-disabled-bg: #15b585;
                --bs-btn-disabled-border-color: #15b585;
            }
            .text-bg-standard {
                cursor: default;
                background-color: #15b585;
                color: white;
                padding: 10px 12px;
            }

            .btn-important {
                --bs-btn-color: white;
                --bs-btn-bg: #fd7e14;
                --bs-btn-border-color: #fd7e14;
                --bs-btn-hover-color: white;
                --bs-btn-hover-bg: #df6e11;
                --bs-btn-hover-border-color: #c9620e;
                --bs-btn-focus-shadow-rgb: 225, 83, 97;
                --bs-btn-active-color: white;
                --bs-btn-active-bg: #c9620e;
                --bs-btn-active-border-color: #b2570c;
                --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
                --bs-btn-disabled-color: white;
                --bs-btn-disabled-bg: #fd7e14;
                --bs-btn-disabled-border-color: #fd7e14;
            }
            .text-bg-important {
                cursor: default;
                background-color: #fd7e14;
                color: white;
                padding: 10px 12px;
            }

            .btn-urgent {
                --bs-btn-color: white;
                --bs-btn-bg: #e5192e;
                --bs-btn-border-color: #e5192e;
                --bs-btn-hover-color: white;
                --bs-btn-hover-bg: #cf1628;
                --bs-btn-hover-border-color: #b21222;
                --bs-btn-focus-shadow-rgb: 225, 83, 97;
                --bs-btn-active-color: white;
                --bs-btn-active-bg: #b21222;
                --bs-btn-active-border-color: #a4101f;
                --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
                --bs-btn-disabled-color: white;
                --bs-btn-disabled-bg: #e5192e;
                --bs-btn-disabled-border-color: #e5192e;
            }
            .text-bg-urgent {
                cursor: default;
                background-color: #e5192e;
                color: white;
                padding: 10px 12px;
            }

            .form-control:focus {
                color: var(--bs-body-color);
                background-color: var(--bs-body-bg);
                border-color: black;
                outline: 0;
                box-shadow: 0 0 0 .02rem black;
            }

            .form-check-input {
                width: 1.1em;
                height: 1.1em;
                margin-top: .2em;
                margin-right: .6em;
                border-color: lightgray;
            }
            .form-check-input:hover {
                background-color: lightgray;
            }
            .form-check-input:focus {
                border-color: #04592D;
                outline: 0;
                box-shadow: 0 0 0 .02rem #04592D;
            }
            .form-check-input:checked, .form-check-input:checked:hover, .form-check-input:checked:focus {
                background-color: #04592D;
                border-color: #04592D;
            }

            .underlineHover {
                text-decoration: none;
            }
            .underlineHover:hover {
                text-decoration: underline;
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
