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
            <h2 class="text-center text-white text-xl font-semibold">Processing...</h2>
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
                            <i class="uil uil-exclamation-triangle text-red-500 text-3xl mr-3"></i>Remove Order
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
                        <p id="removeMenuName" class="text-base leading-relaxed text-gray-500 font-semibold"></p>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-200 rounded-b">
                        <button id="acceptRemoveButton" data-modal-hide="removeModal" data-slug="" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm py-5 text-center w-1/2">Remove</button>
                        <button data-modal-hide="removeModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-5 hover:text-gray-900 focus:z-10 w-1/2">Cancel</button>
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
                                <button type="button" data-mop="CASH" data-modal-hide="MOPModal" data-modal-target="detailsModal" data-modal-toggle="detailsModal" class="mopButton text-white bg-emerald-500 hover:bg-emerald-600 font-medium rounded-lg text-sm px-5 py-5 text-center inline-flex items-center mr-2 mb-2 w-full">
                                    <i class="uil uil-money-bill text-6xl mr-3"></i>
                                    <span class="text-3xl font-bold">CASH</span>
                                </button>
                            </div>
                            <div>
                                <button type="button" data-mop="DEBIT / CREDIT CARD" data-modal-hide="MOPModal" data-modal-target="detailsModal" data-modal-toggle="detailsModal" class="mopButton text-white bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-4 focus:ring-[#2557D6]/50 focus:outline-none font-medium rounded-lg text-sm px-5 py-5 text-center inline-flex items-center mr-2 mb-2 w-full">
                                    <i class="uil uil-transaction text-6xl mr-3"></i>
                                    <span class="text-3xl font-bold">DEBIT / CREDIT CARD</span>
                                </button>
                            </div>
                            <div>
                                <button type="button" data-mop="GCASH / MAYA" data-modal-hide="MOPModal" data-modal-target="detailsModal" data-modal-toggle="detailsModal" class="mopButton text-white bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-4 focus:ring-[#2557D6]/50 focus:outline-none font-medium rounded-lg text-sm px-5 py-5 text-center inline-flex items-center  mr-2 mb-2 w-full">
                                    <i class="uil uil-bolt text-6xl mr-3"></i>
                                    <span class="text-3xl font-bold">GCASH / MAYA</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-300 rounded-b">
                        <button data-modal-hide="MOPModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-300 text-sm font-medium px-5 py-5 hover:text-gray-900 focus:z-10 w-full">Close</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- MOP MODAL END --}}

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
                        <button id="detailsContButton" data-modal-hide="detailsModal" type="button" class="text-white bg-emerald-500 hover:bg-emerald-600 focus:ring-4 focus:outline-none rounded-lg border border-emerald-300 text-lg font-bold px-5 py-5 focus:z-10 w-full">CONTINUE</button>
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
                            <label for="amount" class="block mb-2 text-base font-medium text-gray-900">Amount Received</label>
                            <input type="text" id="amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required autocomplete="off">
                            <p id="amountError" class="hidden text-sm text-red-500 italic">Invalid amount. Please enter an amount more than or equal to <span class="text-base font-medium ml-1"> ₱ </span><span id="actualAmount" class="text-base font-bold">{{ number_format($total, 2, '.', ',') }}</span></p>
                        </div>
                        <div class="w-full h-auto rounded-lg flex flex-col justify-between px-32">
                            <div class="grid grid-cols-4 gap-4">
                                <button type="button" class="numpad-button aspect-square border shadow bg-gray-50 focus:scale-95 text-xl font-bold" data-value="7">7</button>
                                <button type="button" class="numpad-button aspect-square border shadow bg-gray-50 focus:scale-95 text-xl font-bold" data-value="8">8</button>
                                <button type="button" class="numpad-button aspect-square border shadow bg-gray-50 focus:scale-95 text-xl font-bold" data-value="9">9</button>
                                <button type="button" class="numpad-button row-span-2 border shadow bg-gray-50 focus:scale-95 text-xl font-bold" data-value="bs"><i class="uil uil-arrow-left"></i></button>

                                <button type="button" class="numpad-button aspect-square border shadow bg-gray-50 focus:scale-95 text-xl font-bold" data-value="4">4</button>
                                <button type="button" class="numpad-button aspect-square border shadow bg-gray-50 focus:scale-95 text-xl font-bold" data-value="5">5</button>
                                <button type="button" class="numpad-button aspect-square border shadow bg-gray-50 focus:scale-95 text-xl font-bold" data-value="6">6</button>

                                <button type="button" class="numpad-button aspect-square border shadow bg-gray-50 focus:scale-95 text-xl font-bold" data-value="1">1</button>
                                <button type="button" class="numpad-button aspect-square border shadow bg-gray-50 focus:scale-95 text-xl font-bold" data-value="2">2</button>
                                <button type="button" class="numpad-button aspect-square border shadow bg-gray-50 focus:scale-95 text-xl font-bold" data-value="3">3</button>
                                <button type="button" class="numpad-button row-span-2 border shadow bg-gray-50 focus:scale-95 font-bold" data-value="clr">CLEAR</button>

                                <button type="button" class="numpad-button aspect-square border shadow bg-gray-50 focus:scale-95 text-xl font-bold" data-value="0">0</button>
                                <button type="button" class="numpad-button aspect-square border shadow bg-gray-50 focus:scale-95 text-xl font-bold" data-value="00">00</button>
                                <button type="button" class="numpad-button aspect-square border shadow bg-gray-50 focus:scale-95 text-xl font-bold" data-value=".">.</button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-200 rounded-b">
                        <button id="payNowButton" data-amount="{{ $total }}" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm py-5 text-center w-1/2">Mark as Paid</button>
                        <button id="payNowCancelButton" data-modal-hide="amountReceivedModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-5 hover:text-gray-900 focus:z-10 w-1/2">Cancel</button>
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
                    <div class="p-6 space-y-4 flex text-4xl leading-relaxed text-gray-500 font-semibold justify-center items-center">
                        ₱<p id="changeP" class="ml-2"></p>.00
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-300 rounded-b">
                        <button data-modal-hide="changeModal" id="closeChangeButton" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-300 text-sm font-medium px-5 py-5 hover:text-gray-900 focus:z-10 w-full">Close</button>
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
                        <button data-modal-hide="plConModal" id="plConfirmButton" type="button" class="text-white bg-emerald-500 hover:bg-emerald-600 focus:ring-4 focus:outline-none rounded-lg border border-emerald-300 text-sm font-medium px-5 py-5 w-full">Confirm</button>
                        <button data-modal-hide="plConModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-300 text-sm font-medium px-5 py-5 hover:text-gray-900 focus:z-10 w-full">Close</button>
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
                                                <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="w-full h-full relative tableButton rounded-xl">
                                                    <p class="absolute top-1/3 -translate-y-1/2 w-full text-center text-2xl font-bold">{{ $table->name }}</p>
                                                    <i class="uil uil-shopping-bag text-6xl absolute bottom-8 left-1/2 -translate-x-1/2"></i>
                                                </button>
                                            </div>
                                        @else
                                            <div class="{{ ($table->status == 0) ? 'bg-emerald-500' : 'bg-red-500'; }} aspect-square rounded-xl">
                                                <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="w-full h-full relative tableButton rounded-xl">
                                                    <p class="absolute top-1/3 -translate-y-1/2 w-full text-center text-2xl font-bold">{{ $table->name }}</p>
                                                    <img src="{{ asset('storage/images/ico/table-noBG.png') }}" alt="" class="w-4/5 absolute bottom-0 left-1/2 -translate-x-1/2">
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
                                                    <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="w-full h-full relative tableButton rounded-xl">
                                                        <p class="absolute top-1/3 -translate-y-1/2 w-full text-center text-2xl font-bold">{{ $table->name }}</p>
                                                        <i class="uil uil-shopping-bag text-6xl absolute bottom-8 left-1/2 -translate-x-1/2"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="{{ ($table->status == 0) ? 'bg-emerald-500' : 'bg-red-500'; }} aspect-square rounded-xl">
                                                    <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="w-full h-full relative tableButton rounded-xl">
                                                        <p class="absolute top-1/3 -translate-y-1/2 w-full text-center text-2xl font-bold">{{ $table->name }}</p>
                                                        <img src="{{ asset('storage/images/ico/table-noBG.png') }}" alt="" class="w-4/5 absolute bottom-0 left-1/2 -translate-x-1/2">
                                                    </button>
                                                </div>
                                            @endif
                                            {{-- <div class="{{ ($table->status == 0) ? 'bg-emerald-500' : 'bg-red-500'; }} aspect-square rounded-xl">
                                                <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="w-full h-full relative tableButton rounded-xl">
                                                    <p class="absolute top-1/3 -translate-y-1/2 w-full text-center text-2xl font-bold">{{ $table->name }}</p>
                                                    <img src="{{ asset('storage/images/ico/table-noBG.png') }}" alt="" class="w-4/5 absolute bottom-0 left-1/2 -translate-x-1/2">
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
                                                    <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="w-full h-full relative tableButton rounded-xl">
                                                        <p class="absolute top-1/3 -translate-y-1/2 w-full text-center text-2xl font-bold">{{ $table->name }}</p>
                                                        <i class="uil uil-shopping-bag text-6xl absolute bottom-8 left-1/2 -translate-x-1/2"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="{{ ($table->status == 0) ? 'bg-emerald-500' : 'bg-red-500'; }} aspect-square rounded-xl">
                                                    <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="w-full h-full relative tableButton rounded-xl">
                                                        <p class="absolute top-1/3 -translate-y-1/2 w-full text-center text-2xl font-bold">{{ $table->name }}</p>
                                                        <img src="{{ asset('storage/images/ico/table-noBG.png') }}" alt="" class="w-4/5 absolute bottom-0 left-1/2 -translate-x-1/2">
                                                    </button>
                                                </div>
                                            @endif
                                            {{-- <div class="{{ ($table->status == 0) ? 'bg-emerald-500' : 'bg-red-500'; }} aspect-square rounded-xl">
                                                <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="w-full h-full relative tableButton rounded-xl">
                                                    <p class="absolute top-1/3 -translate-y-1/2 w-full text-center text-2xl font-bold">{{ $table->name }}</p>
                                                    <img src="{{ asset('storage/images/ico/table-noBG.png') }}" alt="" class="w-4/5 absolute bottom-0 left-1/2 -translate-x-1/2">
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

    <div style="height: calc(100vh - 48px)" class="p-4 w-screen flex xl:grid xl:grid-cols-3 gap-4">

        {{-- LEFT CONTENT --}}
            <div class="h-full w-[calc(100%-384px)] xl:w-auto xl:col-span-2 bg-white shadow-lg rounded-lg border border-gray-200 overflow-hidden">
                <div>
                    <div class="p-2 flex flex-row-reverse">
                        <div class="flex items-center w-1/2">
                            @csrf   
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Search" required autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="p-2 border-b border-neutral-300">
                        <div class="flex justify-between w-full">
                            <div class="p-px">
                                <button class="w-9 aspect-square border border-neutral-300 rounded-lg scroll-left">
                                    <i class="uil uil-arrow-left text-2xl"></i>
                                </button>
                            </div>
                            <div id="categoryTabsC" class="py-0.5 px-4 overflow-x-hidden w-[calc(100vw-920)]">
                                <div id="menuTabs" data-tabs-toggle="#categoryTabContent" role="tablist" class="overflow-x-auto flex gap-x-2">
                                        <button id="all-menu-tab" data-tabs-target="#all-menu" type="button" role="tab" aria-controls="all-menu" aria-selected="false" class="leading-8 px-4 font-semibold border rounded-lg whitespace-nowrap">
                                            All
                                        </button>
                                    @foreach ($categories as $category)
                                        <button id="{{$category->slug}}-tab" data-tabs-target="#{{$category->slug}}" type="button" role="tab" aria-controls="{{$category->slug}}" aria-selected="false" class="leading-8 px-4 font-semibold border rounded-lg whitespace-nowrap">
                                            {{$category->name}}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="p-px">
                                <button class="w-9 aspect-square border border-neutral-300 rounded-lg scroll-right">
                                    <i class="uil uil-arrow-right text-2xl"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="categoryAllContents" class="h-[calc(100vh-194px)] overflow-y-auto">
                        <div id="categoryTabContent" class="h-auto min-h-full bg-gray-100">
                            <div class="p-8" id="all-menu" role="tabpanel" aria-labelledby="all-menu-tab">
                                <div class="w-[432px] xl:w-[656px] 2xl:w-[880px] mx-auto grid grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-8 justify-items-center content-center">
                                    @foreach ($menus as $menu)
                                        <div data-slug="{{$menu->slug}}" class="w-52 h-80 p-3 bg-white border border-neutral-200 rounded-xl shadow-lg cursor-pointer hover:scale-105 transition-all menu">
                                            <div class="w-full aspect-square overflow-hidden">
                                                <img src="{{ asset('storage/'.$menu->image) }}" alt="" class="rounded-xl h-full w-auto mx-auto">
                                            </div>
                                            <div class="h-[calc(100%-184px)] text-center">
                                                <div class="h-2/3 border-b border-neutral-400 flex items-center">
                                                    <p class="text-lg font-medium">
                                                        {{$menu->name}}
                                                    </p>
                                                </div>
                                                <div class="h-1/3 flex justify-center items-center">
                                                    <p class="text-xl font-bold">
                                                        ₱ {{number_format($menu->price, 2, '.', ',')}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @foreach ($categories as $category)
                                <div class="hidden p-8" id="{{$category->slug}}" role="tabpanel" aria-labelledby="{{$category->slug}}-tab">
                                    <div class="w-[432px] xl:w-[656px] 2xl:w-[880px] mx-auto grid grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-8 justify-items-center content-center">
                                        @foreach ($menus as $menu)
                                            @if ($menu->category_id == $category->id)
                                                <div data-slug="{{$menu->slug}}" class="w-52 h-80 p-3 bg-white border border-neutral-200 rounded-xl shadow-lg cursor-pointer hover:scale-105 transition-all menu">
                                                    <div class="w-full aspect-square overflow-hidden">
                                                        <img src="{{ asset('storage/'.$menu->image) }}" alt="" class="rounded-xl h-full w-auto mx-auto">
                                                    </div>
                                                    <div class="h-[calc(100%-184px)] text-center">
                                                        <div class="h-2/3 border-b border-neutral-400 flex items-center">
                                                            <p class="text-lg font-medium">
                                                                {{$menu->name}}
                                                            </p>
                                                        </div>
                                                        <div class="h-1/3 flex justify-center items-center">
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
            <div class="h-full w-96 xl:w-auto bg-white shadow-lg rounded-lg border border-gray-200">
                <div class="border border-neutral-300 rounded-lg m-2">
                    <div class="flex justify-between p-2 items-center">
                        <input type="hidden" id="table" name="table">
                        <h1 id="tableName" class="text-2xl font-black tracking-wide pl-2">
                            - - -
                        </h1>
                        <button type="button" id="openTableModal" data-modal-target="tableModal" data-modal-show="tableModal" class="p-1 rounded-lg shadow border border-gray-100">
                            <img src="{{ asset('storage/images/ico/table2.png') }}" alt="" class="w-9 rounded-full">
                        </button>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="flex flex-col">
                        <div id="ordersDiv" class="h-[calc(100vh-350px)] overflow-y-auto">
                            @foreach ($orders as $order)
                                <div class="grid grid-cols-12 content-center h-14 w-full text-center px-4">
                                    <div class="col-span-5 text-xs font-semibold text-left flex items-center pr-2">
                                        {{ $order->name }}
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="{{ $order->slug }}" class="descQty aspect-square w-full bg-red-200 rounded-lg"><i class="uil uil-minus text-xl text-red-900"></i></button>
                                    </div>
                                    <div class="col-span-1 flex items-center justify-center">
                                        <p class="w-full text-center text-sm font-semibold border-0 h-7 leading-7">{{ $order->quantity }}</p>
                                        <input type="hidden" value="{{ $order->quantity }}">
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="{{ $order->slug }}" class="incQty aspect-square w-full bg-emerald-200 rounded-lg"><i class="uil uil-plus text-xl text-emerald-900"></i></button>
                                    </div>
                                    <div class="col-span-3 flex items-center text-sm font-semibold justify-center">
                                        {{ number_format($order->total_price, 2, '.', ',') }}
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="{{ $order->slug }}" data-name="{{ $order->name }}" class="removeButton aspect-square w-full bg-red-600 rounded-lg"><i class="uil uil-times text-xl text-red-200"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div>
                            <div class="p-4">
                                <div class="pt-2 grid w-full">
                                    <div class="row-span-2">
                                        <div class="grid grid-cols-2">
                                            <div class="justify-self-start ">
                                                <strong class="text-slate-600 text-xl font-medium ">Subtotal</strong>
                                            </div>
                                            <div class="justify-self-end ">
                                                <strong class="text-slate-600 text-xl font-medium "><span class="text-2xl">₱ </span><span id="subTotal">{{ number_format($subTotal, 2, '.', ',') }}</span></strong>
                                            </div>
                                        </div>
                                        {{-- <div class="grid grid-cols-2">
                                            <div class="justify-self-start ">
                                                <strong class="text-slate-600 text-sm font-medium ">Tax</strong>
                                            </div>
                                            <div class="justify-self-end ">
                                                <strong class="text-slate-600 text-sm font-medium ">120.00</strong>
                                            </div>
                                        </div> --}}
                                        <div class="grid grid-cols-2">
                                            <div class="justify-self-start">
                                                <strong class="text-slate-600 text-2xl font-medium ">TOTAL</strong>
                                            </div>
                                            <div class="justify-self-end">
                                                <strong class="text-slate-600 text-2xl font-medium"><span class="text-3xl">₱ </span><span id="total">{{ number_format($total, 2, '.', ',') }}</span></strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-auto row-span-1 flex items-center ">
                                        <button disabled id="payButton" type="button" class="disabled:opacity-50 disabled:pointer-events-none m-2 w-full text-gray-50 bg-gradient-to-r from-green-600 to-teal-500 hover:bg-gradient-to-bl font-medium rounded-lg text-sm px-5 py-2.5 text-center">Pay</button>
                                        <button disabled id="payLaterButton" type="button" class="disabled:opacity-50 disabled:pointer-events-none w-full m-auto text-gray-50 bg-gradient-to-r from-purple-600 to-blue-500 hover:bg-gradient-to-bl font-medium rounded-lg text-sm px-5 py-2.5 text-center">Pay Later</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                        $('#ordersDiv').html(result.orders);
                        $('#subTotal').html(result.subTotal);
                        $('#total').html(result.total);
                        $('#actualAmount').html(result.amount);
                        $('#payNowButton').data('amount', result.amount);
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
                        $('#ordersDiv').html(result.orders);
                        $('#subTotal').html(result.subTotal);
                        $('#total').html(result.total);
                        $('#actualAmount').html(result.amount);
                        $('#payNowButton').data('amount', result.amount);
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
                        $('#ordersDiv').html(result.orders);
                        $('#subTotal').html(result.subTotal);
                        $('#total').html(result.total);
                        $('#actualAmount').html(result.amount);
                        $('#payNowButton').data('amount', result.amount);
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
                        $('#ordersDiv').html(result.orders);
                        $('#subTotal').html(result.subTotal);
                        $('#total').html(result.total);
                        $('#actualAmount').html(result.amount);
                        $('#payNowButton').data('amount', result.amount);
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
                var amountInput = $('#amount').val();
                var table = $('#table').val();
                var mop = $('#mop').val();
                var payor_name = $('#payor_name').val();
                var payor_number = $('#payor_number').val();
                var _token = $('input[name="_token"]').val();

                if(amountInput < amount){
                    $('#amountError').removeClass('hidden');
                }else{
                    $('#loadingScreen').removeClass('hidden');
                    var change = amountInput - amount;
                    $('#payNowCancelButton').click();
                    $('#openChangeModal').click();
                    $('#changeP').html(change);

                    $.ajax({
                        url:"{{ route('pos.pay') }}",
                        method:"POST",
                        dataType: 'json',
                        data:{
                            amount: amount,
                            table: table,
                            amountInput: amountInput,
                            mop: mop,
                            payor_name: payor_name,
                            payor_number: payor_number,
                            _token: _token
                        },
                        success:function(result){
                            $('#ordersDiv').html(result.orders);
                            $('#subTotal').html(result.subTotal);
                            $('#total').html(result.total);
                            $('#actualAmount').html(result.amount);
                            $('#payNowButton').data('amount', result.amount);
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
                        table: table,
                        payor_name: payor_name,
                        payor_number: payor_number,
                        _token: _token
                    },
                    success:function(result){
                        $('#ordersDiv').html(result.orders);
                        $('#subTotal').html(result.subTotal);
                        $('#total').html(result.total);
                        $('#actualAmount').html(result.amount);
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
        });
    </script>
</x-app-layout>
