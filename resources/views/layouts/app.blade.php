<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-light border-right fixed top-0 left-0 h-full w-64 transform -translate-x-full transition-transform duration-300 ease-in-out">
            <div class="list-group list-group-flush">
                <a href="{{ route('posts.index') }}" class="list-group-item list-group-item-action bg-light">Table</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">Shortcuts</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">Overview</a>
            </div>
        </div>

        <!-- Content area -->
        <div class="flex-grow flex flex-col">
            <!-- Navigation bar -->
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#sidebarToggle').on('click', function() {
                $('#sidebar').toggleClass('translate-x-0 -translate-x-full');
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('#sidebar, #sidebarToggle').length) {
                    $('#sidebar').addClass('-translate-x-full');
                }
            });
        });
    </script>
    <style>
        #sidebar {
            width: 250px;
            transition: transform 0.3s ease;
        }

        #sidebar.translate-x-0 {
            transform: translateX(0);
        }

        #sidebar.-translate-x-full {
            transform: translateX(-100%);
        }
    </style>
</body>
</html>
