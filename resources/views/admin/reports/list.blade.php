<x-app-layout>
    @section('page_title', 'REPORTS')
    
    <div class="p-3 lg:pt-3 {{ (Auth::user()->role == 2) ? '' : ' lg:ml-64' }}">
        <div id="contentDiv" class="p-2 w-full">
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-4">
                {{-- CONTROLS --}}
                    <div class="mb-3">
                        <div class="flex justify-between">
                            <div class="w-32">
                                <a href="{{ route('areport.index') }}" class="hidden md:block text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-semibold rounded-lg text-sm px-5 py-2.5 focus:outline-none my-px text-center"><i class="uil uil-arrow-left mr-1"></i>BACK</a>
                            </div>
                            <div class="w-32">
                                <a href="{{ url('/report/print/'.$startDate.'/'.$endDate.'/'.$category.'/'.$report) }}" target="_blank" class="hidden md:block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 focus:outline-none my-px text-center"><i class="uil uil-print mr-1"></i>PRINT</a>
                            </div>
                        </div>
                    </div>
                {{-- CONTROLS END --}}

                <div>
                    <div class="mt-4 flex justify-between">
                        @php
                            if($category == 'sales'){
                                $ncat = 'Sales Transaction Logs';
                            }else if($category == 'expenses'){
                                $ncat = 'Expenses Transaction Logs';
                            }else if($category == 'inventory'){
                                if ($report == 'logs') {
                                    $ncat = 'Inventory Outgoing Logs';
                                }else{
                                    $ncat = 'Inventory Stocks Report';
                                }
                            }
                        @endphp
                        <h1 class="text-xl lg:text-3xl">{{ $ncat }}</h1>
                        <h1 class="flex items-center">{{ date('M j, Y', strtotime($startDate)).' - '.date('M j, Y', strtotime('-1 day', strtotime($endDate))) }}</h1>
                    </div>
                    {{-- TABLE --}}
                        <div class="hidden md:block">
                            <div id="inventoryTable" class="overflow-auto w-full shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr class="border-b">
                                            @if ($category == 'sales')
                                                <th class="px-6 text-center">
                                                    Date
                                                </th>
                                                <th class="px-6 text-center">
                                                    Transaction Number
                                                </th>
                                                <th class="px-6 text-center">
                                                    Amount
                                                </th>
                                                <th class="px-6 text-center">
                                                    Mode of Payment
                                                </th>

                                            @elseif($category == 'expenses')
                                                <th class="px-6 text-center">
                                                    Date
                                                </th>
                                                <th class="px-6 text-center">
                                                    Item Name
                                                </th>
                                                <th class="px-6 text-center">
                                                    Amount
                                                </th>
                                                <th class="px-6 text-center">
                                                    Quantity
                                                </th>

                                            @elseif($category == 'inventory')
                                                @if ($report == 'logs')
                                                    <th class="px-6 text-center">
                                                        Date
                                                    </th>
                                                    <th class="px-6 text-center">
                                                        Item Name
                                                    </th>
                                                    <th class="px-6 text-center">
                                                        Quantity Before
                                                    </th>
                                                    <th class="px-6 text-center">
                                                        Quantity
                                                    </th>
                                                    <th class="px-6 text-center">
                                                        Quantity After
                                                    </th>
                                                    <th class="px-6 text-center">
                                                        Remarks
                                                    </th>
                                                @else
                                                    <th class="px-6 text-left">
                                                        Item Name
                                                    </th>
                                                    <th class="px-6 text-center">
                                                        Category
                                                    </th>
                                                    <th class="px-6 text-center">
                                                        Quantity
                                                    </th>
                                                @endif
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $result)
                                            <tr class="border-b">
                                                @if ($category == 'sales')
                                                    <th class="px-6 py-1 text-center font-medium text-gray-900 whitespace-nowrap">
                                                        {{ date('F j, Y h:i A', strtotime($result->date)) }}
                                                    </th>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        {{ $result->nn }}
                                                    </td>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        ₱ {{ number_format($result->amount, 2, '.', ',') }}
                                                    </td>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        {{ $result->mode_of_payment }}
                                                    </td>
                                                @elseif($category == 'expenses')
                                                    <th class="px-6 py-1 text-center font-medium text-gray-900 whitespace-nowrap">
                                                        {{ date('F j, Y h:i A', strtotime($result->date)) }}
                                                    </th>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        @if ($result->inv_id != 0)
                                                            {{ $result->nn }}
                                                        @else
                                                            {{ $result->remarks }}
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        ₱ {{ number_format($result->amount, 2, '.', ',') }}
                                                    </td>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        {{ $result->quantity }}
                                                    </td>
                                                @elseif($category == 'inventory')
                                                    @if ($report == 'logs')
                                                        <th class="px-6 py-1 text-center font-medium text-gray-900 whitespace-nowrap">
                                                            {{ date('F j, Y h:i A', strtotime($result->date)) }}
                                                        </th>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ $result->nn }}
                                                        </td>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ round($result->quantity_before,2) }}
                                                        </td>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ round($result->quantity,2) }}
                                                        </td>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ round($result->quantity_after,2) }}
                                                        </td>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ $result->remarks }}
                                                        </td>
                                                    @else
                                                        <td class="px-6 py-1 text-left whitespace-nowrap">
                                                            {{ $result->nn }}
                                                        </td>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ $result->cn }}
                                                        </td>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ round($result->quantity,2) }}
                                                        </td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    {{-- TABLE END --}}

                    {{-- INVENTORY LIST SMALL DEVICE --}}
                        <div id="inventoryMobile" class="overflow-auto md:hidden">
                            <div id="accordion-collapse" data-accordion="collapse">
                                @php
                                    $x = 1;
                                    foreach ($results as $result) {
                                        if($category == 'sales'){
                                            echo '
                                                <h2 id="accordion-collapse-heading-'.$x.'">
                                                    <button type="button" class="flex items-center justify-between w-full px-3 py-1.5 text-sm font-semibold text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl hover:bg-gray-100" data-accordion-target="#accordion-collapse-body-'.$x.'" aria-expanded="false" aria-controls="accordion-collapse-body-'.$x.'">
                                                        <span>'.$result->nn.'</span>
                                                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                    </button>
                                                </h2>
                                                <div id="accordion-collapse-body-'.$x.'" class="hidden" aria-labelledby="accordion-collapse-heading-'.$x.'">
                                                    <div class="px-3 py-1.5 font-light border border-b-0 border-gray-200">
                                                        <div class="grid grid-cols-3">
                                                            <div class="text-xs leading-5">Date</div>
                                                            <div class="col-span-2 font-semibold text-sm">
                                                                '.date('Y-m-d', strtotime($result->date)).'
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-3">
                                                            <div class="text-xs leading-5">Amount</div>
                                                            <div class="col-span-2 font-semibold text-sm">
                                                                ₱ '.round($result->amount, 2).'
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-3">
                                                            <div class="text-xs leading-5">Mode of Payment</div>
                                                            <div class="col-span-2 font-semibold text-sm">
                                                                '.$result->mode_of_payment.'
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ';
                                        }else if($category == 'expenses'){
                                            echo '
                                                <h2 id="accordion-collapse-heading-'.$x.'">
                                                    <button type="button" class="flex items-center justify-between w-full px-3 py-1.5 text-sm font-semibold text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl hover:bg-gray-100" data-accordion-target="#accordion-collapse-body-'.$x.'" aria-expanded="false" aria-controls="accordion-collapse-body-'.$x.'">
                                                        <span>'.$result->nn.'</span>
                                                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                    </button>
                                                </h2>
                                                <div id="accordion-collapse-body-'.$x.'" class="hidden" aria-labelledby="accordion-collapse-heading-'.$x.'">
                                                    <div class="px-3 py-1.5 font-light border border-b-0 border-gray-200">
                                                        <div class="grid grid-cols-3">
                                                            <div class="text-xs leading-5">Date</div>
                                                            <div class="col-span-2 font-semibold text-sm">
                                                                '.date('Y-m-d', strtotime($result->date)).'
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-3">
                                                            <div class="text-xs leading-5">Amount</div>
                                                            <div class="col-span-2 font-semibold text-sm">
                                                                ₱ '.round($result->amount, 2).'
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-3">
                                                            <div class="text-xs leading-5">Quantity</div>
                                                            <div class="col-span-2 font-semibold text-sm">
                                                                '.$result->quantity.'
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ';
                                        }else if($category == 'inventory'){
                                            if($report == 'logs'){
                                                echo '
                                                    <h2 id="accordion-collapse-heading-'.$x.'">
                                                        <button type="button" class="flex items-center justify-between w-full px-3 py-1.5 text-sm font-semibold text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl hover:bg-gray-100" data-accordion-target="#accordion-collapse-body-'.$x.'" aria-expanded="false" aria-controls="accordion-collapse-body-'.$x.'">
                                                            <span>'.$result->nn.'</span>
                                                            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                        </button>
                                                    </h2>
                                                    <div id="accordion-collapse-body-'.$x.'" class="hidden" aria-labelledby="accordion-collapse-heading-'.$x.'">
                                                        <div class="px-3 py-1.5 font-light border border-b-0 border-gray-200">
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Date</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    '.date('F j, Y h:i A', strtotime($result->date)).'
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Quantity Before</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    '.round($result->quantity_before, 2).'
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Quantity</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    '.round($result->quantity, 2).'
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Quantity After</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    '.round($result->quantity_after, 2).'
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Remarks</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    '.$result->remarks.'
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ';
                                            }else{
                                                echo '
                                                    <h2 id="accordion-collapse-heading-'.$x.'">
                                                        <button type="button" class="flex items-center justify-between w-full px-3 py-1.5 text-sm font-semibold text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl hover:bg-gray-100" data-accordion-target="#accordion-collapse-body-'.$x.'" aria-expanded="false" aria-controls="accordion-collapse-body-'.$x.'">
                                                            <span>'.$result->nn.'</span>
                                                            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                        </button>
                                                    </h2>
                                                    <div id="accordion-collapse-body-'.$x.'" class="hidden" aria-labelledby="accordion-collapse-heading-'.$x.'">
                                                        <div class="px-3 py-1.5 font-light border border-b-0 border-gray-200">
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Category</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    '.$result->cn.'
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Quantity</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    '.round($result->quantity, 2).'
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ';
                                            }
                                        }
                                    $x++;
                                    }
                                @endphp
                            </div>
                        </div>
                    {{-- INVENTORY LIST SMALL DEVICE END --}}
                </div>

                {{-- PAGINATION --}}
                    {{-- <div class="grid md:grid-cols-2 mt-3 px-3">
                        @php
                            $prev = $page - 1;
                            $next = $page + 1;
                            $from = ($prev * 100) + 1;
                            $to = $page * 100;
                            if($to > $resultsCount){
                                $to = $resultsCount;
                            }if($resultsCount == 0){
                                $from = 0;
                            }
                        @endphp
                        <div class="justify-self-center md:justify-self-start self-center">
                            <span class="text-sm text-gray-700">
                                Showing <span class="font-semibold text-gray-900">{{ $from }}</span> to <span class="font-semibold text-gray-900">{{ $to }}</span> of <span class="font-semibold text-gray-900">{{ $resultsCount }}</span> Items
                            </span>
                        </div>

                        <div class="justify-self-center md:justify-self-end">
                            <nav aria-label="Page navigation example" class="h-8 mb-0.5 shadow-xl">
                                <ul class="inline-flex items-center -space-x-px">
                                    <li>
                                        <a href="{{ ($search == '') ? url('/system-management/user/'.$prev) : url('/system-management/user/'.$prev.'/'.$search);  }}"  class="{{ ($page == 1) ? 'pointer-events-none' : ''; }} block w-9 h-9 leading-9 text-center text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
                                            <i class="uil uil-angle-left-b"></i>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    <li>
                                        <p class="block w-9 h-9 leading-9 text-center z-10 text-gray-500 border border-gray-300 bg-white font-semibold">{{ $page }}</p>
                                    </li>
                                    <li>
                                        <a href="{{ ($search == '') ? url('/system-management/user/'.$next) : url('/system-management/user/'.$next.'/'.$search); }}" class="{{ ($to == $resultsCount) ? 'pointer-events-none' : ''; }} block w-9 h-9 leading-9 text-center text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                                            <i class="uil uil-angle-right-b"></i>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div> --}}
                {{-- PAGINATION END --}}


            </div>
        </div>
     </div>

    <script>
        $(document).ready(function() {
            $('#navButton').click(function(){
                    $('#topNav').addClass('absolute');
                    $('#topNav').removeClass('sticky');
                    $('#contentDiv').addClass('pt-14');
                });

            $(document).mouseup(function(e) {
                var container = $(".navDiv");

                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    $('#topNav').removeClass('absolute');
                    $('#topNav').addClass('sticky');
                $('#contentDiv').removeClass('pt-14');
                }
            });
        });
    </script>
</x-app-layout>
