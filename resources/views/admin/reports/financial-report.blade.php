<x-app-layout>
    @section('page_title', 'REPORTS')


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
                        <div class="text-xs leading-relaxed text-gray-500 md:text-base">
                            <div class="mb-6">
                                <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Date</label>
                                <h1 id="editDate"></h1>
                            </div>
                            <div class="mb-6">
                                <label for="liquid_cash" class="block mb-2 text-sm font-medium text-gray-900">Liquid Cash</label>
                                <div class="flex items-center">
                                    <input type="text" id="liquid_cash" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 numbersOnly" required autocomplete="off">
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="cash_on_hand" class="block mb-2 text-sm font-medium text-gray-900">Cash on Hand</label>
                                <div class="flex items-center">
                                    <input type="text" id="cash_on_hand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 numbersOnly" required autocomplete="off">
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="gcash" class="block mb-2 text-sm font-medium text-gray-900">GCash</label>
                                <div class="flex items-center">
                                    <input type="text" id="gcash" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 numbersOnly" required autocomplete="off">
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="bank" class="block mb-2 text-sm font-medium text-gray-900">Bank</label>
                                <div class="flex items-center">
                                    <input type="text" id="bank" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 numbersOnly" required autocomplete="off">
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="pending_remit" class="block mb-2 text-sm font-medium text-gray-900">Pending Remit</label>
                                <div class="flex items-center">
                                    <input type="text" id="pending_remit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 numbersOnly" required autocomplete="off">
                                </div>
                            </div>
                        </div>
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
                            <div></div>
                            <button data-modal-show="editModal" data-modal-target="editModal" class="hidden text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-semibold rounded-lg text-sm px-5 py-2.5 focus:outline-none my-px text-center openEditModal"></i>ADD</button>
                            <div class="flex gap-x-4">
                                <div>
                                    <label for="month">Month:</label>
                                    <select id="month" name="month" class="pl-2 pr-5 rounded-lg">
                                        <option {{ ($month == '01') ? 'selected' : '' }} value="01">January</option>
                                        <option {{ ($month == '02') ? 'selected' : '' }} value="02">February</option>
                                        <option {{ ($month == '03') ? 'selected' : '' }} value="03">March</option>
                                        <option {{ ($month == '04') ? 'selected' : '' }} value="04">April</option>
                                        <option {{ ($month == '05') ? 'selected' : '' }} value="05">May</option>
                                        <option {{ ($month == '06') ? 'selected' : '' }} value="06">June</option>
                                        <option {{ ($month == '07') ? 'selected' : '' }} value="07">July</option>
                                        <option {{ ($month == '08') ? 'selected' : '' }} value="08">August</option>
                                        <option {{ ($month == '09') ? 'selected' : '' }} value="09">September</option>
                                        <option {{ ($month == '10') ? 'selected' : '' }} value="10">October</option>
                                        <option {{ ($month == '11') ? 'selected' : '' }} value="11">November</option>
                                        <option {{ ($month == '12') ? 'selected' : '' }} value="12">December</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="year">Year:</label>
                                    <input type="number" id="year" name="year" min="1900" max="2999" step="1" value="{{ $year }}" class="px-2 rounded-lg">
                                </div>
                                <div>
                                    <button data-modal-show="addModal" data-modal-target="addModal" class="hidden md:block text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-semibold rounded-lg text-sm px-5 py-2.5 focus:outline-none my-px text-center"></i>Generate</button>
                                </div>
                            </div>
                            {{-- <div class="w-32">
                                <a href="{{ url('/report/print/'.$startDate.'/'.$endDate.'/'.$category.'/'.$report) }}" target="_blank" class="hidden md:block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 focus:outline-none my-px text-center"><i class="mr-1 uil uil-print"></i>PRINT</a>
                            </div> --}}
                        </div>
                    </div>
                {{-- CONTROLS END --}}

                <div>
                    <div class="flex justify-between mt-4">
                        <h1 class="text-xl lg:text-3xl">Financial Report</h1>
                        {{-- <h1 class="flex items-center">{{ date('M j, Y h:i A', strtotime($startDate)).' - '.date('M j, Y h:i A', strtotime($endDate)) }}</h1> --}}
                    </div>
                    {{-- TABLE --}}
                        <div class="block">
                            <div id="inventoryTable" class="w-full overflow-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr class="border-b">
                                            <th class="px-6 text-center">
                                                Action
                                            </th>
                                            <th class="px-6 text-center">
                                                Date
                                            </th>
                                            <th class="px-6 text-center">
                                                Sales
                                            </th>
                                            <th class="px-6 text-center">
                                                Expenses
                                            </th>
                                            <th class="px-6 text-center">
                                                Profit/Loss
                                            </th>
                                            <th class="px-6 text-center">
                                                Liquid Cash
                                            </th>
                                            <th class="px-6 text-center">
                                                Cash on Hand
                                            </th>
                                            <th class="px-6 text-center">
                                                GCash
                                            </th>
                                            <th class="px-6 text-center">
                                                Bank
                                            </th>
                                            <th class="px-6 text-center">
                                                Pending Remit
                                            </th>
                                            <th class="px-6 text-center">
                                                Account Payable
                                            </th>
                                            <th class="px-6 text-center">
                                                Variance
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 1; $i <= $lastDay; $i++)
                                            @php
                                                $textColor = "";
                                                $totalSales = 0;
                                                $totalExpenses = 0;
                                                
                                                $liquid_cash = 0;
                                                $cash_on_hand = 0;
                                                $gcash = 0;
                                                $bank = 0;
                                                $pending_remit = 0;
                                                $account_payable = 0;
                                                $variance = 0;

                                                foreach ($sales as $sale) {
                                                    if($sale->date == date('Y-m-d', strtotime($year.'-'.$month.'-'.$i))){
                                                        $totalSales = $sale->total_per_day;
                                                        break;
                                                    }
                                                }

                                                foreach ($expenses as $expense) {
                                                    if($expense->date == date('Y-m-d', strtotime($year.'-'.$month.'-'.$i))){
                                                        $totalExpenses = $expense->total_per_day;
                                                        break;
                                                    }
                                                }

                                                $profitLoss = $totalSales - $totalExpenses;
                                                if($profitLoss > 0){
                                                    $textColor = "text-emerald-500";
                                                }elseif($profitLoss < 0){
                                                    $textColor = "text-red-500";
                                                }
                                                



                                                foreach ($actuals as $actual) {
                                                    if($actual->date == date('Y-m-d', strtotime($year.'-'.$month.'-'.$i))){
                                                        $liquid_cash = $actual->liquid_cash;
                                                        $cash_on_hand = $actual->cash_on_hand;
                                                        $gcash = $actual->gcash;
                                                        $bank = $actual->bank;
                                                        $pending_remit = $actual->pending_remit;
                                                        
                                                        foreach ($account_payables as $account_payable_row) {
                                                            if($account_payable_row->date == date('Y-m-d', strtotime($year.'-'.$month.'-'.$i))){
                                                                $account_payable = $account_payable_row->total_per_day;
                                                                break;
                                                            }
                                                        }
                                                        
                                                        $variance = $liquid_cash - ($cash_on_hand + $gcash + $bank + $pending_remit) - $account_payable;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            <tr class="border-b">
                                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                                    <button data-date="{{ date('Y-m-d', strtotime($year.'-'.$month.'-'.$i)) }}" data-sdate="{{ date('F j, Y', strtotime($year.'-'.$month.'-'.$i)) }}" class="flex items-center text-blue-500 hover:underline editButton">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="w-5 h-5" fill="currentColor">
                                                            <path d="M180-180h44l472-471-44-44-472 471v44Zm-60 60v-128l575-574q8-8 19-12.5t23-4.5q11 0 22 4.5t20 12.5l44 44q9 9 13 20t4 22q0 11-4.5 22.5T823-694L248-120H120Zm659-617-41-41 41 41Zm-105 64-22-22 44 44-22-22Z"/>
                                                        </svg>
                                                        Edit
                                                    </button>
                                                </td>
                                                <th class="px-6 py-1 font-medium text-center text-gray-900 whitespace-nowrap">
                                                    {{ date('F j, Y', strtotime($year.'-'.$month.'-'.$i)) }}
                                                </th>
                                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                                    ₱ {{ number_format($totalSales, 2, '.', ',') }}
                                                </td>
                                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                                    ₱ {{ number_format($totalExpenses, 2, '.', ',') }}
                                                </td>
                                                <td class="px-6 py-1 text-center whitespace-nowrap {{ $textColor }}">
                                                    ₱ {{ number_format($profitLoss, 2, '.', ',') }}
                                                </td>
                                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                                    ₱ {{ number_format($liquid_cash, 2, '.', ',') }}
                                                </td>
                                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                                    ₱ {{ number_format($cash_on_hand, 2, '.', ',') }}
                                                </td>
                                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                                    ₱ {{ number_format($gcash, 2, '.', ',') }}
                                                </td>
                                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                                    ₱ {{ number_format($bank, 2, '.', ',') }}
                                                </td>
                                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                                    ₱ {{ number_format($pending_remit, 2, '.', ',') }}
                                                </td>
                                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                                    ₱ {{ number_format($account_payable, 2, '.', ',') }}
                                                </td>
                                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                                    ₱ {{ number_format($variance, 2, '.', ',') }}
                                                </td>
                                            </tr>

                                            @php
                                                if($i == date('d') && $month == date('m')){
                                                    break;
                                                }
                                            @endphp
                                        @endfor
                                    </tbody>
                                </table>
                                {{-- @if($category == 'waste')
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
                                @endif --}}
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
            var _token = $('input[name="_token"]').val();

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

            jQuery(document).on( "keydown", ".numbersOnly", function(e){
                var inputValue = $(this).val();
                var key = e.key;
                if ((/[\d.]/.test(key)) || event.keyCode == 8 || event.keyCode == 46 || event.keyCode == 37 || event.keyCode == 39) {
                    if (key === '.' && inputValue.includes('.')) {
                        e.preventDefault();
                    }
                } else {
                    e.preventDefault();
                }
            });

            
            jQuery(document).on( "click", ".editButton", function(){
                var date = $(this).data('date');
                var sdate = $(this).data('sdate');
                $('#editDate').html(sdate);

                // $.ajax({
                //     url: "{{ route('getActual') }}",
                //     method:"POST",
                //     data:{
                //         date: date,
                //         liquid_cash: liquid_cash,
                //         cash_on_hand: cash_on_hand,
                //         gcash: gcash,
                //         bank: bank,
                //         pending_remit: pending_remit,
                //         _token: _token
                //     },
                //     success:function(result){
                //         alert(result);
                //         location.reload();
                //     }
                // })
            });


            jQuery(document).on( "click", ".addSubmit", function(){
                var date = $('#date').val();
                var liquid_cash = $('#liquid_cash').val();
                var cash_on_hand = $('#cash_on_hand').val();
                var gcash = $('#gcash').val();
                var bank = $('#bank').val();
                var pending_remit = $('#pending_remit').val();

                $.ajax({
                    url: "{{ route('financialReportAdd') }}",
                    method:"POST",
                    data:{
                        date: date,
                        liquid_cash: liquid_cash,
                        cash_on_hand: cash_on_hand,
                        gcash: gcash,
                        bank: bank,
                        pending_remit: pending_remit,
                        _token: _token
                    },
                    success:function(result){
                        alert(result);
                        location.reload();
                    }
                })
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
