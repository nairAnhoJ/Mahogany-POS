<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <title>Mahogany-POS</title> --}}
        <title></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/solid.css">
        <link rel="shortcut icon" href="{{ url('logo.ico') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script> --}}

        <style>
            /* width */
            ::-webkit-scrollbar {
                width: 10px;
                height: 10px;
            }
          
            /* Track */
            ::-webkit-scrollbar-track {
                box-shadow: inset 0 0 2px grey; 
                border-radius: 10px;
            }
            
            /* Handle */
            ::-webkit-scrollbar-thumb {
                background: #4B5563; 
                border-radius: 10px;
            }
          
            /* Handle on hover */
            ::-webkit-scrollbar-thumb:hover {
                background: rgb(95, 95, 110); 
            }
        </style>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @if (auth()->user()->role == 1)
                @include('layouts.navigation')
            @elseif(auth()->user()->role == 2)
                @include('layouts.cashier-navigation')
            @elseif(auth()->user()->role == 3)
                @include('layouts.cook-navigation')
            @elseif(auth()->user()->role == 4)
                
            @endif

            <!-- Page Content -->
            {{ $slot }}
        </div>
    </body>
</html>
