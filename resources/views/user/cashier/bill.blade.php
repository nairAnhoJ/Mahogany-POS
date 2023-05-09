<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reciept</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/solid.css">
    <link rel="shortcut icon" href="{{ url('logo.ico') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<body>
    <div class="flex flex-col items-center pt-20">
        <header class="flex flex-col items-center border-b border-dashed border-gray-600 w-[90%] pb-1">
            <h1 class="text-5xl">LOGO</h1>
            <h2 class="text-lg">RESTAURANT NAME</h2>
            <p class="text-sm">RESTAURANT ADDRESS</p>
            <p class="text-sm">CONTACT NUMBER</p>
            <div class="flex justify-between w-full mt-8">
                <p class="text-sm font-bold">05052023-0000001</p>
                <p class="text-sm font-bold">{{ date('m/d/Y H:i:s') }}</p>
            </div>
        </header>

        <div class="w-[90%] mt-5 border-b border-dashed border-gray-600">
            <div class="w-full">
                <div class="w-full flex justify-between">
                    <p>2<i class="uil uil-times mr-1"></i>BULALO</p>
                    <p class="whitespace-nowrap pl-3">P 450.00</p>
                </div>
                <div class="w-full flex justify-between">
                    <p>1<i class="uil uil-times mr-1"></i>SINIGANG NA BABOY</p>
                    <p class="whitespace-nowrap pl-3">P 450.00</p>
                </div>
            </div>
            <div class="w-full mt-5 mb-3">
                <div class="w-full flex justify-between text-xl font-bold">
                    <p>TOTAL</p>
                    <p class="whitespace-nowrap pl-3">P 450.00</p>
                </div>
            </div>
        </div>

        <footer class="font-semibold text mt-10">THANK YOU FOR DINING WITH US!!!</footer>
    </div>
    


    <script>
        $(document).ready(function() {
            window.print();
            window.onafterprint = function() {
                window.close();
            };
        });
    </script>
</body>
</html>