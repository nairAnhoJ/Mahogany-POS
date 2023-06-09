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
    
    <style>
      /* Default styles */
      header, footer {
        display: block;
      }
  
      /* Styles for printing */
      @media print {
        header, footer {
          display: none;
        }
      }
    </style>
</head>
<body>
    <div class="flex flex-col items-center pt-14">
        <header class="flex flex-col items-center border-b border-dashed border-gray-600 w-[90%] pb-1">
            <img src="{{ asset('storage/'.$settings->logo) }}" class="w-1/2" alt="">
            <h2 class="text-3xl">{{ $settings->name }}</h2>
            <p class="text-2xl">{{ $settings->address }}</p>
            <p class="text-2xl">{{ $settings->number }}</p>
            <div class="flex justify-between flex-row-reverse w-full mt-8">
                <p class="text-2xl font-bold">{{$trans->table_name}}</p>
                <p class="text-2xl font-bold">CASHIER: {{ Auth::user()->name }}</p>
            </div>
            <div class="flex justify-between w-full">
                <p class="text-2xl font-bold">{{$trans->number}}</p>
                <p class="text-2xl font-bold">{{ date('m/d/Y H:i:s') }}</p>
            </div>
        </header>

        <div class="w-[90%] mt-5 border-b border-dashed border-gray-600">
            <div class="w-full">
                @php
                    $subtotal = 0;
                @endphp
                @foreach ($orders as $order)
                    <div class="w-full flex justify-between">
                        <p class="text-3xl">{{$order->quantity}}<i class="uil uil-times mr-1"></i>{{$order->name}}</p>
                        <p class="whitespace-nowrap pl-3 text-3xl">₱ {{number_format($order->amount, 2, '.', ',')}}</p>
                    </div>
                    @php
                        $subtotal = $subtotal + $order->amount;
                    @endphp
                @endforeach
                @php
                    $discount = $subtotal - $trans->total;
                @endphp
            </div>
            <div class="w-full mt-5 mb-3">
                <div class="w-full flex justify-between text-2xl font-bold">
                    <p>Subtotal</p>
                    <p class="whitespace-nowrap pl-3">₱ {{number_format($subtotal, 2, '.', ',')}}</p>
                </div>
                <div class="w-full flex justify-between text-2xl font-bold">
                    <p>Discount</p>
                    <p class="whitespace-nowrap pl-3">₱ {{number_format($discount, 2, '.', ',')}}</p>
                </div>
                <div class="w-full flex justify-between text-3xl font-bold">
                    <p>TOTAL</p>
                    <p class="whitespace-nowrap pl-3">₱ {{number_format($trans->total, 2, '.', ',')}}</p>
                </div>
            </div>
        </div>

        <div class="font-semibold text-3xl mt-10">{{ $settings->footer }}</div>
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