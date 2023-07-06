<x-app-layout>
    @section('page_title', 'MENU SETUP')
    
    {{-- DELETE MODAL --}}
        <!-- Modal toggle -->
        {{-- <button data-modal-target="itemDeleteModal" data-modal-toggle="itemDeleteModal" class="hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
            Toggle modal
        </button> --}}
        
        <!-- Main modal -->
        <div id="itemDeleteModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
            <div class="relative w-full h-full max-w-2xl md:h-auto">
                <!-- Modal content -->
                <div class="absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 w-full max-w-md bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between px-4 py-2 border-b rounded-t">
                        <h3 class="font-semibold text-gray-900 flex items-center">
                            <i class="uil uil-exclamation-triangle mr-2 text-xl md:text-2xl lg:text-3xl text-red-700"></i>
                            <span class="text-red-700 text-base md:text-lg lg:text-xl">Delete Item</span>
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="itemDeleteModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="px-6 py-3 md:py-6 space-y-6">
                        <p class="text-xs md:text-base leading-relaxed text-gray-500">
                            Are you sure you want to delete this item?
                        </p>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center px-6 py-3 space-x-2 border-t border-gray-200 rounded-b">
                        <a type="button" href="" class="deleteConfirm w-24 text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Yes</a>
                        <button data-modal-hide="itemDeleteModal" type="button" class="w-24 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- DELETE MODAL END --}}
    
    {{-- MOVE MODAL --}}
        <!-- Modal toggle -->
        {{-- <button data-modal-target="itemDeleteModal" data-modal-toggle="itemDeleteModal" class="hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
            Toggle modal
        </button> --}}
        
        <!-- Main modal -->
        <div id="moveMenuModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
            <div class="relative w-full h-full max-w-2xl md:h-auto">
                <!-- Modal content -->
                <form method="POST" action="{{ route('menu.move') }}" class="absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 w-full max-w-md bg-white rounded-lg shadow">
                    @csrf
                    <!-- Modal header -->
                    <div class="flex items-center justify-between px-4 py-2 border-b rounded-t">
                        <h3 class="font-semibold text-gray-900 flex items-center">
                            {{-- <i class="uil uil-exclamation-triangle mr-2 text-xl md:text-2xl lg:text-3xl text-yellow-400"></i> --}}
                            <span class="text-emerald-600 text-base md:text-lg lg:text-xl">Move Menu to Inventory</span>
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="moveMenuModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="px-6 py-3 md:py-6 space-y-6">
                        <input type="hidden" id="moveSlug" name="moveSlug">
                        <div class="mb-6">
                            <label for="moveServings" class="block mb-2 text-sm font-medium text-gray-900">Servings</label>
                            <input type="number" id="moveServings" name="moveServings" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 appearance-none" autocomplete="off" min="1" max="" required>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center px-6 py-3 space-x-2 border-t border-gray-200 rounded-b">
                        <button type="submit" class="moveConfirm w-24 text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Submit</button>
                        <button data-modal-hide="moveMenuModal" type="button" class="w-24 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    {{-- MOVE MODAL END --}}

    {{-- SUCCESS NOTIFICATION --}}
        @if (session('message'))
            <div class="notif absolute left-1/2 top-14 -translate-x-1/2 w-96 h-12 bg-emerald-200 rounded-lg z-50 shadow-md shadow-emerald-800 flex flex-row justify-between px-2">
                <div class="flex">
                    <i class="self-center uil uil-cloud-check text-emerald-800 text-2xl"></i>
                    <h1 class="self-center text-emerald-800 font-semibold ml-1">{{ session('message') }}</h1>
                </div>
                <button class="notifButton self-center">
                    <i class="uil uil-times text-2xl text-emerald-800"></i>
                </button>
            </div>
        @endif
    {{-- SUCCESS NOTIFICATION END --}}

    {{-- ERROR NOTIFICATION --}}
        @if (session('error'))
            <div class="notif absolute left-1/2 top-14 -translate-x-1/2 w-96 h-12 bg-red-200 rounded-lg z-50 shadow-md shadow-red-800 flex flex-row justify-between px-2">
                <div class="flex">
                    <i class="self-center uil uil-cloud-check text-red-800 text-2xl"></i>
                    <h1 class="self-center text-red-800 font-semibold ml-1">{{ session('error') }}</h1>
                </div>
                <button class="notifButton self-center">
                    <i class="uil uil-times text-2xl text-red-800"></i>
                </button>
            </div>
        @endif
    {{-- ERROR NOTIFICATION END --}}

    {{-- QUANTITY CHANGING SIDEBAR --}}
        <button data-drawer-target="addServingModal" data-drawer-toggle="addServingModal" aria-controls="addServingModal" type="button" id="addServingButton" class="hidden">
        </button>
            
        <aside id="addServingModal" data-drawer-backdrop="static" tabindex="-1" class="fixed top-0 left-1/4 lg:left-1/4 z-40 w-3/4 lg:w-3/4 h-screen transition-transform translate-x-full" aria-label="Sidebar">
            <form method="POST" action="{{ route('menu.changeqty') }}" class="h-full px-4 py-4 overflow-y-auto bg-gray-50 relative">
                @csrf
                <input type="hidden" id="counter" name="counter" value="1">
                <h1 id="menuName" class="font-bold text-3xl tracking-wider">MENU NAME</h1>
                <div class="grid grid-cols-2 mt-5 mb-1 w-full">
                    <input type="hidden" id="slug" name="slug">
                    <p class="font-bold text-2xl tracking-wide">Servings</p>
                    <div class="flex flex-row-reverse items-center rounded-lg text-center">
                        <button id="incQty" type="button">
                            <i class="uil uil-plus-circle text-3xl text-blue-500"></i>
                        </button>
                        <div class="text-2xl mx-2">
                            <input type="text" id="servings" name="servings" value="" class="w-14 p-0 h-9 bg-gray-50 text-center" autocomplete="off">
                        </div>
                        <button id="decQty" type="button">
                            <i class="uil uil-minus-circle text-3xl text-red-500"></i>
                        </button>
                    </div>
                </div>
                <div class="">
                    <h2 class="font-bold text-2xl tracking-wide">INGREDIENTS</h2>
                    <div id="ingredients" class="">
                    </div>

                    <div class="mt-5">

                        <div class="mt-7 mb-2 flex items-center">
                            <h2 class="font-bold text-xl italic tracking-wide mr-5">ADDITIONALS</h2>
                            <button id="addButton" type="button" class="text-3xl text-blue-500"><i class="uil uil-plus-circle"></i></button>
                        </div>
    
                        <div class="mb-2 flex flex-row gap-x-3 h-6">
                            <div class="w-2/5 text-center">
                                <label class="block font-medium text-gray-900">Name</label>
                            </div>
                            <div class="w-2/5 text-center">
                                <label class="block font-medium text-gray-900">Quantity</label>
                            </div>
                            <div class="w-1/5 flex">
                                <div class="w-1/2"></div>
                                <div class="w-1/2 text-center">Remove</div>
                            </div>
                        </div>

                        <div id="addDiv">

                        </div>

                    </div>
                </div>
                <div class="float-right mt-5">
                    <button type="submit" data-drawer-hide="addServingModal" class="text-white bg-blue-500 hover:bg-blue-600 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 focus:outline-none">Proceed</button>
                    <button type="button" data-drawer-hide="addServingModal" class="text-white bg-gray-500 hover:bg-gray-600 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">Cancel</button>
                </div>
            </form>
        </aside>
    {{-- QUANTITY CHANGING SIDEBAR END --}}

    <div class="">
        <div style="height: calc(100vh - 48px);" class="flex {{ auth()->user()->role == 1 ? 'lg:ml-64 lg:pt-3' : '' }}">
            <div id="contentDiv" class="p-2 w-full">
                <div class="bg-white overflow-hidden shadow-md rounded-lg p-4">
                    {{-- CONTROLS --}}
                        <div class="mb-3">
                            <div class="md:grid md:grid-cols-2">
                                <div class=" w-24">
                                    <a href="{{ route('menu.add') }}" class="hidden md:block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 focus:outline-none my-px"><i class="uil uil-plus mr-1"></i>ADD</a>
                                </div>
                                <div class="justify-self-end w-full xl:w-4/5">
                                    <form method="GET" action="" id="searchForm" class="w-full">
                                        <label for="searchInput" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                            </div>
                                            <input type="search" id="searchInput" class="block w-full px-4 py-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="SEARCH" value="{{ $search }}" autocomplete="off">
                                            <button id="clearButton" type="button" class=" absolute right-20 bottom-1">
                                                <i class="uil uil-times text-2xl"></i>
                                            </button>
                                            <button id="searchButton" type="button" style="bottom: 5px; right: 5px;" type="submit" class="text-white absolute bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2.5 py-1.5">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    {{-- CONTROLS END --}}
    
                    <div>
                        {{-- TABLE --}}
                            <div class="hidden md:block">
                                <div id="menuTable" class="w-full shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-left text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                                    Menu Name
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center whitespace-nowrap">
                                                    Category
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center whitespace-nowrap">
                                                    Quantity
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center whitespace-nowrap">
                                                    Price
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center whitespace-nowrap">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($menus as $menu)
                                                <tr class="addServing bg-white border-b cursor-pointer hover:bg-slate-50">
                                                    <th scope="row" class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                        {{ $menu->name }}
                                                    </th>
                                                    <td class="px-6 py-3 text-center whitespace-nowrap">
                                                        {{ $menu->category }}
                                                    </td>
                                                    <td class="px-6 py-3 text-center whitespace-nowrap flex justify-center items-center">
                                                        {{-- <button data-slug="{{$menu->slug}}" data-modal-target="changeQtyModal" data-modal-toggle="changeQtyModal" data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" class="addQuantity mr-2"><i class="uil uil-plus-circle text-xl text-blue-500 flex"></i></button> --}}
                                                        
                                                        <span data-slug="{{$menu->slug}}" class="flex">{{ $menu->quantity }}</span>

                                                        {{-- <button data-slug="{{$menu->slug}}" data-modal-target="changeQtyModal" data-modal-toggle="changeQtyModal" class="reduceQuantity ml-2"><i class="uil uil-minus-circle text-xl text-red-500 flex"></i></button> --}}
                                                    </td>
                                                    <td class="px-6 py-3 text-center whitespace-nowrap">
                                                        {{ '₱ '.number_format($menu->price, 2, '.', ',') }}
                                                    </td>
                                                    <td class="px-6 py-3 text-center whitespace-nowrap">
                                                        <a type="button" data-modal-target="moveMenuModal" data-modal-toggle="moveMenuModal" data-slug="{{ $menu->slug }}" data-quantity="{{ $menu->quantity }}" class="moveButton text-teal-600 hover:underline font-semibold text-sm">Move</a> | 
                                                        <a href="{{ url('/menu/edit/'.$menu->slug) }}" class="editButton text-blue-600 hover:underline font-semibold text-sm">Setup</a> | <a type="button" data-modal-target="itemDeleteModal" data-modal-toggle="itemDeleteModal" data-slug="{{ $menu->slug }}" class="deleteButton text-red-600 hover:underline font-semibold text-sm cursor-pointer">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        {{-- TABLE END --}}
    
                        {{-- INVENTORY LIST SMALL DEVICE --}}
                            <div id="menuMobile" class="overflow-auto md:hidden">
                                <div id="accordion-collapse" data-accordion="collapse">
                                    @php
                                        $x = 1;
                                        foreach ($menus as $menu) {
                                            if($x == 1){
                                                echo '
                                                    <h2 id="accordion-collapse-heading-'.$x.'">
                                                        <button type="button" class="flex items-center justify-between w-full px-3 py-1.5 text-sm font-semibold text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl hover:bg-gray-100" data-accordion-target="#accordion-collapse-body-'.$x.'" aria-expanded="false" aria-controls="accordion-collapse-body-'.$x.'">
                                                            <span>'.$menu->name.'</span>
                                                            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                        </button>
                                                    </h2>
                                                    <div id="accordion-collapse-body-'.$x.'" class="hidden" aria-labelledby="accordion-collapse-heading-'.$x.'">
                                                        <div class="px-3 py-1.5 font-light border border-b-0 border-gray-200">
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Category</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    '.$menu->category.'
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Quantity</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    '.$menu->quantity.'
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Price</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    ₱ '.number_format($menu->price, 2, '.', ',').'
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Action</div>
                                                                <div class="col-span-2">
                                                                    <a href="'.url('/menu/edit/'.$menu->slug).'" class="text-blue-600 hover:underline font-semibold text-sm">Setup</a> | 
                                                                    <a type="button" data-modal-target="itemDeleteModal" data-modal-toggle="itemDeleteModal" data-slug="'.$menu->slug.'" class="deleteButton text-red-600 hover:underline font-semibold text-sm">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ';
                                            }else if($x == $menus->count()){
                                                echo '
                                                    <h2 id="accordion-collapse-heading-'.$x.'">
                                                        <button type="button" class="flex items-center justify-between w-full px-3 py-1.5 text-sm font-medium text-left text-gray-500 border border-gray-200 hover:bg-gray-100" data-accordion-target="#accordion-collapse-body-'.$x.'" aria-expanded="false" aria-controls="accordion-collapse-body-'.$x.'">
                                                            <span>'.$menu->name.'</span>
                                                            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                        </button>
                                                    </h2>
                                                    <div id="accordion-collapse-body-'.$x.'" class="hidden" aria-labelledby="accordion-collapse-heading-'.$x.'">
                                                        <div class="px-3 py-1.5 font-light border border-t-0 border-gray-200 rounded-b-xl">
                                                            <div class="grid grid-cols-3 content-center">
                                                                <div class="text-xs leading-5">Category</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    '.$menu->category.'
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Quantity</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    '.$menu->quantity.'
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Price</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    ₱ '.number_format($menu->price, 2, '.', ',').'
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-3">
                                                                <div>Action</div>
                                                                <div class="col-span-2">
                                                                    <a href="'.url('/menu/edit/'.$menu->slug).'" class="text-blue-600 hover:underline font-semibold text-sm">Setup</a> | 
                                                                    <a type="button" data-modal-target="itemDeleteModal" data-modal-toggle="itemDeleteModal" data-slug="'.$menu->slug.'" class="deleteButton text-red-600 hover:underline font-semibold text-sm">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ';
                                            }else{
                                                echo '
                                                    <h2 id="accordion-collapse-heading-'.$x.'">
                                                        <button type="button" class="flex items-center justify-between w-full px-3 py-1.5 text-sm font-medium text-left text-gray-500 border border-b-0 border-gray-200 hover:bg-gray-100" data-accordion-target="#accordion-collapse-body-'.$x.'" aria-expanded="false" aria-controls="accordion-collapse-body-'.$x.'">
                                                            <span>'.$menu->name.'</span>
                                                            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                        </button>
                                                    </h2>
                                                    <div id="accordion-collapse-body-'.$x.'" class="hidden" aria-labelledby="accordion-collapse-heading-'.$x.'">
                                                        <div class="px-3 py-1.5 font-light border border-b-0 border-gray-200">
                                                            <div class="grid grid-cols-3 content-center">
                                                                <div class="text-xs leading-5">Category</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    '.$menu->category.'
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Quantity</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    '.$menu->quantity.'
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Price</div>
                                                                <div class="col-span-2 font-semibold text-sm">
                                                                    ₱ '.number_format($menu->price, 2, '.', ',').'
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-3">
                                                                <div class="text-xs leading-5">Action</div>
                                                                <div class="col-span-2">
                                                                    <a href="'.url('/menu/edit/'.$menu->slug).'" class="text-blue-600 hover:underline font-semibold text-sm">Setup</a> | 
                                                                    <a type="button" data-modal-target="itemDeleteModal" data-modal-toggle="itemDeleteModal" data-slug="'.$menu->slug.'" class="deleteButton text-red-600 hover:underline font-semibold text-sm">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ';
                                            }
                                            $x++;
                                        }
                                    @endphp
                                </div>
                            </div>
                        {{-- INVENTORY LIST SMALL DEVICE END --}}
                    </div>
    
                    {{-- PAGINATION --}}
                        <div class="grid md:grid-cols-2 mt-3 px-3">
                            @php
                                $prev = $page - 1;
                                $next = $page + 1;
                                $from = ($prev * 100) + 1;
                                $to = $page * 100;
                                if($to > $menuCount){
                                    $to = $menuCount;
                                }if($menuCount == 0){
                                    $from = 0;
                                }
                            @endphp
                            <div class="justify-self-center md:justify-self-start self-center">
                                <span class="text-sm text-gray-700">
                                    Showing <span class="font-semibold text-gray-900">{{ $from }}</span> to <span class="font-semibold text-gray-900">{{ $to }}</span> of <span class="font-semibold text-gray-900">{{ $menuCount }}</span> Items
                                </span>
                            </div>
    
                            <div class="justify-self-center md:justify-self-end">
                                <nav aria-label="Page navigation example" class="h-8 mb-0.5 shadow-xl">
                                    <ul class="inline-flex items-center -space-x-px">
                                        <li>
                                            <a href="{{ ($search == '') ? url('/menu/'.$prev) : url('/menu/'.$prev.'/'.$search);  }}"  class="{{ ($page == 1) ? 'pointer-events-none' : ''; }} block w-9 h-9 leading-9 text-center text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
                                                <i class="uil uil-angle-left-b"></i>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <li>
                                            <p class="block w-9 h-9 leading-9 text-center z-10 text-gray-500 border border-gray-300 bg-white font-semibold">{{ $page }}</p>
                                        </li>
                                        <li>
                                            <a href="{{ ($search == '') ? url('/menu/'.$next) : url('/menu/'.$next.'/'.$search); }}" class="{{ ($to == $menuCount) ? 'pointer-events-none' : ''; }} block w-9 h-9 leading-9 text-center text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                                                <i class="uil uil-angle-right-b"></i>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    {{-- PAGINATION END --}}
    
    
                </div>
            </div>
        </div>
     </div>

    <script>
        $(document).ready(function() {

            var counter = 2;

            jQuery(document).on( "click", ".select-btn", function(e){
                $('.content').not($(this).closest('.wrapper').find('.content')).addClass('hidden');
                $(this).closest('.wrapper').find('.content').toggleClass('hidden');
                $(this).closest('.wrapper').find('.uil-angle-down').toggleClass('-rotate-180');
                e.stopPropagation();
            });

            function searchFilter(searchInput){
                $(".listOption li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchInput) > -1)
                });
            }

            jQuery(document).on( "click", ".content", function(e){
                e.stopPropagation();
            });

            jQuery(document).on( "input", ".selectSearch", function(){
                var value = $(this).val().toLowerCase();
                searchFilter(value);
            });

            jQuery(document).on( "click", ".listOption li", function(){
                var id = $(this).data('id');
                    var name = $(this).data('name');
                var unitid = 'unit' + $(this).data('idnum');
                var qtyid = 'quantity' + $(this).data('idnum');

                if(id == ""){
                    $(this).closest('.wrapper').find('input').val(id);
                    $(this).closest('.wrapper').find('.select-btn span').html(name);
                    $('.content').addClass('hidden');
                    $('.selectSearch').val('');
                    var value = $(".selectSearch").val().toLowerCase();
                    searchFilter(value);

                    $('#' + unitid).html('');
                    $('#' + qtyid).val('');
                }else{
                    var unit = $(this).data('unit');
                    $(this).closest('.wrapper').find('input').val(id);
                    $(this).closest('.wrapper').find('.select-btn span').html(name);
                    $('.content').addClass('hidden');
                    $('.selectSearch').val('');
                    var value = $(".selectSearch").val().toLowerCase();
                    searchFilter(value);

                    $('#' + unitid).html(unit);
                    $('#' + qtyid).val('');
                }

                $('.uil-angle-down').removeClass('-rotate-180');
            });

            $('#searchButton').click(function(){
                var search = $('#searchInput').val();
                if(search != ""){
                    $('#searchForm').prop('action', `{{ url('/menu/1/${search}') }}`);
                }else{
                    $('#searchForm').prop('action', `{{ url('/menu/1') }}`);
                }
                $('#searchForm').submit();
            });

            $('#searchInput').on('keydown', function(event) {
                if (event.keyCode === 13) {
                    $('#searchButton').click();
                    event.preventDefault();
                }
            });

            $('#clearButton').click(function(){
                $('#searchInput').val('');
            });

            $('.notifButton').click(function(){
                $('.notif').addClass('hidden');
            });

            $('.deleteButton').click(function(){
                var slug = $(this).data('slug');
                $('.deleteConfirm').prop('href', `{{ url('/menu/delete/${slug}') }}`);
            });

            $('.contentDiv').click(function(){
                $('.notif').addClass('hidden');
            });

            $('#incQty').click(function(){
                var qty = $('#servings').val();
                qty++;
                $('#servings').val(qty);

                var slug = $('#slug').val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url:"{{ route('menu.computeqty') }}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        slug: slug,
                        qty: qty,
                        _token: _token
                    },
                    success:function(result){
                        $('#ingredients').html(result.ingredients);
                    }
                })
            });

            $('#decQty').click(function(){
                var qty = $('#servings').val();
                qty--;
                if(qty > 0){
                    $('#servings').val(qty);
                }else{
                    qty++;
                }

                var slug = $('#slug').val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url:"{{ route('menu.computeqty') }}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        slug: slug,
                        qty: qty,
                        _token: _token
                    },
                    success:function(result){
                        $('#ingredients').html(result.ingredients);
                    }
                })
            });

            $('#servings').on('keyup', function() {
                var qty = $(this).val().replace(/[^0-9]/g, '');
                $(this).val(qty);
                if(qty == ''){
                    $(this).val(1);
                }

                if(qty < 1){
                    $('#servings').val(1);
                    qty = 1;
                }

                var slug = $('#slug').val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url:"{{ route('menu.computeqty') }}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        slug: slug,
                        qty: qty,
                        _token: _token
                    },
                    success:function(result){
                        $('#ingredients').html(result.ingredients);
                    }
                })
            });

            $('.addServing').click(function(){
                if (!$(event.target).is('.deleteButton') && !$(event.target).is('.editButton') && !$(event.target).is('.moveButton')) {
                    var slug = $(this).find('span').data('slug');
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url:"{{ route('menu.view') }}",
                        method:"POST",
                        dataType: 'json',
                        data:{
                            slug: slug,
                            _token: _token
                        },
                        success:function(result){
                            $('#menuName').html(result.name);
                            $('#ingredients').html(result.ingredients);
                            $('#servings').val(result.servings);
                            $('#slug').val(slug);
                            $('#addServingButton').click();
                            $('#addDiv').html(`
                            <div id="ing1" class="mb-5 flex flex-row gap-x-3">
                                <div class="w-2/5">
                                    <div class="wrapper w-full relative">
                                        <div class="select-btn flex items-center justify-between rounded-md bg-gray-100 border border-gray-300 p-2 h-9 cursor-pointer">
                                            <span></span>
                                            <i class="uil uil-angle-down text-2xl transition-transform duration-300"></i>
                                        </div>
                                        <div class="content bg-gray-100 mt-1 rounded-md p-3 hidden absolute w-full z-50">
                                            <div class="search relative">
                                                <i class="uil uil-search absolute left-3 leading-9 text-gray-500"></i>
                                                <input type="text" class="selectSearch w-full leading-9 text-gray-700 rounded-md pl-9 outline-none h-9" placeholder="Search">
                                            </div>
                                            <ul class="listOption options mt-2 max-h-52 overflow-y-auto">
                                                <li data-id="" data-name="" data-idnum="1" class="h-9 cursor-pointer hover:bg-gray-300 rounded-md flex items-center pl-3 leading-9">None</li>
                                                @foreach ($items as $item)
                                                    <li data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-unit="{{ $item->unit }}" data-idnum="1" class="h-9 cursor-pointer hover:bg-gray-300 rounded-md flex items-center pl-3 leading-9">{{ $item->name }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <input type="hidden" name="item1" value="">
                                    </div>
                                </div>
                                <div class="w-2/5">
                                    <input type="text" id="quantity1" name="quantity1" value="{{ old('quantity') }}" class="quantity block w-full h-9 px-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base text-center" autocomplete="off">
                                </div>
                                <div class="w-1/5 flex">
                                    <div id="unit1" class="w-1/2 text-lg leading-9"></div>
                                    <button type="button" data-thisid="ing1" class="removeButton w-1/2 text-center"><i class="uil uil-minus-circle text-red-500 text-3xl"></i></button>
                                </div>
                            </div>`);
                        }
                    })
                }
            });

            $('#addButton').click(function(){
                $('#counter').val(counter);
                $('#addDiv').append(`
                    <div id="ing${counter}" class="mb-5 flex flex-row gap-x-3">
                        <div class="w-2/5">
                            <div class="wrapper w-full relative">
                                <div class="select-btn flex items-center justify-between rounded-md bg-gray-100 border border-gray-300 p-2 h-9 cursor-pointer">
                                    <span></span>
                                    <i class="uil uil-angle-down text-2xl transition-transform duration-300"></i>
                                </div>
                                <div class="content bg-gray-100 mt-1 rounded-md p-3 hidden absolute w-full z-50">
                                    <div class="search relative">
                                        <i class="uil uil-search absolute left-3 leading-9 text-gray-500"></i>
                                        <input type="text" class="selectSearch w-full leading-9 text-gray-700 rounded-md pl-9 outline-none h-9" placeholder="Search">
                                    </div>
                                    <ul class="listOption options mt-2 max-h-52 overflow-y-auto">
                                        <li data-id="" data-code="None" class="h-9 cursor-pointer hover:bg-gray-300 rounded-md flex items-center pl-3 leading-9">None</li>
                                        @foreach ($items as $item)
                                            <li data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-unit="{{ $item->unit }}" data-idnum="${counter}" class="h-9 cursor-pointer hover:bg-gray-300 rounded-md flex items-center pl-3 leading-9">{{ $item->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" name="item${counter}" value="">
                            </div>
                        </div>
                        <div class="w-2/5">
                            <input type="text" id="quantity${counter}" name="quantity${counter}" value="{{ old('quantity') }}" class="quantity block w-full h-9 px-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base text-center">
                        </div>
                        <div class="w-1/5 flex">
                            <div id="unit${counter}" class="w-1/2 text-lg leading-9"></div>
                            <button type="button" data-thisid="ing${counter}" class="removeButton w-1/2 text-center"><i class="uil uil-minus-circle text-red-500 text-3xl"></i></button>
                        </div>
                    </div>
                `);
                counter++;
            });

            jQuery(document).on( "click", ".removeButton", function(){
                var thisid = $(this).data('thisid');
                $('#'+thisid).remove();
            });

            jQuery(document).on( "keyup", "#quantity", function(){
                var val = $(this).val().replace(/[^0-9]/g, '');
                $(this).val(val);
                if(val == ''){
                    $('#addQtyButton').prop('disabled', true);
                }else{
                    $('#addQtyButton').prop('disabled', false);
                }
            });

            $('.moveButton').click(function(){
                var slug = $(this).data('slug');
                var quantity = $(this).data('quantity');

                $('#moveSlug').val(slug);
                $('#moveServings').val(1);
                $('#moveServings').attr('max', quantity);
            });
        });
    </script>
</x-app-layout>
