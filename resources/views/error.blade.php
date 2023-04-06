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
        <div class="bg-gray-200 w-full px-16 md:px-0 h-screen flex items-center justify-center">
            <div class="bg-white border border-gray-200 flex flex-col items-center justify-center px-4 md:px-8 lg:px-24 py-8 rounded-lg shadow-2xl">
                <p class="text-6xl md:text-7xl lg:text-9xl font-bold tracking-wider text-gray-300">404</p>
                <p class="text-2xl md:text-3xl lg:text-5xl font-bold tracking-wider text-gray-500 mt-4">Page Not Found</p>
                <p class="text-gray-500 mt-4 pb-4 border-b-2 text-center">Sorry, the page you are looking for could not be found.</p>
                <a href="{{ url('/') }}" class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-gray-100 px-4 py-2 mt-6 rounded transition duration-150" title="Return Home">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Return Home</span>
                </a>
            </div>
        </div>
    </body>
</html>
