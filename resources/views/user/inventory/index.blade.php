<x-app-layout>
    <style>

            #inventoryDiv{
                max-height: calc(100vh - 290px);
            }

            @media (min-width: 768px) {
                #inventoryDiv{
                    max-height: calc(100vh - 270px);
                }
            }

        @media (min-width: 1024px) {
            #inventoryDiv{
                max-height: calc(100vh - 218px);
            }
        }
    </style>

    <div class="p-3 lg:ml-64">
        <header class="bg-white shadow-md rounded-lg">
            <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 grid grid-cols-2">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Inventory
                    </h2>
                </div>
                <div class="justify-self-end md:hidden">
                    <button id="inventoryMenu" data-dropdown-toggle="dropdownInventoryMenu" class="text-white bg-white-700 focus:outline-none font-medium rounded-lg text-sm text-center inline-flex items-center" type="button">
                        <i class="uil uil-ellipsis-v text-black"></i>
                        {{-- Dropdown button
                        <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg> --}}
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownInventoryMenu" class="z-10 hidden divide-y divide-gray-100 px-3">
                        <div class="bg-gray-50 rounded-lg w-44 px-3 border shadow-md">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="inventoryMenu">
                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">ADD</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    
        <div class="pt-3">
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-4">
                <div class="mb-3">
                    <div class="md:grid md:grid-cols-2">
                        <div>
                            <button type="button" class="hidden md:block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 focus:outline-none my-px"><i class="uil uil-plus mr-1"></i>ADD</button>
                        </div>
                        <div class="justify-self-end w-full xl:w-4/5">
                            <form class="w-full">
                                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>
                                    <input type="search" id="default-search" class="block w-full px-4 py-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="SEARCH" required>
                                    <button style="bottom: 5px; right: 5px;" type="submit" class="text-white absolute bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2.5 py-1.5">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="inventoryDiv" class="overflow-auto border rounded-2xl">
                    {{-- TABLE --}}
                        <div class="hidden md:block">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                                Item Name
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
                                        @foreach ($inventories as $inventory)
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $inventory->name }}
                                                </th>
                                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                                    {{ $inventory->category_id }}
                                                </td>
                                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                                    {{ $inventory->quantity }}
                                                </td>
                                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                                    {{ $inventory->price }}
                                                </td>
                                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                                    <a href="#" class="text-blue-600 hover:underline font-semibold text-sm">Edit</a> | <a href="#" class="text-red-600 hover:underline font-semibold text-sm">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    {{-- TABLE END --}}

                    {{-- INVENTORY LIST SMALL DEVICE --}}
                        <div class="md:hidden">
                            <div id="accordion-collapse" data-accordion="collapse">
                                @php
                                    $x = 1;
                                    foreach ($inventories as $inventory) {
                                        if($x == 1){
                                            echo '
                                                <h2 id="accordion-collapse-heading-'.$x.'">
                                                    <button type="button" class="flex items-center justify-between w-full px-3 py-1.5 text-sm font-semibold text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl hover:bg-gray-100" data-accordion-target="#accordion-collapse-body-'.$x.'" aria-expanded="false" aria-controls="accordion-collapse-body-'.$x.'">
                                                        <span>'.$inventory->name.'</span>
                                                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                    </button>
                                                </h2>
                                                <div id="accordion-collapse-body-'.$x.'" class="hidden" aria-labelledby="accordion-collapse-heading-'.$x.'">
                                                    <div class="px-3 py-1.5 font-light border border-b-0 border-gray-200">
                                                        <div class="grid grid-cols-3">
                                                            <div class="text-xs leading-5">Category</div>
                                                            <div class="col-span-2 font-semibold text-sm">
                                                                '.$inventory->category_id.'
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-3">
                                                            <div class="text-xs leading-5">Quantity</div>
                                                            <div class="col-span-2 font-semibold text-sm">
                                                                '.$inventory->quantity.'
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-3">
                                                            <div class="text-xs leading-5">Price</div>
                                                            <div class="col-span-2 font-semibold text-sm">
                                                                ₱ '.number_format($inventory->price, 2, '.', ',').'
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-3">
                                                            <div class="text-xs leading-5">Action</div>
                                                            <div class="col-span-2">
                                                                <a href="#" class="text-blue-600 hover:underline font-semibold text-sm">Edit</a> | 
                                                                <a href="#" class="text-red-600 hover:underline font-semibold text-sm">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ';
                                        }else if($x == $inventories->count()){
                                            echo '
                                                <h2 id="accordion-collapse-heading-'.$x.'">
                                                    <button type="button" class="flex items-center justify-between w-full px-3 py-1.5 text-sm font-medium text-left text-gray-500 border border-gray-200 hover:bg-gray-100" data-accordion-target="#accordion-collapse-body-'.$x.'" aria-expanded="false" aria-controls="accordion-collapse-body-'.$x.'">
                                                        <span>'.$inventory->name.'</span>
                                                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                    </button>
                                                </h2>
                                                <div id="accordion-collapse-body-'.$x.'" class="hidden" aria-labelledby="accordion-collapse-heading-'.$x.'">
                                                    <div class="px-3 py-1.5 font-light border border-t-0 border-gray-200 rounded-b-xl">
                                                        <div class="grid grid-cols-3 content-center">
                                                            <div class="text-xs leading-5">Category</div>
                                                            <div class="col-span-2 font-semibold text-sm">
                                                                '.$inventory->category_id.'
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-3">
                                                            <div class="text-xs leading-5">Quantity</div>
                                                            <div class="col-span-2 font-semibold text-sm">
                                                                '.$inventory->quantity.'
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-3">
                                                            <div class="text-xs leading-5">Price</div>
                                                            <div class="col-span-2 font-semibold text-sm">
                                                                ₱ '.number_format($inventory->price, 2, '.', ',').'
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-3">
                                                            <div>Action</div>
                                                            <div class="col-span-2">
                                                                <a href="#" class="text-blue-600 hover:underline font-semibold text-sm">Edit</a> | 
                                                                <a href="#" class="text-red-600 hover:underline font-semibold text-sm">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ';
                                        }else{
                                            echo '
                                                <h2 id="accordion-collapse-heading-'.$x.'">
                                                    <button type="button" class="flex items-center justify-between w-full px-3 py-1.5 text-sm font-medium text-left text-gray-500 border border-b-0 border-gray-200 hover:bg-gray-100" data-accordion-target="#accordion-collapse-body-'.$x.'" aria-expanded="false" aria-controls="accordion-collapse-body-'.$x.'">
                                                        <span>'.$inventory->name.'</span>
                                                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                    </button>
                                                </h2>
                                                <div id="accordion-collapse-body-'.$x.'" class="hidden" aria-labelledby="accordion-collapse-heading-'.$x.'">
                                                    <div class="px-3 py-1.5 font-light border border-b-0 border-gray-200">
                                                        <div class="grid grid-cols-3 content-center">
                                                            <div class="text-xs leading-5">Category</div>
                                                            <div class="col-span-2 font-semibold text-sm">
                                                                '.$inventory->category_id.'
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-3">
                                                            <div class="text-xs leading-5">Quantity</div>
                                                            <div class="col-span-2 font-semibold text-sm">
                                                                '.$inventory->quantity.'
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-3">
                                                            <div class="text-xs leading-5">Price</div>
                                                            <div class="col-span-2 font-semibold text-sm">
                                                                ₱ '.number_format($inventory->price, 2, '.', ',').'
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-3">
                                                            <div class="text-xs leading-5">Action</div>
                                                            <div class="col-span-2">
                                                                <a href="#" class="text-blue-600 hover:underline font-semibold text-sm">Edit</a> | 
                                                                <a href="#" class="text-red-600 hover:underline font-semibold text-sm">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ';
                                        }
                                        $x++;
                                    }
                                @endphp

                                @foreach ($inventories as $inventory)
                                    
                                @endforeach


                                {{-- <h2 id="accordion-collapse-heading-3">
                                    <button type="button" class="flex items-center justify-between w-full px-3 py-1.5 text-sm font-medium text-left text-gray-500 border border-b-0 border-gray-200 hover:bg-gray-100" data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                        <span>Magic Mouse 2</span>
                                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                    <div class="px-3 py-1.5 font-light border border-b-0 border-gray-200">
                                        <div class="grid grid-cols-3 content-center">
                                            <div class="text-xs leading-5">Color</div>
                                            <div class="col-span-2 font-semibold text-sm">
                                                Black
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3">
                                            <div class="text-xs leading-5">Category</div>
                                            <div class="col-span-2 font-semibold text-sm">
                                                Accessories
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3">
                                            <div class="text-xs leading-5">Price</div>
                                            <div class="col-span-2 font-semibold text-sm">
                                                $99.00
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3">
                                            <div class="text-xs leading-5">Action</div>
                                            <div class="col-span-2">
                                                <a href="#" class="text-blue-600 hover:underline font-semibold text-sm">Edit</a> | 
                                                <a href="#" class="text-red-600 hover:underline font-semibold text-sm">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h2 id="accordion-collapse-heading-4">
                                    <button type="button" class="flex items-center justify-between w-full px-3 py-1.5 text-sm font-medium text-left text-gray-500 border border-gray-200 hover:bg-gray-100" data-accordion-target="#accordion-collapse-body-4" aria-expanded="false" aria-controls="accordion-collapse-body-4">
                                        <span>Google Pixel Phone</span>
                                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-4" class="hidden" aria-labelledby="accordion-collapse-heading-4">
                                    <div class="px-3 py-1.5 font-light border border-b-0 border-gray-200">
                                        <div class="grid grid-cols-3 content-center">
                                            <div class="text-xs leading-5">Color</div>
                                            <div class="col-span-2 font-semibold text-sm">
                                                Gray
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3">
                                            <div class="text-xs leading-5">Category</div>
                                            <div class="col-span-2 font-semibold text-sm">
                                                Phone
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3">
                                            <div class="text-xs leading-5">Price</div>
                                            <div class="col-span-2 font-semibold text-sm">
                                                $799.00
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3">
                                            <div class="text-xs leading-5">Action</div>
                                            <div class="col-span-2">
                                                <a href="#" class="text-blue-600 hover:underline font-semibold text-sm">Edit</a> | 
                                                <a href="#" class="text-red-600 hover:underline font-semibold text-sm">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                
                            </div>
                        </div>
                    {{-- INVENTORY LIST SMALL DEVICE END --}}
                </div>

                {{-- PAGINATION --}}
                <div class="grid md:grid-cols-2 mt-3 px-3">

                    <div class="justify-self-center md:justify-self-start self-center">
                        <span class="text-sm text-gray-700">
                            Showing <span class="font-semibold text-gray-900">1</span> to <span class="font-semibold text-gray-900">10</span> of <span class="font-semibold text-gray-900">100</span> Entries
                        </span>
                    </div>

                    <div class="justify-self-center md:justify-self-end">
                        <nav aria-label="Page navigation example" class="h-8 mb-0.5 shadow-xl">
                            <ul class="inline-flex items-center -space-x-px">
                                <li>
                                    <a href="#" class="block w-9 h-9 leading-9 text-center text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
                                        <i class="uil uil-angle-left-b"></i>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li>
                                    <p class="block w-9 h-9 leading-9 text-center z-10 text-gray-500 border border-gray-300 bg-white font-semibold">1</p>
                                </li>
                                <li>
                                    <a href="#" class="block w-9 h-9 leading-9 text-center text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
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
</x-app-layout>
