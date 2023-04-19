<x-app-layout>

    <style>
        
    </style>

    @section('page_title', '')

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
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#tableTab" role="tablist">
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
                                        <div class="{{ ($table->status == 0) ? 'bg-emerald-500' : 'bg-red-500'; }} aspect-square rounded-xl">
                                            <button type="button" data-table="{{ $table->id }}" data-tablename="{{ $table->name }}" class="w-full h-full relative tableButton rounded-xl">
                                                <p class="absolute top-1/3 -translate-y-1/2 w-full text-center text-2xl font-bold">{{ $table->name }}</p>
                                                <img src="{{ asset('storage/images/ico/table-noBG.png') }}" alt="" class="w-4/5 absolute bottom-0 left-1/2 -translate-x-1/2">
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50" id="open" role="tabpanel" aria-labelledby="open-tab">
                                <div class="grid grid-cols-4 gap-4 text-center">
                                    @foreach ($tables as $table)
                                        @if ($table->status == 0)
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
                            <div class="hidden p-4 rounded-lg bg-gray-50" id="occupied" role="tabpanel" aria-labelledby="occupied-tab">
                                <div class="grid grid-cols-4 gap-4 text-center">
                                    @foreach ($tables as $table)
                                        @if ($table->status == 1)
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
                            {{-- <div class="hidden p-4 rounded-lg bg-gray-50" id="reserved" role="tabpanel" aria-labelledby="reserved-tab">
                                <p class="text-sm text-gray-500">This is some placeholder content the <strong class="font-medium text-gray-800">Contacts tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                            </div> --}}
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                        {{-- <button data-modal-hide="tableModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save</button> --}}
                        <button data-modal-hide="tableModal" type="button" class="text-gray-500 bg-white hover:bg-gray-10 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900">Close</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- SELECT TABLE MODAL END --}}

    <div style="height: calc(100vh - 48px)" class="p-4 w-screen flex xl:grid xl:grid-cols-3 gap-4">
        <div class="h-full w-[calc(100%-384px)] xl:w-auto xl:col-span-2 bg-white shadow-lg rounded-lg border border-gray-200">

        </div>
        <div class="h-full w-96 xl:w-auto bg-white shadow-lg rounded-lg border border-gray-200">
            <div class="flex justify-between p-2 items-center">
                <input type="hidden" id="table" name="table">
                <h1 id="tableName" class="text-2xl font-black tracking-wide">
                    - - -
                </h1>
                <button type="button" data-modal-target="tableModal" data-modal-show="tableModal" class="p-1 rounded-lg shadow border border-gray-100">
                    <img src="{{ asset('storage/images/ico/table2.png') }}" alt="" class="w-10 rounded-full">
                </button>
            </div>
            <div class="mt-5">
                <div class="flex flex-col">
                    <div class="h-[calc(100vh-350px)]">
                        <div class="grid grid-cols-12 content-center h-14 w-full text-center px-4">
                            <div class="col-span-4 text-xs font-semibold text-left flex items-center pr-2">
                                ADOBONG MANOK NA PINAUPO
                            </div>
                            <div class="flex items-center justify-center">
                                <button class="aspect-square w-full bg-red-200 rounded-lg"><i class="uil uil-minus text-xl text-red-900"></i></button>
                            </div>
                            <div class="col-span-2 px-2 flex items-center justify-center">
                                <input type="text" class="w-full text-center text-sm font-semibold border-0 h-7" value="1">
                            </div>
                            <div class="flex items-center justify-center">
                                <button class="aspect-square w-full bg-emerald-200 rounded-lg"><i class="uil uil-plus text-xl text-emerald-900"></i></button>
                            </div>
                            <div class="col-span-3 flex items-center text-sm font-semibold justify-center">
                                9,999.00
                            </div>
                            <div class="flex items-center justify-center">
                                <button class="aspect-square w-full bg-red-600 rounded-lg"><i class="uil uil-times text-xl text-red-200"></i></button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="p-4">
                            <div class="pt-2 grid w-full">
                                <div class="row-span-2  ">
                                    <div class="grid grid-cols-2">
                                        <div class="justify-self-start ">
                                            <strong class="text-slate-600 text-xl font-medium ">Subtotal</strong>
                                        </div>
                                        <div class="justify-self-end ">
                                            <strong class="text-slate-600 text-xl font-medium ">1000.00</strong>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="justify-self-start ">
                                            <strong class="text-slate-600 text-sm font-medium ">Tax</strong>
                                        </div>
                                        <div class="justify-self-end ">
                                            <strong class="text-slate-600 text-sm font-medium ">120.00</strong>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="justify-self-start ">
                                            <strong class="text-slate-600 text-2xl font-medium ">TOTAL</strong>
                                        </div>
                                        <div class="justify-self-end ">
                                            <strong class="text-slate-600 text-2xl font-medium ">1120.00</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-auto row-span-1 flex items-center ">
                                    <button type="button"  class="m-2 w-full text-gray-50 bg-gradient-to-r from-green-600 to-teal-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-red-400  font-medium rounded-lg text-sm px-5 py-2.5 text-center">Pay</button>
                                    <button type="button"  class="w-full m-auto text-gray-50 bg-gradient-to-r from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-red-400  font-medium rounded-lg text-sm px-5 py-2.5 text-center">Pay Later</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

































        <div class="h-full ">
            <div  class="h-full overflow-hidden bg-white ">
                <div class="h-full">
                    <div class="h-full mx-auto grid grid-cols-1 gap-2 max-w-2xl gap-y-2 gap-x-2 sm:gap-y-20  lg:max-w-none lg:grid-cols-4">
                        <div class=" bg-gray-800 h-full  lg:p-2 lg:pt-2 col-span-3 border border-gray-200 rounded-lg shadow">
                            <div class="h-full grid grid-rows-6">
                                <div class="row-span-2 grid grid-rows-5   rounded-lg shadow">
                                    <div class="row-span-1    rounded-lg ">
                                        <form class="flex items-center">   
                                            <label for="simple-search" class="sr-only">Search</label>
                                            <div class="relative w-full">
                                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-400 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                                </div>
                                                <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  " placeholder="Search" required>
                                            </div>
                                            <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-600 rounded-lg border border-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 ">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                                <span class="sr-only">Search</span>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="py-4 flex row-span-4  relative rounded-lg ">
                                        <ul id="myTab"  role="tablist" class="h-full w-full my-3 text-gray-50  rounded-lg   mx-auto grid grid-cols-4 gap-8 max-w-2xl gap-y-8 gap-x-2 sm:gap-y-2 lg:mx-0 lg:max-w-none lg:grid-cols-5">
                                            <li id="best-tab" type="button" role="tab" aria-controls="best" aria-selected="false" class="text-xl flex justify-center border mr-2 h-full w-full bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl  font-medium rounded-lg  px-5 py-2.5 text-center shadow">
                                                <h5  class="m-auto"> Best Seller</h5>
                                            </li>
                                            <li id="appetizer-tab" type="button" role="tab" aria-controls="appetizer" aria-selected="false"  class="text-xl flex justify-center border mr-2 h-full w-full bg-gradient-to-br from-red-200 via-red-300 to-yellow-200 hover:bg-gradient-to-bl font-medium rounded-lg  px-5 py-2.5 text-center shadow">
                                                <h5   class="m-auto"> Appetizer</h5>
                                            </li>
                                            <li class="text-xl flex justify-center mr-2 h-full w-full border text-white bg-gradient-to-br from-teal-300 to-lime-200 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 :focus:ring-blue-800 font-medium rounded-lg  px-5 py-2.5 text-center border-gray-200 shadow">
                                                <a href="#"  class="m-auto">Vegetables</a>
                                            </li>
                                            <li class="text-xl flex justify-center mr-2 h-full w-full border text-white bg-gradient-to-br from-orange-500 to-red-200 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300  font-medium rounded-lg  px-5 py-2.5 text-center border-gray-200 shadow">
                                                <a href="#"  class="m-auto"> Beef and Pork</a>
                                            </li>
                                            <li class="text-xl flex justify-center mr-2 h-full w-full border text-white bg-gradient-to-br from-orange-400 to-yellow-300 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300  font-medium rounded-lg  px-5 py-2.5 text-center border-gray-200 shadow">
                                                <a href="#"  class="m-auto"> Seafoods</a>
                                            </li>
                                            <li class="text-xl flex justify-center mr-2 h-full w-full border text-white bg-gradient-to-br from-green-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300  font-medium rounded-lg  px-5 py-2.5 text-center border-gray-200 shadow">
                                                <a href="#"  class="m-auto">Sinigang</a>
                                            </li>
                                            <li class="text-xl flex justify-center mr-2 h-full w-full border text-white bg-gradient-to-br from-orange-500 to-red-200 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300  font-medium rounded-lg  px-5 py-2.5 text-center border-gray-200 shadow">
                                                <a href="#"  class="m-auto"> Chicken</a>
                                            </li>
                                            <li class="text-xl flex justify-center mr-2 h-full w-full border text-white bg-gradient-to-br from-orange-400 to-yellow-300 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300  font-medium rounded-lg  px-5 py-2.5 text-center border-gray-200 shadow">
                                                <a href="#"  class="m-auto"> Sisig</a>
                                            </li>
                                            <li class="text-xl flex justify-center mr-2 h-full w-full border text-white bg-gradient-to-br from-red-200 via-red-300 to-yellow-200 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300  font-medium rounded-lg  px-5 py-2.5 text-center border-gray-200 shadow">
                                                <a href="#"  class="m-auto"> Mirienda</a>
                                            </li>
                                            <li class="text-xl flex justify-center mr-2 h-full w-full border text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300  font-medium rounded-lg px-5 py-2.5 text-center border-gray-200 shadow">
                                                <a href="#"  class="m-auto"> Desserts</a>
                                            </li>
                                        </ul>
                                    </div>
          
                                </div>
                                <div  id="myTabContent" class="overflow-y-auto h-full relative row-span-4 rounded-lg ">
                                    <div  id="best" role="tabpanel" aria-labelledby="best-tab" style="height: 400px" class="hidden w-full my-3 overflow-y-auto rounded-lg shadow mx-auto grid grid-cols-4 gap-8 max-w-2xl gap-y-8 gap-x-2 sm:gap-y-2 lg:mx-0 lg:max-w-none lg:grid-cols-5">
                                        <div class=" m-auto h-44 w-44 max-w-sm bg-white border border-gray-200 rounded-lg shadow bg-white ">
                                            <a href="#">
                                                <img class="h-2/4 w-2/4 rounded-t-lg" src="../src/bulalographics.png" alt="product image" />
                                            </a>
                                            <div class="px-5 ">
                                                <a href="#">
                                                    <h5 class="text-xl font-semibold tracking-tight text-gray-900 ">Bulalo Solo</h5>
                                                </a>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xl font-bold text-gray-900 ">$599</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" m-auto h-44 w-44 max-w-sm bg-white border border-gray-200 rounded-lg shadow">
                                            <a href="#">
                                                <img class="h-2/4 w-2/4 rounded-t-lg" src="../src/bulalographics.png" alt="product image" />
                                            </a>
                                            <div class="px-5 ">
                                                <a href="#">
                                                    <h5 class="text-xl font-semibold tracking-tight text-gray-900 ">Bulalo Solo</h5>
                                                </a>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xl font-bold text-gray-900 ">$599</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" m-auto h-44 w-44 max-w-sm bg-white border border-gray-200 rounded-lg shadow bg-white ">
                                            <a href="#">
                                                <img class="h-2/4 w-2/4 rounded-t-lg" src="../src/bulalographics.png" alt="product image" />
                                            </a>
                                            <div class="px-5 ">
                                                <a href="#">
                                                <h5 class="text-xl font-semibold tracking-tight text-gray-900 ">Bulalo Solo</h5>
                                            </a>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xl font-bold text-gray-900 ">$599</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" m-auto h-44 w-44 max-w-sm bg-white border border-gray-200 rounded-lg shadow bg-white ">
                                        <a href="#">
                                            <img class="h-2/4 w-2/4 rounded-t-lg" src="../src/bulalographics.png" alt="product image" />
                                        </a>
                                        <div class="px-5 ">
                                            <a href="#">
                                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 ">Bulalo Solo</h5>
                                            </a>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xl font-bold text-gray-900 ">$599</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" m-auto h-44 w-44 max-w-sm bg-white border border-gray-200 rounded-lg shadow bg-white ">
                                            <a href="#">
                                                <img class="h-2/4 w-2/4 rounded-t-lg" src="../src/bulalographics.png" alt="product image" />
                                            </a>
                                            <div class="px-5 ">
                                                <a href="#">
                                                <h5 class="text-xl font-semibold tracking-tight text-gray-900 ">Bulalo Solo</h5>
                                            </a>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xl font-bold text-gray-900 ">$599</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" m-auto h-44 w-44 max-w-sm bg-white border border-gray-200 rounded-lg shadow bg-white ">
                                            <a href="#">
                                                <img class="h-2/4 w-2/4 rounded-t-lg" src="../src/bulalographics.png" alt="product image" />
                                            </a>
                                            <div class="px-5 ">
                                                <a href="#">
                                                <h5 class="text-xl font-semibold tracking-tight text-gray-900 ">Bulalo Solo</h5>
                                            </a>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xl font-bold text-gray-900 ">$599</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" m-auto h-44 w-44 max-w-sm bg-white border border-gray-200 rounded-lg shadow bg-white ">
                                            <a href="#">
                                                <img class="h-2/4 w-2/4 rounded-t-lg" src="../src/bulalographics.png" alt="product image" />
                                            </a>
                                            <div class="px-5 ">
                                                <a href="#">
                                                <h5 class="text-xl font-semibold tracking-tight text-gray-900 ">Bulalo Solo</h5>
                                            </a>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xl font-bold text-gray-900 ">$599</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div  id="appetizer" role="tabpanel" aria-labelledby="appetizer-tab" style="height: 400px" class="hidden w-full my-3 overflow-y-auto  rounded-lg shadow  mx-auto grid grid-cols-4 gap-8 max-w-2xl gap-y-8 gap-x-2 sm:gap-y-2 lg:mx-0 lg:max-w-none lg:grid-cols-5">
          
                                        <div class=" m-auto h-44 w-44 max-w-sm bg-white border border-gray-200 rounded-lg shadow bg-white ">
                                            <a href="#">
                                                <img class="h-2/4 w-2/4 rounded-t-lg" src="../src/bulalographics.png" alt="product image" />
                                            </a>
                                            <div class="px-5 ">
                                                <a href="#">
                                                <h5 class="text-xl font-semibold tracking-tight text-gray-900 ">Bulalo Solo</h5>
                                            </a>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xl font-bold text-gray-900 ">$599</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" m-auto h-44 w-44 max-w-sm bg-white border border-gray-200 rounded-lg shadow bg-white ">
                                            <a href="#">
                                                <img class="h-2/4 w-2/4 rounded-t-lg" src="../src/bulalographics.png" alt="product image" />
                                            </a>
                                            <div class="px-5 ">
                                                <a href="#">
                                                <h5 class="text-xl font-semibold tracking-tight text-gray-900 ">Bulalo Solo</h5>
                                            </a>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xl font-bold text-gray-900 ">$599</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" m-auto h-44 w-44 max-w-sm bg-white border border-gray-200 rounded-lg shadow bg-white ">
                                            <a href="#">
                                                <img class="h-2/4 w-2/4 rounded-t-lg" src="../src/bulalographics.png" alt="product image" />
                                            </a>
                                            <div class="px-5 ">
                                                <a href="#">
                                                <h5 class="text-xl font-semibold tracking-tight text-gray-900 ">Bulalo Solo</h5>
                                            </a>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xl font-bold text-gray-900 ">$599</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" m-auto h-44 w-44 max-w-sm bg-white border border-gray-200 rounded-lg shadow bg-white ">
                                            <a href="#">
                                                <img class="h-2/4 w-2/4 rounded-t-lg" src="../src/bulalographics.png" alt="product image" />
                                            </a>
                                            <div class="px-5 ">
                                                <a href="#">
                                                <h5 class="text-xl font-semibold tracking-tight text-gray-900 ">Bulalo Solo</h5>
                                            </a>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xl font-bold text-gray-900 ">$599</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" bg-gray-800  h-full  lg:p-2 lg:pt-2 col-span-1 ">
                            <div  style="grid-template-rows: repeat(12, minmax(0, 1fr));"class=" grid h-full">
                                <div style="grid-row: span 1 / span 1" class="">
                                    <p class="text-2xl text-gray-50 ">Table 1</p>
                                    <p class="text-lg text-gray-500 ">Cedrick J.</p>
                                </div>
                                <div style="grid-row: span 11 / span 11" class=" ">
                                    <div class="w-full h-2/4  ">
                                        <div class="overflow-y-auto h-full relative max-w-sm mx-auto bg-slate-800 highlight-white/5 shadow-lg ring-1 ring-black/5 rounded-xl flex flex-col divide-slate-200/5">
                                            <div class="h-16 grid grid-cols-12 gap-4 p-1">
                                                <div class="col-span-6">
                                                    <strong class="text-slate-200 text-sm font-medium ">SNG Baboy</strong><br>
                                                    <span class="text-slate-400 text-sm font-medium ">Solo</span>
                                                    <strong class="my-auto text-slate-200 text-xs font-medium ">( x <span>  1</span> )</strong>
                                                </div>
                                                <div class="flex justify-center col-span-2  align-middle">
                                                    <strong class="my-auto text-slate-200 text-sm font-medium ">100</strong>
                                                </div>
                                                <div class="grid grid-cols-12 col-span-4">
                                                    <button class="col-span-6  h-full bg-fuchsia-300">-</button>
                                                    <button class="col-span-6  h-full bg-blue-400">+</button>
                                                </div>
                                            </div>
                          <div class="h-16 grid grid-cols-12 gap-4 p-1">
                            <div class="col-span-6">
                              <strong class="text-slate-200 text-sm font-medium ">Rice</strong><br>
                              <span class="text-slate-400 text-sm font-medium ">plain</span>
                              <strong class="my-auto text-slate-200 text-xs font-medium ">( x <span>  1</span> )</strong>
          
                            </div>
                            <div class="flex justify-center col-span-2  align-middle">
                              <strong class="my-auto text-slate-200 text-sm font-medium ">100</strong>
                            </div>
                            <div class="grid grid-cols-12 col-span-4">
                              <button class="col-span-6  h-full bg-fuchsia-300">-</button>
                              <button class="col-span-6  h-full bg-blue-400">+</button>
                            </div>
                          </div>
                          <div class="h-16 grid grid-cols-12 gap-4 p-1">
                            <div class="col-span-6">
                              <strong class="text-slate-200 text-sm font-medium ">Coca-cola</strong><br>
                              <span class="text-slate-400 text-sm font-medium ">Solo</span>
                              <strong class="my-auto text-slate-200 text-xs font-medium ">( x <span>  1</span> )</strong>
          
          
                            </div>
                            <div class="flex justify-center col-span-2  align-middle">
                              <strong class="my-auto text-slate-200 text-sm font-medium ">100</strong>
                            </div>
                            <div class="grid grid-cols-12 col-span-4">
                              <button class="col-span-6  h-full bg-fuchsia-300">-</button>
                              <button class="col-span-6  h-full bg-blue-400">+</button>
                            </div>
                           
                          </div>
                          <div class="h-16 grid grid-cols-12 gap-4 p-1">
                            <div class="col-span-6">
                              <strong class="text-slate-200 text-sm font-medium ">Coca-cola</strong><br>
                              <span class="text-slate-400 text-sm font-medium ">Solo</span>
                              <strong class="my-auto text-slate-200 text-xs font-medium ">( x <span>  1</span> )</strong>
          
          
                            </div>
                            <div class="flex justify-center col-span-2  align-middle">
                              <strong class="my-auto text-slate-200 text-sm font-medium ">100</strong>
                            </div>
                            <div class="grid grid-cols-12 col-span-4">
                              <button class="col-span-6  h-full bg-fuchsia-300">-</button>
                              <button class="col-span-6  h-full bg-blue-400">+</button>
                            </div>
                           
                          </div>
                          <div class="h-16 grid grid-cols-12 gap-4 p-1">
                            <div class="col-span-6">
                              <strong class="text-slate-200 text-sm font-medium ">Coca-cola</strong><br>
                              <span class="text-slate-400 text-sm font-medium ">Solo</span>
                              <strong class="my-auto text-slate-200 text-xs font-medium ">( x <span>  1</span> )</strong>
          
                            </div>
                            <div class="flex justify-center col-span-2  align-middle">
                              <strong class="my-auto text-slate-200 text-sm font-medium ">100</strong>
                            </div>
                            <div class="grid grid-cols-12 col-span-4">
                              <button class="col-span-6  h-full bg-fuchsia-300">-</button>
                              <button class="col-span-6  h-full bg-blue-400">+</button>
                            </div>
                           
                          </div>
                          <div class="h-16 grid grid-cols-12 gap-4 p-1">
                            <div class="col-span-6">
                              <strong class="text-slate-200 text-sm font-medium ">Coca-cola</strong><br>
                              <span class="text-slate-400 text-sm font-medium ">Solo</span>
                              <strong class="my-auto text-slate-200 text-xs font-medium ">( x <span>  1</span> )</strong>
          
                            </div>
                            <div class="flex justify-center col-span-2  align-middle">
                              <strong class="my-auto text-slate-200 text-sm font-medium ">100</strong>
                            </div>
                            <div class="grid grid-cols-12 col-span-4">
                              <button class="col-span-6  h-full bg-fuchsia-300">-</button>
                              <button class="col-span-6  h-full bg-blue-400">+</button>
                            </div>
                           
                          </div>
                          <div class="h-16 grid grid-cols-12 gap-4 p-1">
                            <div class="col-span-6">
                              <strong class="text-slate-200 text-sm font-medium ">Coca-cola</strong><br>
                              <span class="text-slate-400 text-sm font-medium ">Solo</span>
                              <strong class="my-auto text-slate-200 text-xs font-medium ">( x <span>  1</span> )</strong>
          
                            </div>
                            <div class="flex justify-center col-span-2  align-middle">
                              <strong class="my-auto text-slate-200 text-sm font-medium ">100</strong>
                            </div>
                            <div class="grid grid-cols-12 col-span-4">
                              <button class="col-span-6  h-full bg-fuchsia-300">-</button>
                              <button class="col-span-6  h-full bg-blue-400">+</button>
                            </div>
                           
                          </div>
                          <div class="h-16 grid grid-cols-12 gap-4 p-1">
                            <div class="col-span-6">
                              <strong class="text-slate-200 text-sm font-medium ">Coca-cola</strong><br>
                              <span class="text-slate-400 text-sm font-medium ">Solo</span>
                              <strong class="my-auto text-slate-200 text-xs font-medium ">( x <span>  1</span> )</strong>
          
                            </div>
                            <div class="flex justify-center col-span-2  align-middle">
                              <strong class="my-auto text-slate-200 text-sm font-medium ">100</strong>
                            </div>
                            <div class="grid grid-cols-12 col-span-4">
                              <button class="col-span-6  h-full bg-fuchsia-300">-</button>
                              <button class="col-span-6  h-full bg-blue-400">+</button>
                            </div>
                           
                          </div>
                          
                        </div>
                       </div>
                       <div class="pt-2 grid grid-rows-6 w-full h-2/4  ">
                        <div class="row-span-2  ">
                          <div class="grid grid-cols-2">
          
                            <div class="justify-self-start ">
                              <strong class="text-slate-200 text-xl font-medium ">Subtotal</strong>
                            </div>
                            <div class="justify-self-end ">
                              <strong class="text-slate-200 text-xl font-medium ">1000.00</strong>
          
                            </div>
          
                           
                          </div>
                          <div class="grid grid-cols-2">
          
                            <div class="justify-self-start ">
                              <strong class="text-slate-200 text-sm font-medium ">Tax</strong>
                            </div>
                            <div class="justify-self-end ">
                              <strong class="text-slate-200 text-sm font-medium ">120.00</strong>
          
                            </div>
          
                           
                          </div>
                          <div class="grid grid-cols-2">
          
                            <div class="justify-self-start ">
                              <strong class="text-slate-200 text-2xl font-medium ">TOTAL</strong>
                            </div>
                            <div class="justify-self-end ">
                              <strong class="text-slate-200 text-2xl font-medium ">1120.00</strong>
          
                            </div>
          
                           
                          </div>
                        </div>
                        <div class="p-auto row-span-1 flex items-center ">
                          <button type="button"  class="m-2 w-full text-gray-50 bg-gradient-to-r from-green-600 to-teal-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-red-400  font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                          Pay</button>
                          <button type="button"  class="w-full m-auto text-gray-50 bg-gradient-to-r from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-red-400  font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                            Pay Later</button>
                        </div>
          
                     
                       </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
            })
        });
    </script>
</x-app-layout>
