<x-app-layout>
    @section('page_title', 'REPORTS')

    {{-- PAY MODAL --}}
        <!-- Main modal -->
        <div id="payModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
            <div class="relative w-full h-full max-w-2xl md:h-auto">
                <!-- Modal content -->
                <div class="absolute w-full max-w-md -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow top-1/2 left-1/2">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between px-4 py-2 border-b rounded-t">
                        <h3 class="flex items-center font-semibold text-gray-900">
                            <span class="text-base text-green-500 md:text-lg lg:text-xl">Mark as Paid</span>
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="payModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="px-6 py-6">
                        @csrf
                        <p class="text-xs leading-relaxed text-gray-500 md:text-base">
                            <h1 id="payName" class="pb-5 text-xl font-bold"></h1>
                            <div class="mb-6">
                                <label for="quantity" class="block text-sm font-medium text-gray-900">Quantity</label>
                                <h1 id="payQuantity" class="pb-2 text-lg font-bold"></h1>
                            </div>
                            <div class="mb-6">
                                <label for="price" class="block text-sm font-medium text-gray-900">Amount</label>
                                <h1 id="payPrice" class="pb-2 text-lg font-bold"></h1>
                            </div>
                            <div class="mb-6">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Date</label>
                                <div class="relative max-w-sm">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                      <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <input datepicker type="text" id="payDate" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Select date">
                                  </div>
                            </div>
                        </p>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center px-6 py-3 space-x-2 border-t border-gray-200 rounded-b">
                        <button type="button" data-modal-hide="payModal" class="paySubmit w-32 text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Mark as Paid</button>
                        <button data-modal-hide="payModal" type="button" class="w-24 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- PAY MODAL END --}}

    {{-- EDIT MODAL --}}
        <!-- Main modal -->
        <div id="editModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
            <div class="relative w-full h-full max-w-2xl md:h-auto">
                <!-- Modal content -->
                <div class="absolute w-full max-w-md -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow top-1/2 left-1/2">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between px-4 py-2 border-b rounded-t">
                        <h3 class="flex items-center font-semibold text-gray-900">
                            <span class="text-base text-blue-700 md:text-lg lg:text-xl">Edit</span>
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="editModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="px-6 py-6">
                        @csrf
                        <p class="text-xs leading-relaxed text-gray-500 md:text-base">
                            <h1 class="pb-5 text-xl font-bold editName"></h1>
                            <div class="mb-6 nameDiv">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Item Name</label>
                                <div class="flex items-center">
                                    <input type="text" id="name" class="editName bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required autocomplete="off">
                                </div>
                            </div>
                            @if ($category != 'sales')
                                <div class="mb-6">
                                    <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900">Quantity</label>
                                    <div class="flex items-center">
                                        <input type="text" id="editQuantity" class="inputNumber bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required autocomplete="off">
                                        <span id="addUnit" class="px-3 text-base font-bold text-gray-600"></span>
                                    </div>
                                </div>
                            @endif
                            <div class="mb-6">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900">{{ ($category == 'sales' ? 'Amount' : 'Price') }}</label>
                                <div class="flex items-center">
                                    <span class="px-3 text-base font-bold text-gray-600">₱</span>
                                    <input type="text" id="editPrice" class="inputNumber bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required autocomplete="off">
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Date</label>
                                <input type="datetime-local" id="editDate" value="{{ date('Y-m-d\TH:i') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>

                                {{-- <div class="relative max-w-sm">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                      <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <input datepicker type="text" id="editDate" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Select date">
                                </div> --}}
                            </div>
                        </p>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center px-6 py-3 space-x-2 border-t border-gray-200 rounded-b">
                        <button type="button" data-modal-hide="editModal" class="editSubmit w-24 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
                        <button data-modal-hide="editModal" type="button" class="w-24 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- EDIT MODAL END --}}

    {{-- DELETE MODAL --}}
        <!-- Main modal -->
        <div id="deleteModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
            <div class="relative w-full h-full max-w-2xl md:h-auto">
                <!-- Modal content -->
                <div class="absolute w-full max-w-md -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow top-1/2 left-1/2">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between px-4 py-2 border-b rounded-t">
                        <h3 class="flex items-center font-semibold text-gray-900">
                            <i class="mr-2 text-xl text-red-700 uil uil-exclamation-triangle md:text-2xl lg:text-3xl"></i>
                            <span class="text-base text-red-700 md:text-lg lg:text-xl">Delete Item</span>
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="deleteModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="px-6 py-3 space-y-6 md:py-6">
                        <p class="text-xs leading-relaxed text-gray-500 md:text-base">
                            Are you sure you want to delete this?
                        </p>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center px-6 py-3 space-x-2 border-t border-gray-200 rounded-b">
                        <button type="button" data-modal-hide="deleteModal" class="deleteSubmit w-24 text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Yes</button>
                        <button data-modal-hide="deleteModal" type="button" class="w-24 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- DELETE MODAL END --}}
    
    <div class="p-3 lg:pt-3 {{ (Auth::user()->role == 2) ? '' : ' lg:ml-64' }}">
        <div id="contentDiv" class="w-full p-2">
            <div class="p-4 overflow-hidden bg-white rounded-lg shadow-md">
                {{-- CONTROLS --}}
                    <div class="mb-3">
                        <div class="flex justify-between">
                            <div class="w-32">
                                <a href="{{ route('areport.index') }}" class="hidden md:block text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-semibold rounded-lg text-sm px-5 py-2.5 focus:outline-none my-px text-center"><i class="mr-1 uil uil-arrow-left"></i>BACK</a>
                            </div>
                            <div class="w-32">
                                <a href="{{ url('/report/print/'.$startDate.'/'.$endDate.'/'.$category.'/'.$report) }}" target="_blank" class="hidden md:block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 focus:outline-none my-px text-center"><i class="mr-1 uil uil-print"></i>PRINT</a>
                            </div>
                        </div>
                    </div>
                {{-- CONTROLS END --}}

                <div>
                    <div class="flex justify-between mt-4">
                        @php
                            if($category == 'sales'){
                                $ncat = 'Sales Transaction Logs';
                            }else if($category == 'expenses'){
                                if($report == 'unpaid'){
                                    $ncat = 'Unpaid Expenses';
                                }else{
                                    $ncat = 'Expenses Transaction Logs';
                                }
                            }else if($category == 'inventory'){
                                if ($report == 'logs') {
                                    $ncat = 'Inventory Outgoing Logs';
                                }else{
                                    $ncat = 'Inventory Stocks Report';
                                }
                            }else if($category == 'menu'){
                                if ($report == 'rank') {
                                    $ncat = 'Menu Rankings';
                                }else{
                                    $ncat = 'Menu Current Stock';
                                }
                            }else if($category == 'invmenu'){
                                if ($report == 'summary') {
                                    $ncat = 'Inventory Summary';
                                }
                            }else if($category == 'waste'){
                                if ($report == 'raw') {
                                    $ncat = 'Raw Inventory Waste';
                                }else{
                                    $ncat = 'Menu Waste';
                                }
                            }else if($category == 'remit'){
                                $ncat = 'Remittance Report';
                            }
                        @endphp
                        <h1 class="text-xl lg:text-3xl">{{ $ncat }}</h1>
                        <h1 class="flex items-center">{{ date('M j, Y h:i A', strtotime($startDate)).' - '.date('M j, Y h:i A', strtotime($endDate)) }}</h1>
                    </div>
                    {{-- TABLE --}}
                        <div class="block">
                            <div id="inventoryTable" class="w-full overflow-auto shadow-md sm:rounded-lg">
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
                                                <th class="px-6 text-center">
                                                    Cashier
                                                </th>
                                                @if (Auth::user()->role == 1)
                                                    <th class="px-6 text-center">
                                                        Action
                                                    </th>
                                                @endif
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
                                                @if($report != 'unpaid')
                                                    <th class="px-6 text-center">
                                                        Status
                                                    </th>
                                                @endif
                                                <th class="px-6 text-center">
                                                    Cashier Name
                                                </th>
                                                @if($report == 'unpaid')
                                                    <th class="px-6 text-center">
                                                        Action
                                                    </th>
                                                @endif
                                                @if ($report != 'unpaid' && Auth::user()->role == 1)
                                                    <th class="px-6 text-center">
                                                        Action
                                                    </th>
                                                @endif
                                            @elseif($category == 'waste')
                                                <th class="px-6 text-center">
                                                    Date
                                                </th>
                                                <th class="px-6 text-center">
                                                    Name
                                                </th>
                                                <th class="px-6 text-center">
                                                    Quantity
                                                </th>
                                                <th class="px-6 text-center">
                                                    Cost
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
                                            @elseif($category == 'menu')
                                                @if ($report == 'rank')
                                                    <th class="px-6 text-center">
                                                        #
                                                    </th>
                                                    <th class="px-6 text-center">
                                                        Menu
                                                    </th>
                                                    <th class="px-6 text-center">
                                                        Total Served
                                                    </th>
                                                @else
                                                    <th class="px-6 text-center">
                                                        Menu
                                                    </th>
                                                    <th class="px-6 text-center">
                                                        Category
                                                    </th>
                                                    <th class="px-6 text-center">
                                                        Current Stock
                                                    </th>
                                                @endif
                                            @elseif($category == 'invmenu')
                                                @if ($report == 'summary')
                                                    <th class="px-6 text-center">
                                                        Menu
                                                    </th>
                                                    <th class="px-6 text-center">
                                                        Category
                                                    </th>
                                                    <th class="px-6 text-center">
                                                        Current Stock
                                                    </th>
                                                @endif
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $x = 1;
                                            $total = 0;
                                        @endphp
                                        @foreach ($results as $result)
                                            @php
                                                if($category == 'waste'){
                                                    $total = $total +  $result->cost;
                                                }
                                            @endphp
                                            <tr class="border-b">
                                                @if ($category == 'sales')
                                                    <th class="px-6 py-1 font-medium text-center text-gray-900 whitespace-nowrap">
                                                        {{ date('F j, Y h:i A', strtotime($result->created_at)) }}
                                                    </th>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        {{ $result->number }}
                                                    </td>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        ₱ {{ number_format($result->total, 2, '.', ',') }}
                                                    </td>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        {{ $result->mode_of_payment }}
                                                    </td>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        {{ $result->thisCashier->name }}
                                                    </td>
                                                    @if (Auth::user()->role == 1)
                                                        <td class="px-6 py-1 font-bold text-center whitespace-nowrap">
                                                            <button data-id="{{ $result->id }}" data-name="{{ $result->number }}" data-amount="{{ $result->total }}" data-date="{{ $result->created_at }}" data-category="{{ $category }}" data-modal-show="editModal" data-modal-target="editModal" class="text-blue-500 actionButton hover:underline">Edit</button>
                                                            <span class="px-2">|</span>
                                                            <button data-id="{{ $result->id }}" data-category="{{ $category }}" data-modal-show="deleteModal" data-modal-target="deleteModal" class="text-red-500 actionButton hover:underline">Delete</button>
                                                        </td>
                                                    @endif
                                                @elseif($category == 'expenses')
                                                    <th class="px-6 py-1 font-medium text-center text-gray-900 whitespace-nowrap">
                                                        {{ date('F j, Y h:i A', strtotime($result->created_at)) }}
                                                    </th>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        @php
                                                            if($result->inv_id != 0){
                                                                $iname = $result->inv->name;
                                                            }else{
                                                                $iname = $result->remarks;
                                                            }
                                                        @endphp
                                                        {{ $iname }}
                                                    </td>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        ₱ {{ number_format($result->amount, 2, '.', ',') }}
                                                    </td>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        {{ $result->quantity }}
                                                    </td>
                                                    @if ($report != 'unpaid')
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            @php
                                                                if($result->is_paid == 1 ){
                                                                    $ip = 'PAID';
                                                                }else{
                                                                    $ip = 'UNPAID';
                                                                }
                                                            @endphp
                                                            {{ $ip }}
                                                        </td>
                                                    @endif
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        {{ $result->user->name }}
                                                    </td>
                                                    @if ($report == 'unpaid')
                                                        <td class="px-6 py-1 font-bold text-center whitespace-nowrap">
                                                            <button data-id="{{ $result->id }}" data-name="{{ $iname }}" data-amount="{{ $result->amount }}" data-quantity="{{ $result->quantity }}" data-date="{{ date('m/d/Y') }}" data-category="{{ $category }}" data-modal-show="payModal" data-modal-target="payModal" class="text-green-500 actionButton hover:underline">Mark as Paid</button>
                                                        </td>
                                                    @endif
                                                    @if ($report != 'unpaid' && Auth::user()->role == 1)
                                                        <td class="px-6 py-1 font-bold text-center whitespace-nowrap">
                                                            <button data-id="{{ $result->id }}" data-inv_id="{{ $result->inv_id }}" data-name="{{ $iname }}" data-amount="{{ $result->amount }}" data-quantity="{{ $result->quantity }}" data-date="{{ $result->created_at }}" data-category="{{ $category }}" data-modal-show="editModal" data-modal-target="editModal" class="text-blue-500 actionButton hover:underline">Edit</button>
                                                            <span class="px-2">|</span>
                                                            <button data-id="{{ $result->id }}" data-category="{{ $category }}" data-modal-show="deleteModal" data-modal-target="deleteModal" class="text-red-500 actionButton hover:underline">Delete</button>
                                                        </td>
                                                    @endif
                                                @elseif($category == 'inventory')
                                                    @if ($report == 'logs')
                                                        <th class="px-6 py-1 font-medium text-center text-gray-900 whitespace-nowrap">
                                                            {{ date('F j, Y h:i A', strtotime($result->created_at)) }}
                                                        </th>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ $result->inv->name }}
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
                                                            {{ $result->name }}
                                                        </td>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ $result->category->name }}
                                                        </td>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ round($result->quantity,2) }}
                                                        </td>
                                                    @endif
                                                @elseif($category == 'menu')
                                                    @if ($report == 'rank')
                                                        <th class="px-6 py-1 font-medium text-center text-gray-900 whitespace-nowrap">
                                                            {{ $x++ }}
                                                        </th>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ $result->name }}
                                                        </td>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ round($result->quantity, 0) }}
                                                        </td>
                                                    @else
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ $result->name }}
                                                        </td>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ $result->category->name }}
                                                        </td>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ round($result->quantity, 0) }}
                                                        </td>
                                                    @endif
                                                @elseif($category == 'invmenu')
                                                    @if ($report == 'summary')
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ $result->name }}
                                                        </td>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ $result->category }}
                                                        </td>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            {{ round($result->quantity, 0) }}
                                                        </td>
                                                    @endif
                                                @elseif($category == 'waste')
                                                    <th class="px-6 py-1 font-medium text-center text-gray-900 whitespace-nowrap">
                                                        {{ date('F j, Y h:i A', strtotime($result->created_at)) }}
                                                    </th>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        {{ $result->name }}
                                                    </td>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        {{ $result->quantity }}
                                                    </td>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        ₱ {{ number_format($result->cost, 2, '.', ',') }}
                                                    </td>
                                                @elseif($category == 'remit')
                                                    <td class="px-6 py-1 text-center whitespace-nowrap {{ ($result->name == 'Total') ? 'text-lg font-bold text-gray-600' : '' }}">
                                                        {{ strtoupper($result->name) }}
                                                    </td>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap {{ ($result->name == 'Total') ? 'text-lg font-bold text-gray-600' : '' }}">
                                                        ₱ {{ number_format($result->amount, 2, '.', ',') }}
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($category == 'waste')
                                    <table class="w-full">
                                        <tr>
                                            <th class="px-6 py-1 font-medium text-center text-gray-900 whitespace-nowrap">
                                                Total
                                            </th>
                                            <td class="px-6 py-1 text-center whitespace-nowrap">
                                                ₱ {{ number_format($resultsCount, 2, '.', ',') }}
                                            </td>
                                        </tr>
                                    </table>
                                @endif
                            </div>
                        </div>
                    {{-- TABLE END --}}
                </div>
            </div>
        </div>
     </div>

    <script>
        $(document).ready(function() {
            var id;
            var category;
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

            $('.actionButton').click(function(){
                id = $(this).data('id');
                inv_id = $(this).data('inv_id');
                category = $(this).data('category');
                var name = $(this).data('name');
                var amount = $(this).data('amount');
                var date = $(this).data('date');

                $('.nameDiv').addClass('hidden');

                if(category != 'sales'){
                    var quantity = $(this).data('quantity');
                    $('#editQuantity').val(quantity);

                    $('#payName').html(name);
                    $('#payPrice').html(amount);
                    $('#payQuantity').html(quantity);
                    $('#payDate').val(date);

                    if(inv_id == 0){
                        $('.nameDiv').removeClass('hidden');
                    }
                }

                $('.editName').html(name);
                $('.editName').val(name);
                $('#editPrice').val(amount);
                $('#editDate').val(date);
            });

            $('.paySubmit').click(function(){
                var date = $('#payDate').val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url:"{{ route('payExpenses') }}",
                    method:"POST",
                    data:{
                        id: id,
                        date: date,
                        _token: _token
                    },
                    success:function(result){
                        alert(result);
                        location.reload();
                    }
                })
            });

            $('.editSubmit').click(function(){
                var name = $('#name').val();
                var amount = $('#editPrice').val();
                var date = $('#editDate').val();
                var _token = $('input[name="_token"]').val();

                if(category != 'sales'){
                    var quantity = $('#editQuantity').val();
                    var route = "{{ route('updateExpenses') }}";
                }else{
                    var route = "{{ route('updateSales') }}";
                }

                $.ajax({
                    url: route,
                    method:"POST",
                    data:{
                        id: id,
                        name: name,
                        amount: amount,
                        quantity: quantity,
                        date: date,
                        _token: _token
                    },
                    success:function(result){
                        alert(result);
                        location.reload();
                    }
                })
            });

            $('.deleteSubmit').click(function(){
                var _token = $('input[name="_token"]').val();

                if(category != 'sales'){
                    var route = "{{ route('deleteExpenses') }}";
                }else{
                    var route = "{{ route('deleteSales') }}";
                }

                $.ajax({
                    url: route,
                    method:"POST",
                    data:{
                        id: id,
                        _token: _token
                    },
                    success:function(result){
                        alert(result);
                        location.reload();
                    }
                })
            });
        });
    </script>
</x-app-layout>
