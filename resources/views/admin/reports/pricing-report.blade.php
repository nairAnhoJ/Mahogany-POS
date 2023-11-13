<x-app-layout>
    @section('page_title', 'REPORTS')

    {{-- LOADING --}}
        <div id="loading" class="fixed top-0 left-0 flex items-center justify-center hidden w-screen h-screen bg-opacity-50 bg-neutral-700">
            <div role="status">
                <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    {{-- LOADING END --}}

    {{-- VIEW MODAL --}}
        <!-- Main modal -->
        <div id="viewModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full h-full p-8 overflow-x-hidden overflow-y-auto md:inset-0">
            <div class="relative w-full h-full">
                <!-- Modal content -->
                <div class="absolute w-full h-full -translate-x-1/2 -translate-y-1/2 bg-white border border-gray-400 rounded-lg shadow top-1/2 left-1/2">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between px-4 py-2 border-b rounded-t">
                        <h3 class="flex items-center font-semibold text-gray-900">
                            <span id="menuName" class="text-base text-blue-700 md:text-lg lg:text-xl"></span>
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="viewModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 h-[calc(100%-116px)] w-full">
                        <div id="reportBody" class="w-full h-full">

                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center px-6 py-3 space-x-2 border-t border-gray-200 rounded-b">
                        <button data-modal-hide="viewModal" type="button" class="w-24 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Close</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- VIEW MODAL END --}}
    
    <div class="p-3 lg:pt-3 {{ (Auth::user()->role == 2) ? '' : ' lg:ml-64' }}">
        <div id="contentDiv" class="w-full p-2">
            <div class="p-4 overflow-hidden bg-white rounded-lg shadow-md">
                {{-- CONTROLS --}}
                    <button type="button" id="openViewModal" data-modal-show="viewModal" data-modal-target="viewModal" class="hidden text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-semibold rounded-lg text-sm px-5 py-2.5 focus:outline-none my-px text-center"></button>
                {{-- CONTROLS END --}}

                <div>
                    <div class="flex justify-between mt-4">
                        <h1 class="text-xl lg:text-3xl">Pricing Report</h1>
                        {{-- <h1 class="flex items-center">{{ date('M j, Y h:i A', strtotime($startDate)).' - '.date('M j, Y h:i A', strtotime($endDate)) }}</h1> --}}
                    </div>
                    {{-- TABLE --}}
                        <div class="block">
                            <div class="w-full overflow-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr class="border-b">
                                            <th class="px-6 text-center">
                                                Menu
                                            </th>
                                            <th class="px-6 text-center">
                                                Ingredient Cost
                                            </th>
                                            <th class="px-6 text-center">
                                                Number of Servings
                                            </th>
                                            <th class="px-6 text-center">
                                                Price per Servings
                                            </th>
                                            <th class="px-6 text-center bg-green-400">
                                                Selling Price
                                            </th>
                                            <th class="px-6 text-center">
                                                Additional Income
                                            </th>
                                            <th class="px-6 text-center bg-yellow-300">
                                                Price per Servings as of {{ date('F', strtotime('-1 month')) }}
                                            </th>
                                            <th class="px-6 text-center bg-yellow-300">
                                                Price per Servings as of {{ date('F', strtotime('-2 month')) }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pricingReports as $pricingReport)
                                            <tr data-id="{{ $pricingReport->id }}" data-name="{{ $pricingReport->menu }}" class="border-b cursor-pointer text-neutral-800 hover:bg-neutral-200 viewReport">
                                                <th class="px-6 py-1 font-medium text-center text-gray-900 whitespace-nowrap">
                                                    {{ $pricingReport->menu }}
                                                </th>
                                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                                    ₱ {{ number_format($pricingReport->ingredient_expense, 2, '.', ',') }}
                                                </td>
                                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                                    {{ $pricingReport->number_of_servings }}
                                                </td>
                                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                                    ₱ {{ number_format($pricingReport->price_per_servings, 2, '.', ',') }}
                                                </td>
                                                <td class="px-6 py-1 text-center bg-green-400 whitespace-nowrap">
                                                    ₱ {{ number_format($pricingReport->selling_price, 2, '.', ',') }}
                                                </td>
                                                <td class="px-6 py-1 text-center whitespace-nowrap">
                                                    ₱ {{ number_format($pricingReport->additional_income, 2, '.', ',') }}
                                                </td>
                                                <td class="px-6 py-1 text-center bg-yellow-300 whitespace-nowrap">
                                                    ₱ {{ number_format($pricingReport->previous_price_per_serving_1, 2, '.', ',') }}
                                                </td>
                                                <td class="px-6 py-1 text-center bg-yellow-300 whitespace-nowrap">
                                                    ₱ {{ number_format($pricingReport->previous_price_per_serving_2, 2, '.', ',') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
            var date;
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
                    
                    if (inputValue.charAt(0) === '0') {
                        // Remove the leading '0'
                        inputValue = inputValue.slice(1);
                        // Update the input field with the modified value
                        $(this).val(inputValue);
                    }
                } else {
                    e.preventDefault();
                }
            });

            jQuery(document).on( "keyup", ".defaultZero", function(e){
                var inputValue = $(this).val();
                var key = e.key;
                if (event.keyCode == 8) {
                    if (inputValue == '') {
                        $(this).val(0);
                    }
                } else {
                    e.preventDefault();
                }
            });

            
            jQuery(document).on( "click", ".viewReport", function(){
                $('#loading').toggleClass('hidden');
                id = $(this).data('id');
                var name = $(this).data('name');
                $('#menuName').html(name);

                $.ajax({
                    url: "{{ route('viewPricingReport') }}",
                    method:"POST",
                    data:{
                        id: id,
                        _token: _token
                    },
                    success:function(result){
                        $('#reportBody').html(result);
                        $('#openViewModal').click();
                        $('#loading').toggleClass('hidden');
                    }
                });
            });


            // jQuery(document).on( "click", "#editSubmit", function(){
            //     var liquid_cash = $('#liquid_cash').val();
            //     var cash_on_hand = $('#cash_on_hand').val();
            //     var gcash = $('#gcash').val();
            //     var bank = $('#bank').val();
            //     var pending_remit = $('#pending_remit').val();

            //     $.ajax({
            //         url: "{{ route('updateActual') }}",
            //         method:"POST",
            //         data:{
            //             date: date,
            //             liquid_cash: liquid_cash,
            //             cash_on_hand: cash_on_hand,
            //             gcash: gcash,
            //             bank: bank,
            //             pending_remit: pending_remit,
            //             _token: _token
            //         },
            //         success:function(result){
            //             location.reload();
            //             alert(result);
            //         }
            //     })
            // });
        });
    </script>
</x-app-layout>
