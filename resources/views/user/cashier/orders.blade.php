<x-app-layout>
    <style>

    </style>

    @section('page_title', '')


    {{-- LOADING --}}
        <div wire:loading id="loadingScreen" class="hidden fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-[60] overflow-hidden bg-gray-900 opacity-75 opa flex flex-col items-center justify-center">
            <div role="status">
                <svg aria-hidden="true" class="inline w-10 h-10 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
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
        <div id="notifDiv" class="absolute top-16 left-1/2 -translate-x-1/2 z-50 w-[400px]"></div>
    {{-- NOTIF END --}}

    {{-- REMOVE MODAL --}}
        <!-- Modal toggle -->
        <button data-modal-target="removeModal" data-modal-toggle="removeModal" id="openRemoveModal" class="hidden" type="button"></button>
    
        <!-- Main modal -->
        <div id="removeModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-[99] hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-800 bg-opacity-70">
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

    {{-- REDUCE MODAL --}}
        <!-- Modal toggle -->
        <button data-modal-target="reduceModal" data-modal-toggle="reduceModal" id="openReduceModal" class="hidden" type="button"></button>
    
        <!-- Main modal -->
        <div id="reduceModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-[99] hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-800 bg-opacity-70">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-2xl font-semibold text-gray-900">
                            <i class="uil uil-exclamation-triangle text-red-500 text-3xl mr-3"></i>Reduce Quantity
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="reduceModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-4">
                        <p class="text-base leading-relaxed text-gray-500">
                            Are you sure you want to reduce the quantity of this order?
                        </p>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-200 rounded-b">
                        <button id="acceptReduceButton" data-modal-hide="reduceModal" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm py-5 text-center w-1/2">Confirm</button>
                        <button data-modal-hide="reduceModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-5 hover:text-gray-900 focus:z-10 w-1/2">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- REDUCE MODAL END --}}

    {{-- CANCEL MODAL --}}
        <!-- Modal toggle -->
        <button data-modal-target="cancelModal" data-modal-toggle="cancelModal" id="openCancelModal" class="hidden" type="button"></button>
    
        <!-- Main modal -->
        <div id="cancelModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-[99] hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-800 bg-opacity-70">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-2xl font-semibold text-gray-900">
                            <i class="uil uil-exclamation-triangle text-red-500 text-3xl mr-3"></i>Cancel All Orders
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="cancelModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-4">
                        <p class="text-base leading-relaxed text-gray-500">
                            Are you sure you want to cancel all orders in this table?
                        </p>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-200 rounded-b">
                        <button id="acceptCancelButton" data-modal-hide="cancelModal" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm py-5 text-center w-1/2">Confirm</button>
                        <button data-modal-hide="cancelModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-5 hover:text-gray-900 focus:z-10 w-1/2">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- CANCEL MODAL END --}}

    {{-- OPEN MODAL --}}
        <!-- Modal toggle -->
        <button data-modal-target="openModal" data-modal-toggle="openModal" id="openOpenModal" class="hidden" type="button"></button>
    
        <!-- Main modal -->
        <div id="openModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-[99] hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-800 bg-opacity-70">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-2xl font-semibold text-gray-900">
                            Open Table
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="openModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-4">
                        <p class="text-base leading-relaxed text-gray-500">
                            Are you sure you want to mark this table as open?
                        </p>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-200 rounded-b">
                        <button id="acceptOpenButton" data-modal-hide="openModal" type="button" class="text-white bg-emerald-700 hover:bg-emerald-800 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-medium rounded-lg text-sm py-5 text-center w-1/2">Confirm</button>
                        <button data-modal-hide="openModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-5 hover:text-gray-900 focus:z-10 w-1/2">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- OPEN MODAL END --}}

    {{-- OCCUPY MODAL --}}
        <!-- Modal toggle -->
        <button data-modal-target="occupyModal" data-modal-toggle="occupyModal" id="occupyOpenModal" class="hidden" type="button"></button>
    
        <!-- Main modal -->
        <div id="occupyModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-[99] hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-800 bg-opacity-70">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-2xl font-semibold text-gray-900">
                            Occupy Table
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="occupyModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-4">
                        <p class="text-base leading-relaxed text-gray-500">
                            Are you sure you want to mark this table as occupied?
                        </p>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-200 rounded-b">
                        <button id="acceptOccupyButton" data-modal-hide="occupyModal" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm py-5 text-center w-1/2">Confirm</button>
                        <button data-modal-hide="occupyModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-5 hover:text-gray-900 focus:z-10 w-1/2">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- OCCUPY MODAL END --}}


    {{-- MOP MODAL --}}
        <!-- Modal toggle -->
        <button data-modal-target="MOPModal" data-modal-toggle="MOPModal" id="openMOPModal" class="hidden" type="button"></button>
    
        <!-- Main modal -->
        <div id="MOPModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-[99] hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-800 bg-opacity-70">
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
                                <button type="button" data-mop="CASH" data-modal-hide="MOPModal" data-modal-target="amountReceivedModal" data-modal-toggle="amountReceivedModal" class="mopButton text-white bg-emerald-500 hover:bg-emerald-600 font-medium rounded-lg text-sm px-5 py-5 text-center inline-flex items-center mr-2 mb-2 w-full">
                                    <i class="uil uil-money-bill text-6xl mr-3"></i>
                                    <span class="text-3xl font-bold">CASH</span>
                                </button>
                            </div>
                            <div>
                                <button type="button" data-mop="DEBIT / CREDIT CARD" data-modal-hide="MOPModal" data-modal-target="amountReceivedModal" data-modal-toggle="amountReceivedModal" class="mopButton text-white bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-4 focus:ring-[#2557D6]/50 focus:outline-none font-medium rounded-lg text-sm px-5 py-5 text-center inline-flex items-center mr-2 mb-2 w-full">
                                    <i class="uil uil-transaction text-6xl mr-3"></i>
                                    <span class="text-3xl font-bold">DEBIT / CREDIT CARD</span>
                                </button>
                            </div>
                            <div>
                                <button type="button" data-mop="GCASH / MAYA" data-modal-hide="MOPModal" data-modal-target="amountReceivedModal" data-modal-toggle="amountReceivedModal" class="mopButton text-white bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-4 focus:ring-[#2557D6]/50 focus:outline-none font-medium rounded-lg text-sm px-5 py-5 text-center inline-flex items-center  mr-2 mb-2 w-full">
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

    {{-- AMOUNT RECEIVED MODAL --}}
        <!-- Modal toggle -->
        <button data-modal-target="amountReceivedModal" data-modal-toggle="amountReceivedModal" id="openAmountReceivedModal" class="hidden" type="button"></button>


        <div id="amountReceivedModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-[99] hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-800 bg-opacity-70">
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
                            <p id="amountError" class="text-sm text-gray-600 italic">Enter an amount more than or equal to <span class="text-base font-medium ml-1"> ₱ </span><span id="actualAmount" class="text-base font-bold"></span></p>
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
                        <button id="payNowButton" data-amount="" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm py-5 text-center w-1/2">Mark as Paid</button>
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
        <div id="changeModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-[99] hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-800 bg-opacity-70">
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
                        <button id="changeCloseModal" data-modal-hide="changeModal" type="button" onclick="window.location.reload()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-300 text-sm font-medium px-5 py-5 hover:text-gray-900 focus:z-10 w-full">Close</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- CHANGE MODAL END --}}


    {{-- SELECTED TABLE MODAL --}}
        <!-- Modal toggle -->
        <button data-modal-target="selectedTableModal" data-modal-toggle="selectedTableModal" id="openSelectedTableModal" class="hidden" type="button"></button>
    
        <!-- Main modal -->
        <div id="selectedTableModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-4xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 id="tableName" class="text-2xl font-semibold text-gray-900"></h3>
                        <div class="flex items-center">
                            <div id="paidDiv" class="mr-7">
                            </div>
                            <div id="printDiv">
                            </div>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-5 inline-flex items-center" data-modal-hide="selectedTableModal">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                            </button>
                        </div>
                    </div>
                    <!-- Modal body -->
                    <div class="px-4 py-2 space-y-4 h-[500px] overflow-y-auto">
                        <input type="hidden" name="table" id="table">
                        <p class="text-xl leading-relaxed text-gray-500 font-semibold">
                            <div id="allOrders" class="relative h-auto"></div>
                        </p>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-6 border-t border-gray-200 rounded-b">
                        <div id="completeOrderDiv" class="w-1/3"></div>
                        <div id="cancelOrderDiv" class="w-1/3"></div>
                        <button data-modal-hide="selectedTableModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-base font-bold px-5 py-5 hover:text-gray-900 focus:z-10 w-1/3">Close</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- SELECTED TABLE END --}}

    <div class="p-6 h-[calc(100vh-48px)] w-screen">
        @csrf
        <div class="w-full grid grid-cols-5 gap-6">
            @foreach ($tables as $table)
                <div class="{{ ($table->status == 0) ? 'bg-emerald-500' : 'bg-red-500'; }} w-full aspect-square h-auto rounded-xl">
                    <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" data-status="{{ $table->status }}" class="w-full h-full relative tableButton rounded-xl">
                        <p class="absolute top-1/3 -translate-y-1/2 w-full text-center text-2xl font-bold">{{ $table->name }}</p>
                        <img src="{{ asset('storage/images/ico/table-noBG.png') }}" alt="" class="w-4/5 absolute bottom-0 left-1/2 -translate-x-1/2">
                    </button>
                </div>
            @endforeach
        </div>
        <input type="hidden" id="mop" name="mop">
    </div>

    <script>
        $(document).ready(function() {
            var slug;
            var table;
            var id;
            var _token = $('input[name="_token"]').val();

            $('.tableButton').click(function(){
                id = $(this).data('table');
                var name = $(this).data('tablename');
                var status = $(this).data('status');


                if(status != 0){
                    $.ajax({
                        url:"{{ route('orders.getMenu') }}",
                        method:"POST",
                        dataType: 'json',
                        data:{
                            id: id,
                            _token: _token
                        },
                        success:function(result){
                            $('#allOrders').html(result.allOrders);

                            if(result.pd == '1'){
                                $('#paidDiv').html('');
                            $('#printDiv').html(``);
                            }else{
                                $('#paidDiv').html('<button id="paidButton" class="flex items-center px-4 py-2 rounded-lg bg-emerald-400"><span class="font-semibold">Mark as PAID</span></button>');
                                $('#printDiv').html(`<a href="{{ url('/orders/print/${id}') }}" target="_blank" class="flex items-center border border-gray-400 px-4 py-1 rounded-lg"><i class="uil uil-print text-xl mr-1"></i><span class="font-semibold">Print Bill</span></a>`);
                            }

                            if(result.co == '1'){
                                $('#completeOrderDiv').html('<button id="completeOrderButton" data-modal-hide="selectedTableModal" data-slug="" type="button" class="text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-bold rounded-lg text-base py-5 text-center w-full">Open Table</button>');
                                $('#cancelOrderDiv').html('');
                            }else{
                                $('#completeOrderDiv').html('');
                                $('#cancelOrderDiv').html('<button id="cancelOrderButton" data-modal-hide="selectedTableModal" data-slug="" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-bold rounded-lg text-base py-5 text-center w-full">Cancel Order</button>');
                            }
                            $('#table').val(id);
                            $('#openSelectedTableModal').click();
                        }
                    })
                }else{
                    $('#completeOrderDiv').html('<button id="occupyButton" data-modal-hide="selectedTableModal" type="button" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-bold rounded-lg text-base py-5 text-center w-full">Occupy Table</button>');
                    $('#cancelOrderDiv').html('');
                    $('#printDiv').html('');
                    $('#paidDiv').html('');
                    $('#allOrders').html('This table is not occupied.');
                    $('#openSelectedTableModal').click();
                }
                $('#tableName').html(name);
            })


            jQuery(document).on("click", ".reduceButton", function(){
                slug = $(this).data('slug');
                table = $(this).data('table');

                $('#openReduceModal').click();
            });


            jQuery(document).on("click", "#acceptReduceButton", function(){
                $('#loadingScreen').removeClass('hidden');
                $.ajax({
                    url:"{{ route('orders.reduce') }}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        slug: slug,
                        table: table,
                        _token: _token
                    },
                    success:function(result){
                        $('#allOrders').html(result.allOrders);
                        console.log(result.co);
                        if(result.co == '1'){
                            $('#completeOrderDiv').html('<button id="completeOrderButton" data-modal-hide="selectedTableModal" data-slug="" type="button" class="text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-bold rounded-lg text-base py-5 text-center w-full">Open Table</button>');

                            $('#cancelOrderDiv').html('');
                        }else{
                            $('#completeOrderDiv').html('');

                            $('#cancelOrderDiv').html('<button id="cancelOrderButton" data-modal-hide="selectedTableModal" data-slug="" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-bold rounded-lg text-base py-5 text-center w-full">Cancel Order</button>');
                        }
                        $('#loadingScreen').addClass('hidden');
                    }
                })
            });


            jQuery(document).on("click", ".removeButton", function(){
                slug = $(this).data('slug');
                table = $(this).data('table');

                $('#openRemoveModal').click();
            });


            jQuery(document).on("click", "#acceptRemoveButton", function(){
                $('#loadingScreen').removeClass('hidden');
                $.ajax({
                    url:"{{ route('orders.remove') }}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        slug: slug,
                        table: table,
                        _token: _token
                    },
                    success:function(result){
                        if(result.allOrders != '1'){
                            $('#allOrders').html(result.allOrders);
                            console.log(result.co);
                            if(result.co == '1'){
                                $('#completeOrderDiv').html('<button id="completeOrderButton" data-modal-hide="selectedTableModal" data-slug="" type="button" class="text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-bold rounded-lg text-base py-5 text-center w-full">Open Table</button>');

                                $('#cancelOrderDiv').html('');
                            }else{
                                $('#completeOrderDiv').html('');

                                $('#cancelOrderDiv').html('<button id="cancelOrderButton" data-modal-hide="selectedTableModal" data-slug="" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-bold rounded-lg text-base py-5 text-center w-full">Cancel Order</button>');
                            }
                        }else{
                            location.reload();
                        }
                        $('#loadingScreen').addClass('hidden');
                    }
                })
            });

            jQuery(document).on("click", "#cancelOrderButton", function(){
                $('#openCancelModal').click();
            });


            jQuery(document).on("click", "#acceptCancelButton", function(){
                $('#loadingScreen').removeClass('hidden');
                $.ajax({
                    url:"{{ route('orders.cancel') }}",
                    method:"POST",
                    data:{
                        id: id,
                        _token: _token
                    },
                    success:function(result){
                        location.reload();
                        $('#loadingScreen').addClass('hidden');
                    }
                })
            });

            jQuery(document).on("click", "#completeOrderButton", function(){
                $('#openOpenModal').click();
            });


            jQuery(document).on("click", "#acceptOpenButton", function(){
                $('#loadingScreen').removeClass('hidden');
                $.ajax({
                    url:"{{ route('orders.open') }}",
                    method:"POST",
                    data:{
                        id: id,
                        _token: _token
                    },
                    success:function(result){
                        location.reload();
                        $('#loadingScreen').addClass('hidden');
                    }
                })
            });


            jQuery(document).on("click", "#occupyButton", function(){
                $('#occupyOpenModal').click();
            });


            jQuery(document).on("click", "#acceptOccupyButton", function(){
                $('#loadingScreen').removeClass('hidden');
                $.ajax({
                    url:"{{ route('orders.occupy') }}",
                    method:"POST",
                    data:{
                        id: id,
                        _token: _token
                    },
                    success:function(result){
                        location.reload();
                        $('#loadingScreen').addClass('hidden');
                    }
                })
            });



            jQuery(document).on("click", "#paidButton", function(){
                $('#openMOPModal').click();
            });

            $('.mopButton').click(function(){
                var mop = $(this).data('mop');
                $('#mop').val(mop);
                $('#loadingScreen').removeClass('hidden');
                $.ajax({
                    url:"{{ route('orders.getAmount') }}",
                    method:"POST",
                    data:{
                        id: id,
                        _token: _token
                    },
                    success:function(result){
                        $('#actualAmount').html(result);
                        $('#payNowButton').data('amount', result);
                        $('#loadingScreen').addClass('hidden');
                    }
                })
            });

            $('#payNowButton').click(function(){
                var amount = $(this).data('amount');
                var amountInput = $('#amount').val();
                var namountInput = parseInt(amountInput);
                var mop = $('#mop').val();

                if(namountInput >= amount){
                    $('#loadingScreen').removeClass('hidden');
                    var change = amountInput - amount;
                    $('#payNowCancelButton').click();
                    $('#changeP').html(change);

                    $.ajax({
                        url:"{{ route('orders.paid') }}",
                        method:"POST",
                        data:{
                            id: id,
                            amountInput: amountInput,
                            mop: mop,
                            _token: _token
                        },
                        success:function(result){
                            $('#openChangeModal').click();
                            $('#loadingScreen').addClass('hidden');
                        }
                    })
                }else{
                    $('#amountError').addClass('text-red-500');
                }
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

            $('#changeCloseModal').click(function(){
                location.reload();
            });


            // jQuery(document).on("click", "#acceptPaidButton", function(){
            //     $('#loadingScreen').removeClass('hidden');
            //     $.ajax({
            //         url:"{{ route('orders.paid') }}",
            //         method:"POST",
            //         data:{
            //             id: id,
            //             _token: _token
            //         },
            //         success:function(result){
            //             location.reload();
            //             $('#loadingScreen').addClass('hidden');
            //         }
            //     })
            // });
        });
    </script>
</x-app-layout>
