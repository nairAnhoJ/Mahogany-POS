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
    <script src="{{asset('assets/js/jquery.js')}}"></script>
    
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
    <div class="w-screen">
        <div class="w-full px-10">
            <div class="">
                <img src="{{ asset('storage/'.$settings->logo) }}" class="h-10" alt="">
            </div>
            <div class="mt-4 flex justify-between">
                <h1 class="text-3xl">{{ ($category == 'sales') ? 'Sales' : 'Expenses' }} Transaction Logs</h1>
                <h1 class="flex items-center">{{ $startDate.' - '.$endDate }}</h1>
            </div>
            <div class="mt-3 w-full">
                <table class="w-full mt-4">
                    <thead>
                        <tr class="border-b">
                            <th class="px-6">
                                Date
                            </th>
                            @if ($category == 'sales')
                                <th class="px-6">
                                    Transaction Number
                                </th>
                            @else
                                <th class="px-6">
                                    Item Name
                                </th>
                            @endif
                            <th class="px-6">
                                Amount
                            </th>
                            @if ($category == 'sales')
                                <th class="px-6">
                                    Mode of Payment
                                </th>
                            @else
                                <th class="px-6">
                                    Quantity
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $result)
                            <tr class="border-b">
                                <th class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap">
                                    {{ date('Y-m-d', strtotime($result->date)) }}
                                </th>
                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                    {{ $result->nn }}
                                </td>
                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                    <span class="text-sm">₱</span> {{ $result->amount }}.00
                                </td>
                                @if ($category == 'sales')
                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                        {{ $result->mode_of_payment }}
                                    </td>
                                @else
                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                        {{ $result->quantity }}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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