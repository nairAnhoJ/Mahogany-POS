<x-app-layout>

    <style>
        #menuTabs::-webkit-scrollbar {
            height: 0px;
            background: transparent; 
        }

        #categoryAllContents::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }
    </style>

    @section('page_title', 'POS')

    {{-- LOADING --}}
        <div wire:loading id="loadingScreen" class="hidden fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-[60] overflow-hidden bg-gray-900 opacity-75 opa flex flex-col items-center justify-center">
            <div role="status">
                <svg aria-hidden="true" class="inline w-10 h-10 mr-2 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
            <h2 class="text-xl font-semibold text-center text-white">Processing...</h2>
            <p class="w-1/3 text-center text-white">This may take a few seconds, please don't close this page.</p>
        </div>
    {{-- LOADING END --}}

    {{-- NOTIF --}}
        <div id="notifDiv" class="absolute top-16 left-1/2 -translate-x-1/2 z-50 w-[400px]">
        </div>
    {{-- NOTIF END --}}

    {{-- REMOVE MODAL --}}
        <!-- Modal toggle -->
        <button data-modal-target="removeModal" data-modal-toggle="removeModal" id="openRemoveModal" class="hidden" type="button"></button>
    
        <!-- Main modal -->
        <div id="removeModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-2xl font-semibold text-gray-900">
                            <i class="mr-3 text-3xl text-red-500 uil uil-exclamation-triangle"></i>Remove Order
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="removeModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-4">
                        <p class="text-base leading-relaxed text-gray-500">
                            Are you sure you want to remove this order?
                        </p>
                        <p id="removeMenuName" class="text-base font-semibold leading-relaxed text-gray-500"></p>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-200 rounded-b">
                        <button id="acceptRemoveButton" data-modal-hide="removeModal" data-slug="" type="button" class="w-1/2 py-5 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">Remove</button>
                        <button data-modal-hide="removeModal" type="button" class="w-1/2 px-5 py-5 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 hover:text-gray-900 focus:z-10">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- REMOVE MODAL END --}}

    {{-- MOP MODAL --}}
        <!-- Modal toggle -->
        <button data-modal-target="MOPModal" data-modal-toggle="MOPModal" id="openMOPModal" class="hidden" type="button"></button>
    
        <!-- Main modal -->
        <div id="MOPModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-5xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-2xl font-semibold text-gray-900">
                            Mode of Payment
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="MOPModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-4">
                        <input type="hidden" name="mop" id="mop">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <button type="button" data-mop="CASH" data-modal-hide="MOPModal" data-modal-target="detailsModal" data-modal-toggle="detailsModal" class="inline-flex items-center w-full px-5 py-5 mb-2 mr-2 text-sm font-medium text-center text-white rounded-lg mopButton bg-emerald-500 hover:bg-emerald-600">
                                    <i class="mr-3 text-6xl uil uil-money-bill"></i>
                                    <span class="text-3xl font-bold">CASH</span>
                                </button>
                            </div>
                            <div>
                                <button type="button" data-mop="DEBIT / CREDIT CARD" data-modal-hide="MOPModal" data-modal-target="detailsModal" data-modal-toggle="detailsModal" class="mopButton text-white bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-4 focus:ring-[#2557D6]/50 focus:outline-none font-medium rounded-lg text-sm px-5 py-5 text-center inline-flex items-center mr-2 mb-2 w-full">
                                    <i class="mr-3 text-6xl uil uil-transaction"></i>
                                    <span class="text-3xl font-bold">DEBIT / CREDIT CARD</span>
                                </button>
                            </div>
                            <div>
                                <button type="button" data-mop="GCASH / MAYA" data-modal-hide="MOPModal" data-modal-target="detailsModal" data-modal-toggle="detailsModal" class="mopButton text-white bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-4 focus:ring-[#2557D6]/50 focus:outline-none font-medium rounded-lg text-sm px-5 py-5 text-center inline-flex items-center  mr-2 mb-2 w-full">
                                    <i class="mr-3 text-6xl uil uil-bolt"></i>
                                    <span class="text-3xl font-bold">GCASH / MAYA</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-300 rounded-b">
                        <button data-modal-hide="MOPModal" type="button" class="w-full px-5 py-5 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 hover:text-gray-900 focus:z-10">Close</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- MOP MODAL END --}}

    {{-- DISCOUNT MODAL --}}
        <!-- Main modal -->
        <div id="discountModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-3xl max-h-full">
                <!-- Modal content -->
                <form method="POST" action="{{ route('pos.updateDiscount') }}" class="relative bg-white rounded-lg shadow">
                    @csrf
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-2xl font-semibold text-gray-900">
                            Details
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="discountModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-4">
                        <input type="hidden" id="paymentMethod">
                        <div class="mb-6">
                            <label for="customer_with_discount" class="block mb-2 text-sm font-medium text-gray-900">Number Customer With Discount</label>
                            <input type="text" id="customer_with_discount" name="customer_with_discount" value="{{ ($discountRow->customer_with_discount) == 0 ? '' : $discountRow->customer_with_discount }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                        </div>
                        <div class="mb-6">
                            <label for="total_customer" class="block mb-2 text-sm font-medium text-gray-900">Total Number of Customers</label>
                            <input type="text" id="total_customer" name="total_customer" value="{{ ($discountRow->total_customer) == 0 ? '' : $discountRow->total_customer }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-300 rounded-b">
                        <button id="submitDiscountButton" data-modal-hide="discountModal" type="submit" class="w-1/2 px-5 py-5 text-lg font-bold text-white bg-blue-500 border border-blue-300 rounded-lg hover:bg-blue-600 focus:ring-4 focus:outline-none focus:z-10">SUBMIT</button>
                        <button data-modal-hide="discountModal" type="button" class="w-1/2 px-5 py-5 text-lg font-bold text-white bg-gray-500 border border-gray-300 rounded-lg hover:bg-gray-600 focus:ring-4 focus:outline-none focus:z-10">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    {{-- DISCOUNT MODAL END --}}

    {{-- NAME/NUMBER MODAL --}}
        <!-- Modal toggle -->
        <button data-modal-target="detailsModal" data-modal-toggle="detailsModal" id="openDetailsModal" class="hidden" type="button"></button>
    
        <!-- Main modal -->
        <div id="detailsModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-3xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-2xl font-semibold text-gray-900">
                            Details
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="detailsModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-4">
                        <input type="hidden" id="paymentMethod">
                        <div class="mb-6">
                            <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                            <input type="text" id="payor_name" name="payor_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div class="mb-6">
                            <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900">Account/Phone Number</label>
                            <input type="text" id="payor_number" name="payor_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-300 rounded-b">
                        <button id="detailsContButton" data-modal-hide="detailsModal" type="button" class="w-full px-5 py-5 text-lg font-bold text-white border rounded-lg bg-emerald-500 hover:bg-emerald-600 focus:ring-4 focus:outline-none border-emerald-300 focus:z-10">CONTINUE</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- NAME/NUMBER MODAL END --}}

    {{-- AMOUNT RECEIVED MODAL --}}
        <!-- Modal toggle -->
        <button data-modal-target="amountReceivedModal" data-modal-toggle="amountReceivedModal" id="openAmountReceivedModal" class="hidden" type="button"></button>


        <div id="amountReceivedModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div  class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-2xl font-semibold text-gray-900">
                            Pay Now 
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="amountReceivedModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-4">
                        <div class="mb-2">
                            <span class="ml-1 text-base font-medium"> ₱ </span><span class="text-base font-bold actualAmount">{{ number_format($total, 2, '.', ',') }}</span>
                        </div>
                        <div class="mb-2">
                            <label for="amount" class="block mb-2 text-base font-medium text-gray-900">Amount Received</label>
                            <input type="text" id="amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required autocomplete="off">
                            <p id="amountError" class="hidden text-sm italic text-red-500">Invalid amount. Please enter an amount more than or equal to <span class="ml-1 text-base font-medium"> ₱ </span><span class="text-base font-bold actualAmount">{{ number_format($total, 2, '.', ',') }}</span></p>
                        </div>
                        <div class="flex flex-col justify-between w-full h-auto px-32 rounded-lg">
                            <div class="grid grid-cols-4 gap-4">
                                <button type="button" class="text-xl font-bold border shadow numpad-button aspect-square bg-gray-50 focus:scale-95" data-value="7">7</button>
                                <button type="button" class="text-xl font-bold border shadow numpad-button aspect-square bg-gray-50 focus:scale-95" data-value="8">8</button>
                                <button type="button" class="text-xl font-bold border shadow numpad-button aspect-square bg-gray-50 focus:scale-95" data-value="9">9</button>
                                <button type="button" class="row-span-2 text-xl font-bold border shadow numpad-button bg-gray-50 focus:scale-95" data-value="bs"><i class="uil uil-arrow-left"></i></button>

                                <button type="button" class="text-xl font-bold border shadow numpad-button aspect-square bg-gray-50 focus:scale-95" data-value="4">4</button>
                                <button type="button" class="text-xl font-bold border shadow numpad-button aspect-square bg-gray-50 focus:scale-95" data-value="5">5</button>
                                <button type="button" class="text-xl font-bold border shadow numpad-button aspect-square bg-gray-50 focus:scale-95" data-value="6">6</button>

                                <button type="button" class="text-xl font-bold border shadow numpad-button aspect-square bg-gray-50 focus:scale-95" data-value="1">1</button>
                                <button type="button" class="text-xl font-bold border shadow numpad-button aspect-square bg-gray-50 focus:scale-95" data-value="2">2</button>
                                <button type="button" class="text-xl font-bold border shadow numpad-button aspect-square bg-gray-50 focus:scale-95" data-value="3">3</button>
                                <button type="button" class="row-span-2 font-bold border shadow numpad-button bg-gray-50 focus:scale-95" data-value="clr">CLEAR</button>

                                <button type="button" class="text-xl font-bold border shadow numpad-button aspect-square bg-gray-50 focus:scale-95" data-value="0">0</button>
                                <button type="button" class="text-xl font-bold border shadow numpad-button aspect-square bg-gray-50 focus:scale-95" data-value="00">00</button>
                                <button type="button" class="text-xl font-bold border shadow numpad-button aspect-square bg-gray-50 focus:scale-95" data-value=".">.</button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-200 rounded-b">
                        <button id="payNowButton" data-amount="{{ $amount }}" data-discount="{{ $discount }}" data-total="{{ $total }}" type="button" class="w-1/2 py-5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">Mark as Paid</button>
                        <button id="payNowCancelButton" data-modal-hide="amountReceivedModal" type="button" class="w-1/2 px-5 py-5 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 hover:text-gray-900 focus:z-10">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- AMOUNT RECEIVED MODAL END --}}

    {{-- CHANGE MODAL --}}
        <!-- Modal toggle -->
        <button data-modal-target="changeModal" data-modal-toggle="changeModal" id="openChangeModal" class="hidden" type="button"></button>
    
        <!-- Main modal -->
        <div id="changeModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-2xl font-semibold text-gray-900">
                            Change
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="changeModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="flex items-center justify-center p-6 space-y-4 text-4xl font-semibold leading-relaxed text-gray-500">
                        ₱<p id="changeP" class="ml-2"></p>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-300 rounded-b">
                        <button data-modal-hide="changeModal" id="closeChangeButton" type="button" class="w-full px-5 py-5 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 hover:text-gray-900 focus:z-10">Close</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- CHANGE MODAL END --}}

    {{-- PAYLATER CONFIRMATION MODAL --}}
        <!-- Modal toggle -->
        <button data-modal-target="plConModal" data-modal-toggle="plConModal" id="openPLConModal" class="hidden" type="button"></button>
    
        <!-- Main modal -->
        <div id="plConModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-2xl font-semibold text-gray-900">
                            Paylater Confirmation
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="plConModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-4">
                        Confirm Paylater Transaction
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-300 rounded-b">
                        <button data-modal-hide="plConModal" id="plConfirmButton" type="button" class="w-full px-5 py-5 text-sm font-medium text-white border rounded-lg bg-emerald-500 hover:bg-emerald-600 focus:ring-4 focus:outline-none border-emerald-300">Confirm</button>
                        <button data-modal-hide="plConModal" type="button" class="w-full px-5 py-5 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 hover:text-gray-900 focus:z-10">Close</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- PAYLATER CONFIRMATION MODAL END --}}

    {{-- SELECT TABLE MODAL --}}
        <div id="tableModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-3xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-3 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Select Table
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="tableModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6">
                        <div class="mb-4 border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="categoryTabs" data-tabs-toggle="#tableTab" role="tablist">
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 rounded-t-lg" id="all-tab" data-tabs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="false">All</button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="open-tab" data-tabs-target="#open" type="button" role="tab" aria-controls="open" aria-selected="false"><span class="flex items-center text-sm font-medium"><span class="flex w-3 h-3 bg-emerald-500 rounded-full mr-1.5 flex-shrink-0"></span>Open</span></button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="occupied-tab" data-tabs-target="#occupied" type="button" role="tab" aria-controls="occupied" aria-selected="false"><span class="flex items-center text-sm font-medium"><span class="flex w-3 h-3 bg-red-500 rounded-full mr-1.5 flex-shrink-0"></span>Occupied</span></button>
                                </li>
                                {{-- <li role="presentation">
                                    <button class="inline-block p-4 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="reserved-tab" data-tabs-target="#reserved" type="button" role="tab" aria-controls="reserved" aria-selected="false"><span class="flex items-center text-sm font-medium"><span class="flex w-3 h-3 bg-orange-500 rounded-full mr-1.5 flex-shrink-0"></span>Reserved</span></button>
                                </li> --}}
                            </ul>
                        </div>
                        <div id="tableTab">
                            <div class="hidden p-4 rounded-lg bg-gray-50 max-h-[calc(100vh-320px)] overflow-y-auto" id="all" role="tabpanel" aria-labelledby="all-tab">
                                <div class="grid grid-cols-4 gap-4 text-center">
                                    @foreach ($tables as $table)
                                        @if ($table->id == 1)
                                            <div class="bg-emerald-500 aspect-square rounded-xl">
                                                <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="relative w-full h-full tableButton rounded-xl">
                                                    <p class="absolute w-full text-2xl font-bold text-center -translate-y-1/2 top-1/3">{{ $table->name }}</p>
                                                    <i class="absolute text-6xl -translate-x-1/2 uil uil-shopping-bag bottom-8 left-1/2"></i>
                                                </button>
                                            </div>
                                        @else
                                            <div class="{{ ($table->status == 0) ? 'bg-emerald-500' : 'bg-red-500'; }} aspect-square rounded-xl">
                                                <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="relative w-full h-full tableButton rounded-xl">
                                                    <p class="absolute w-full text-2xl font-bold text-center -translate-y-1/2 top-1/3">{{ $table->name }}</p>
                                                    <img src="{{ asset('storage/images/ico/table-noBG.png') }}" alt="" class="absolute bottom-0 w-4/5 -translate-x-1/2 left-1/2">
                                                </button>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50 max-h-[calc(100vh-320px)] overflow-y-auto" id="open" role="tabpanel" aria-labelledby="open-tab">
                                <div class="grid grid-cols-4 gap-4 text-center">
                                    @foreach ($tables as $table)
                                        @if ($table->status == 0)
                                            @if ($table->id == 1)
                                                <div class="bg-emerald-500 aspect-square rounded-xl">
                                                    <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="relative w-full h-full tableButton rounded-xl">
                                                        <p class="absolute w-full text-2xl font-bold text-center -translate-y-1/2 top-1/3">{{ $table->name }}</p>
                                                        <i class="absolute text-6xl -translate-x-1/2 uil uil-shopping-bag bottom-8 left-1/2"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="{{ ($table->status == 0) ? 'bg-emerald-500' : 'bg-red-500'; }} aspect-square rounded-xl">
                                                    <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="relative w-full h-full tableButton rounded-xl">
                                                        <p class="absolute w-full text-2xl font-bold text-center -translate-y-1/2 top-1/3">{{ $table->name }}</p>
                                                        <img src="{{ asset('storage/images/ico/table-noBG.png') }}" alt="" class="absolute bottom-0 w-4/5 -translate-x-1/2 left-1/2">
                                                    </button>
                                                </div>
                                            @endif
                                            {{-- <div class="{{ ($table->status == 0) ? 'bg-emerald-500' : 'bg-red-500'; }} aspect-square rounded-xl">
                                                <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="relative w-full h-full tableButton rounded-xl">
                                                    <p class="absolute w-full text-2xl font-bold text-center -translate-y-1/2 top-1/3">{{ $table->name }}</p>
                                                    <img src="{{ asset('storage/images/ico/table-noBG.png') }}" alt="" class="absolute bottom-0 w-4/5 -translate-x-1/2 left-1/2">
                                                </button>
                                            </div> --}}
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50 max-h-[calc(100vh-320px)] overflow-y-auto" id="occupied" role="tabpanel" aria-labelledby="occupied-tab">
                                <div class="grid grid-cols-4 gap-4 text-center">
                                    @foreach ($tables as $table)
                                        @if ($table->status == 1)
                                            @if ($table->id == 1)
                                                <div class="bg-emerald-500 aspect-square rounded-xl">
                                                    <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="relative w-full h-full tableButton rounded-xl">
                                                        <p class="absolute w-full text-2xl font-bold text-center -translate-y-1/2 top-1/3">{{ $table->name }}</p>
                                                        <i class="absolute text-6xl -translate-x-1/2 uil uil-shopping-bag bottom-8 left-1/2"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="{{ ($table->status == 0) ? 'bg-emerald-500' : 'bg-red-500'; }} aspect-square rounded-xl">
                                                    <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="relative w-full h-full tableButton rounded-xl">
                                                        <p class="absolute w-full text-2xl font-bold text-center -translate-y-1/2 top-1/3">{{ $table->name }}</p>
                                                        <img src="{{ asset('storage/images/ico/table-noBG.png') }}" alt="" class="absolute bottom-0 w-4/5 -translate-x-1/2 left-1/2">
                                                    </button>
                                                </div>
                                            @endif
                                            {{-- <div class="{{ ($table->status == 0) ? 'bg-emerald-500' : 'bg-red-500'; }} aspect-square rounded-xl">
                                                <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="relative w-full h-full tableButton rounded-xl">
                                                    <p class="absolute w-full text-2xl font-bold text-center -translate-y-1/2 top-1/3">{{ $table->name }}</p>
                                                    <img src="{{ asset('storage/images/ico/table-noBG.png') }}" alt="" class="absolute bottom-0 w-4/5 -translate-x-1/2 left-1/2">
                                                </button>
                                            </div> --}}
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            {{-- <div class="hidden p-4 rounded-lg bg-gray-50" id="reserved" role="tabpanel" aria-labelledby="reserved-tab">
                                <p class="text-sm text-gray-500">This is some placeholder content the <strong class="font-medium text-gray-800">Contacts tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                            </div> --}}
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                        {{-- <button data-modal-hide="tableModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save</button> --}}
                        <button data-modal-hide="tableModal" type="button" class="closeTableModal text-gray-500 bg-white hover:bg-gray-10 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900">Close</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- SELECT TABLE MODAL END --}}

    <div style="height: calc(100vh - 48px)" class="w-screen gap-4 p-4">

        {{-- LEFT CONTENT --}}
            <div class="w-full h-full overflow-hidden bg-white border border-gray-200 rounded-lg shadow-lg xl:w-auto xl:col-span-2">
                <div>
                    <div class="flex items-center justify-between p-2">
                        @csrf   
                        <div class="relative w-1/2">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input type="text" id="searchMenu" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Search" required autocomplete="off">
                        </div>
                        <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="relative inline-flex items-center p-1.5 text-sm font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" height="30" viewBox="0 -960 960 960" width="30" fill="currentColor"><path d="M220-80q-24 0-42-18t-18-42v-520q0-24 18-42t42-18h110v-10q0-63 43.5-106.5T480-880q63 0 106.5 43.5T630-730v10h110q24 0 42 18t18 42v520q0 24-18 42t-42 18H220Zm0-60h520v-520H630v90q0 12.75-8.675 21.375-8.676 8.625-21.5 8.625-12.825 0-21.325-8.625T570-570v-90H390v90q0 12.75-8.675 21.375-8.676 8.625-21.5 8.625-12.825 0-21.325-8.625T330-570v-90H220v520Zm170-580h180v-10q0-38-26-64t-64-26q-38 0-64 26t-26 64v10ZM220-140v-520 520Z"/></svg>
                            <span class="sr-only">Notifications</span>
                            <div id="ordersCount" class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -right-2">{{ $orders->count() }}</div>
                        </button>
                    </div>
                    <div class="p-2 border-b border-neutral-300">
                        <div class="flex justify-between w-full">
                            <div class="p-px">
                                <button class="border rounded-lg w-9 aspect-square border-neutral-300 scroll-left">
                                    <i class="text-2xl uil uil-arrow-left"></i>
                                </button>
                            </div>
                            <div id="categoryTabsC" class="py-0.5 px-4 overflow-x-hidden w-[calc(100vw-920)]">
                                <div id="menuTabs" data-tabs-toggle="#categoryTabContent" role="tablist" class="flex overflow-x-auto gap-x-2">
                                    <button id="all-menu-tab" data-tabs-target="#all-menu" type="button" role="tab" aria-controls="all-menu" aria-selected="false" class="px-4 font-semibold leading-8 border rounded-lg whitespace-nowrap">
                                        All
                                    </button>
                                    @foreach ($categories as $category)
                                        <button id="{{$category->slug}}-tab" data-tabs-target="#{{$category->slug}}-menu" type="button" role="tab" aria-controls="{{$category->slug}}-menu" aria-selected="false" class="px-4 font-semibold leading-8 border rounded-lg whitespace-nowrap">
                                            {{$category->name}}
                                        </button>

                                        {{-- <button id="{{$category->name}}-tab" data-tabs-target="#{{$category->slug}}" type="button" role="tab" aria-controls="{{$category->slug}}" aria-selected="false" class="px-4 font-semibold leading-8 border rounded-lg whitespace-nowrap">
                                            {{$category->name}}
                                        </button> --}}
                                    @endforeach
                                </div>
                            </div>
                            <div class="p-px">
                                <button class="border rounded-lg w-9 aspect-square border-neutral-300 scroll-right">
                                    <i class="text-2xl uil uil-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="categoryAllContents" class="h-[calc(100vh-194px)] overflow-y-auto">
                        <div id="categoryTabContent" class="h-auto min-h-full bg-gray-100">
                            <div class="p-8" id="all-menu" role="tabpanel" aria-labelledby="all-menu-tab">
                                <div class="w-[656px] xl:w-[880px] 2xl:w-[1104px] mx-auto grid grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-8 justify-items-center content-center">
                                    @foreach ($menus as $menu)
                                        @if ($menu->is_hidden != 1)
                                            <a data-slug="{{$menu->slug}}" class="w-52 h-80 p-3 bg-white border {{ ($menu->current_quantity > $menu->reorder_point) ? 'border-neutral-200' : 'border-red-500 shadow-red-300' }}  rounded-xl shadow-lg cursor-pointer hover:scale-105 transition-all menu">
                                                <div class="w-full overflow-hidden aspect-square">
                                                    <img src="{{ asset('storage/'.$menu->image) }}" alt="" class="w-auto h-full mx-auto rounded-xl">
                                                </div>
                                                <div class="h-[calc(100%-184px)] text-center">
                                                    <div class="flex items-center border-b h-2/3 border-neutral-400">
                                                        <p class="text-lg font-medium">
                                                            {{$menu->name}}
                                                        </p>
                                                    </div>
                                                    <div class="flex items-center justify-center h-1/3">
                                                        <p class="text-xl font-bold">
                                                            ₱ {{number_format($menu->price, 2, '.', ',')}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @foreach ($categories as $category)
                                <div class="p-8" id="{{$category->slug}}-menu" role="tabpanel" aria-labelledby="{{$category->slug}}-menu-tab">
                                    <div class="w-[656px] xl:w-[880px] 2xl:w-[1104px] mx-auto grid grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-8 justify-items-center content-center">
                                        @foreach ($menus as $menu)
                                            @if ($menu->category_id == $category->id)
                                                <div data-slug="{{$menu->slug}}" class="w-52 h-80 p-3 bg-white border {{ ($menu->current_quantity > $menu->reorder_point) ? 'border-neutral-200' : 'border-red-500 shadow-red-300' }} rounded-xl shadow-lg cursor-pointer hover:scale-105 transition-all menu">
                                                    <div class="w-full overflow-hidden aspect-square">
                                                        <img src="{{ asset('storage/'.$menu->image) }}" alt="" class="w-auto h-full mx-auto rounded-xl">
                                                    </div>
                                                    <div class="h-[calc(100%-184px)] text-center">
                                                        <div class="flex items-center border-b h-2/3 border-neutral-400">
                                                            <p class="text-lg font-medium">
                                                                {{$menu->name}}
                                                            </p>
                                                        </div>
                                                        <div class="flex items-center justify-center h-1/3">
                                                            <p class="text-xl font-bold">
                                                                ₱ {{number_format($menu->price, 2, '.', ',')}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        {{-- LEFT CONTENT --}}

        {{-- RIGHT CONTENT --}}
            <aside id="default-sidebar" class="fixed top-0 z-40 w-1/2 h-screen transition-transform translate-x-full left-1/2" aria-label="Sidebar">
                <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
                    <div class="w-full h-full bg-white border border-gray-200 rounded-lg shadow-lg xl:w-auto">
                        <div class="m-2 border rounded-lg border-neutral-300">
                            <div class="flex items-center justify-between p-2">
                                <input type="hidden" id="table" name="table">
                                <h1 id="tableName" class="pl-2 text-2xl font-black tracking-wide">
                                    - - -
                                </h1>
                                <button type="button" id="openTableModal" data-modal-target="tableModal" data-modal-show="tableModal" class="p-1 border border-gray-100 rounded-lg shadow">
                                    <img src="{{ asset('storage/images/ico/table2.png') }}" alt="" class="rounded-full w-9">
                                </button>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex flex-col">
                                <div id="ordersDiv" class="h-[calc(100vh-320px)] overflow-y-auto">
                                    @foreach ($orders as $order)
                                        <div class="grid content-center w-full grid-cols-12 px-4 text-center h-14">
                                            <div class="flex items-center col-span-5 pr-2 text-xs font-semibold text-left">
                                                {{ $order->name }}
                                            </div>
                                            <div class="flex items-center justify-center">
                                                <button data-slug="{{ $order->slug }}" class="descQty aspect-square w-full max-w-[50px] bg-red-200 rounded-lg"><i class="text-xl text-red-900 uil uil-minus"></i></button>
                                            </div>
                                            <div class="flex items-center justify-center col-span-1 px-1">
                                                {{-- <p class="w-full text-sm font-semibold leading-7 text-center border-0 h-7">{{ $order->quantity }}</p> --}}
                                                <input type="text" class="w-full text-sm font-semibold leading-7 text-center border-0 h-7 focus:border-gray-500" value="{{ $order->quantity }}">
                                            </div>
                                            <div class="flex items-center justify-center">
                                                <button data-slug="{{ $order->slug }}" class="incQty aspect-square w-full max-w-[50px] bg-emerald-200 rounded-lg"><i class="text-xl uil uil-plus text-emerald-900"></i></button>
                                            </div>
                                            <div class="flex items-center justify-center col-span-3 text-sm font-semibold">
                                                {{ number_format($order->total_price, 2, '.', ',') }}
                                            </div>
                                            <div class="flex items-center justify-center">
                                                <button data-slug="{{ $order->slug }}" data-name="{{ $order->name }}" class="removeButton aspect-square w-full max-w-[50px] bg-red-600 rounded-lg"><i class="text-xl text-red-200 uil uil-times"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div>
                                    <div class="p-4">
                                        <div class="grid w-full pt-2">
                                            <div class="row-span-2">
                                                <div class="grid grid-cols-2">
                                                    <div class="justify-self-start ">
                                                        <strong class="text-xl font-medium text-slate-600 ">Subtotal</strong>
                                                    </div>
                                                    <div class="justify-self-end ">
                                                        <strong class="text-xl font-medium text-slate-600 "><span class="text-2xl">₱ </span><span id="subTotal">{{ number_format($subTotal, 2, '.', ',') }}</span></strong>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2">
                                                    <div class="justify-self-start ">
                                                        <strong class="text-lg font-medium text-slate-600 ">Service Charge</strong>
                                                    </div>
                                                    <div class="justify-self-end ">
                                                        <strong class="text-lg font-medium text-slate-600 "><span class="text-2xl">₱ </span><span id="serviceCharge">{{ number_format(($service_charge), 2, '.', ',') }}</span></strong>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2">
                                                    <div class="flex items-center justify-self-start gap-x-2">
                                                        <strong class="w-full text-base font-medium text-slate-600">Discount</strong>
                                                        <button data-modal-target="discountModal" data-modal-toggle="discountModal" type="button" class="text-blue-600"><span><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="currentColor"><path d="M180-180h44l443-443-44-44-443 443v44Zm614-486L666-794l42-42q17-17 42-17t42 17l44 44q17 17 17 42t-17 42l-42 42Zm-42 42L248-120H120v-128l504-504 128 128Zm-107-21-22-22 44 44-22-22Z"/></svg></span></button>
                                                        <a href="{{ route('pos.deleteDiscount') }}" id="deleteDiscountButton" class="text-red-600"><span><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="currentColor"><path d="M261-120q-24.75 0-42.375-17.625T201-180v-570h-41v-60h188v-30h264v30h188v60h-41v570q0 24-18 42t-42 18H261Zm438-630H261v570h438v-570ZM367-266h60v-399h-60v399Zm166 0h60v-399h-60v399ZM261-750v570-570Z"/></svg></span></a>
                                                        
                                                    </div>
                                                    <div class="justify-self-end ">
                                                        <strong class="text-base font-medium text-slate-600 "><span class="text-xl">₱ </span><span id="discountTotal">{{ number_format($discount, 2, '.', ',') }}</span></strong>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2">
                                                    <div class="justify-self-start">
                                                        <strong class="text-2xl font-medium text-slate-600 ">TOTAL</strong>
                                                    </div>
                                                    <div class="justify-self-end">
                                                        <strong class="text-2xl font-medium text-slate-600"><span class="text-3xl">₱ </span><span id="total">{{ number_format($total, 2, '.', ',') }}</span></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center row-span-1 p-auto ">
                                                <button disabled id="payButton" type="button" class="disabled:opacity-50 disabled:pointer-events-none m-2 w-full text-gray-50 bg-gradient-to-r from-green-600 to-teal-500 hover:bg-gradient-to-bl font-medium rounded-lg text-sm px-5 py-2.5 text-center">Pay</button>
                                                <button disabled id="payLaterButton" type="button" class="disabled:opacity-50 disabled:pointer-events-none w-full m-auto text-gray-50 bg-gradient-to-r from-purple-600 to-blue-500 hover:bg-gradient-to-bl font-medium rounded-lg text-sm px-5 py-2.5 text-center">Pay Later</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </aside>
        {{-- RIGHT CONTENT --}}

    </div>

    <script>
        $(document).ready(function() {

            $('.tableButton').click(function(){
                var id = $(this).data('table');
                var name = $(this).data('tablename');
                $('#table').val(id);
                $('#tableName').html(name);
                $('.tableButton').removeClass('ring-4 ring-inset ring-blue-500');
                $(this).addClass('ring-4 ring-inset ring-blue-500');

                if(id == '1'){
                    $('#payLaterButton').prop('disabled', true);
                    $('#payButton').prop('disabled', false);
                }else{
                    $('#payButton').prop('disabled', false);
                    $('#payLaterButton').prop('disabled', false);
                }

                $('.closeTableModal').click();
            })

            $('.scroll-left').click(function() {
                var divW = (($('#menuTabs').width() * 2) / 3);
                $('#menuTabs').animate({scrollLeft: '-=' + divW + 'px'}, 'slow');
            });
            
            $('.scroll-right').click(function() {
                var divW = (($('#menuTabs').width() * 2) / 3);
                $('#menuTabs').animate({scrollLeft: '+=' + divW + 'px'}, 'slow');
            });

            jQuery(document).on("click", ".menu", function(){
                var slug = $(this).data('slug');
                var _token = $('input[name="_token"]').val();
                var id = $('#table').val();

                $.ajax({
                    url:"{{ route('pos.add') }}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        slug: slug,
                        _token: _token
                    },
                    success:function(result){
                        $('#ordersCount').html(result.ordersCount);
                        $('#ordersDiv').html(result.orders);
                        $('#subTotal').html(result.subTotal);
                        $('#serviceCharge').html(result.service_charge);
                        $('#discountTotal').html(result.discount);
                        $('#total').html(result.total);
                        $('.actualAmount').html(result.total);
                        $('#payNowButton').data('discount', result.discount);
                        $('#payNowButton').data('amount', result.amount);
                        $('#payNowButton').data('total', result.total);
                        $('#notifDiv').html(result.thisNotif);
                    }
                })

            });

            jQuery(document).on("click", ".incQty", function(){
                var slug = $(this).data('slug');
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url:"{{ route('pos.inc') }}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        slug: slug,
                        _token: _token
                    },
                    success:function(result){
                        $('#ordersCount').html(result.ordersCount);
                        $('#ordersCount').html(result.orders.length);
                        $('#ordersDiv').html(result.orders);
                        $('#subTotal').html(result.subTotal);
                        $('#serviceCharge').html((result.service_charge));
                        $('#discountTotal').html(result.discount);
                        $('#total').html(result.total);
                        $('.actualAmount').html(result.total);
                        $('#payNowButton').data('discount', result.discount);
                        $('#payNowButton').data('amount', result.amount);
                        $('#payNowButton').data('total', result.total);
                        $('#notifDiv').html(result.thisNotif);
                    }
                })
            });

            jQuery(document).on("click", ".descQty", function(){
                var slug = $(this).data('slug');
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url:"{{ route('pos.desc') }}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        slug: slug,
                        _token: _token
                    },
                    success:function(result){
                        $('#ordersCount').html(result.ordersCount);
                        $('#ordersCount').html(result.orders.length);
                        $('#ordersDiv').html(result.orders);
                        $('#subTotal').html(result.subTotal);
                        $('#serviceCharge').html((result.service_charge));
                        $('#discountTotal').html(result.discount);
                        $('#total').html(result.total);
                        $('.actualAmount').html(result.total);
                        $('#payNowButton').data('discount', result.discount);
                        $('#payNowButton').data('amount', result.amount);
                        $('#payNowButton').data('total', result.total);
                    }
                })
            });

            jQuery(document).on("click", "#notifDiv button", function(){
                $('#notifDiv').html('');
            });

            jQuery(document).on("click", ".removeButton", function(){
                var slug = $(this).data('slug');
                var name = $(this).data('name');
                $('#removeMenuName').html(name);
                $('#acceptRemoveButton').data('slug', slug);
                $('#openRemoveModal').click();
            });

            jQuery(document).on("click", "#acceptRemoveButton", function(){
                var slug = $(this).data('slug');
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url:"{{ route('pos.remove') }}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        slug: slug,
                        _token: _token
                    },
                    success:function(result){
                        $('#ordersCount').html(result.ordersCount);
                        $('#ordersCount').html(result.orders.length);
                        $('#ordersDiv').html(result.orders);
                        $('#subTotal').html(result.subTotal);
                        $('#serviceCharge').html((result.service_charge));
                        $('#discountTotal').html(result.discount);
                        $('#total').html(result.total);
                        $('.actualAmount').html(result.total);
                        $('#payNowButton').data('discount', result.discount);
                        $('#payNowButton').data('amount', result.amount);
                        $('#payNowButton').data('total', result.total);
                        location.reload();
                    }
                })
            });

            $('.numpad-button').on('click', function() {
                const $amount = $('#amount');
                const buttonValue = $(this).data('value');

                if (buttonValue == 'bs') {
                    $amount.val($amount.val().slice(0, -1));
                }else if(buttonValue == 'clr'){
                    $amount.val('');
                }else if(buttonValue !== undefined){
                    $amount.val($amount.val() + buttonValue);

                    var inputValue = $('#amount').val();

                    var dotIndex = inputValue.indexOf('.');
                    if (dotIndex !== -1 && inputValue.indexOf('.', dotIndex + 1) !== -1) {
                        $('#amount').val(inputValue.substr(0, dotIndex + 1) + inputValue.substr(dotIndex + 1).replace(/\./g, ''));
                    }
                }
            });

            $('#amount').on('keyup', function() {
                var inputValue = $(this).val();
                $(this).val(inputValue.replace(/[^0-9\.]/g, ''));
                
                var dotIndex = inputValue.indexOf('.');
                if (dotIndex !== -1 && inputValue.indexOf('.', dotIndex + 1) !== -1) {
                $(this).val(inputValue.substr(0, dotIndex + 1) + inputValue.substr(dotIndex + 1).replace(/\./g, ''));
                }
            });

            $('#payButton').click(function(){
                var table = $('#table').val();
                if(table != ''){
                    $('#amountError').addClass('hidden');
                    $('#amount').val('');
                    $('#openMOPModal').click();
                }else{
                    $('#openTableModal').click();
                }
            });

            $('#payLaterButton').click(function(){
                var table = $('#table').val();
                if(table != '' && table != '0'){
                    $('#paymentMethod').val('0');
                    $('#openDetailsModal').click();
                }else{
                    $('#openTableModal').click();
                }
            });

            $('#payNowButton').click(function(){
                var amount = $(this).data('amount');
                var total = $(this).data('total');
                var discount = $(this).data('discount');
                var amountInput = $('#amount').val();
                var table = $('#table').val();
                var mop = $('#mop').val();
                var payor_name = $('#payor_name').val();
                var payor_number = $('#payor_number').val();
                var _token = $('input[name="_token"]').val();

                if(parseFloat(amountInput) < parseFloat(total)){
                    $('#amountError').removeClass('hidden');
                }else{
                    $('#loadingScreen').removeClass('hidden');
                    var change = amountInput - total;
                    $('#payNowCancelButton').click();
                    $('#openChangeModal').click();
                    $('#changeP').html((change.toFixed(2)));

                    $.ajax({
                        url:"{{ route('pos.pay') }}",
                        method:"POST",
                        dataType: 'json',
                        data:{
                            amount: amount,
                            discount: discount,
                            table: table,
                            amountInput: amountInput,
                            mop: mop,
                            payor_name: payor_name,
                            payor_number: payor_number,
                            _token: _token
                        },
                        success:function(result){
                        $('#ordersCount').html(result.ordersCount);
                        $('#ordersCount').html(result.orders.length);
                            $('#ordersDiv').html(result.orders);
                            $('#subTotal').html(result.subTotal);
                        $('#serviceCharge').html((result.service_charge));
                        $('#discountTotal').html(result.discount);
                            $('#total').html(result.total);
                            $('.actualAmount').html(result.total);
                        $('#payNowButton').data('discount', result.discount);
                            $('#payNowButton').data('amount', result.amount);
                        $('#payNowButton').data('total', result.total);
                            $('#loadingScreen').addClass('hidden');
                        }
                    })
                }

            });

            $('.mopButton').click(function(){
                var mop = $(this).data('mop');
                $('#mop').val(mop);
                $('#paymentMethod').val('1');
            });

            $('#detailsContButton').click(function(){
                var pm = $('#paymentMethod').val();

                if(pm == 1){
                    $('#openAmountReceivedModal').click();
                }else{
                    $('#openPLConModal').click();
                }
            });

            $('#plConfirmButton').click(function(){
                var amount = $('#payNowButton').data('amount');
                var discount = $('#payNowButton').data('discount');
                var table = $('#table').val();
                var payor_name = $('#payor_name').val();
                var payor_number = $('#payor_number').val();
                var _token = $('input[name="_token"]').val();

                $('#loadingScreen').removeClass('hidden');

                $.ajax({
                    url:"{{ route('pos.paylater') }}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        amount: amount,
                        discount: discount,
                        table: table,
                        payor_name: payor_name,
                        payor_number: payor_number,
                        _token: _token
                    },
                    success:function(result){
                        $('#ordersCount').html(result.ordersCount);
                        $('#ordersCount').html(result.orders.length);
                        $('#ordersDiv').html(result.orders);
                        $('#subTotal').html(result.subTotal);
                        $('#serviceCharge').html((result.service_charge));
                        $('#discountTotal').html(result.discount);
                        $('#total').html(result.total);
                        $('.actualAmount').html(result.total);
                        $('#payNowButton').data('discount', result.discount);
                        $('#payNowButton').data('amount', result.amount);
                        $('#loadingScreen').addClass('hidden');
                        location.reload();
                    }
                })
            });

            $('#closeChangeButton').click(function(){
                var table = $('#table').val();
                var url = `{{ url('/pos/print/${table}') }}`;
                window.open(url, '_blank');
                window.location.reload()
            });

            $('#searchMenu').keyup(function(){
                $('#all-menu-tab').click();
                var value = $(this).val().toLowerCase();
                $("#all-menu a").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('#deleteDiscountButton').click(function(){
                $('#loadingScreen').removeClass('hidden');
            });
            $('#submitDiscountButton').click(function(){
                $('#loadingScreen').removeClass('hidden');
            });

            $('#sendSSButton').click(function(){
                $('#loadingScreen').removeClass('hidden');
            })
        });
    </script>
</x-app-layout>
