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
    <div class="w-screen">
        <div class="w-full px-10">
            <div class="">
                <img src="{{ asset('storage/'.$settings->logo) }}" class="h-10" alt="">
            </div>
            <div class="mt-4 flex justify-between">
                <h1 class="text-3xl">Low Stock Report</h1>
            </div>
            <div class="mt-3 w-full">
                <table class="w-full mt-4">
                    <thead>
                        <tr class="border-b">
                            <th class="px-6 text-left">
                                Item Name
                            </th>
                            <th class="px-6">
                                Current Quantity
                            </th>
                            <th class="px-6">
                                Reorder Point
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventories as $inventory)
                        <tr class="border-b">
                            <th class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap text-left">
                                {{ $inventory->name }}
                            </th>
                            <td class="px-6 py-1 text-center whitespace-nowrap">
                                {{ $inventory->quantity.' '.$inventory->unit }}
                            </td>
                            <td class="px-6 py-1 text-center whitespace-nowrap">
                                {{ $inventory->reorder_point.' '.$inventory->unit }}
                            </td>
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