<nav x-data="{ open: false }" id="topNav" class="sticky top-0 z-50 w-full bg-white shadow-md">
    <div class="lg:hidden flex flex-row {{ (url()->current() == url('/inventory')) ? 'justify-between md:justify-start' : ''; }} ">
        <button id="navButton" data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center h-12 p-2 ml-3 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
        </button>
    
        <div class="self-center">
            <h2 class="ml-3 text-base font-semibold leading-tight text-gray-600">
                @yield('page_title')
            </h2>
        </div>

        {{-- INVENTORY ADD --}}
            @if (url()->current() != url('/inventory/add') && url()->current() != url('/inventory/edit') && Str::contains(url()->current(), url('/inventory')))
                <div class="self-center float-right ml-auto md:hidden">
                    <button id="inventoryMenu" data-dropdown-toggle="dropdownInventoryMenu" class="inline-flex items-center h-8 text-base font-medium text-center text-white rounded-lg w-7 bg-white-700 focus:outline-none" type="button">
                        <i class="text-black uil uil-ellipsis-v"></i>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownInventoryMenu" class="z-10 hidden px-3 divide-y divide-gray-100">
                        <div class="px-3 border rounded-lg shadow-md bg-gray-50 w-44">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="inventoryMenu">
                                <li>
                                    <a href="{{ route('inventory.add') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">ADD</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        {{-- INVENTORY ADD END --}}

        {{-- USER ADD --}}
            @if (url()->current() != url('/system-management/user/add') && !Str::contains(url()->current(), url('/system-management/user/edit/')) && Str::contains(url()->current(), url('/system-management/user')))
                <div class="self-center float-right ml-auto md:hidden">
                    <button id="inventoryMenu" data-dropdown-toggle="dropdownInventoryMenu" class="inline-flex items-center h-8 text-base font-medium text-center text-white rounded-lg w-7 bg-white-700 focus:outline-none" type="button">
                        <i class="text-black uil uil-ellipsis-v"></i>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownInventoryMenu" class="z-50 hidden px-3 divide-y divide-gray-100">
                        <div class="px-3 border rounded-lg shadow-md bg-gray-50 w-44">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="inventoryMenu">
                                <li>
                                    <a href="{{ route('user.add') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">ADD</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        {{-- USER ADD END --}}

        {{-- TABLE ADD --}}
            @if (url()->current() != url('/system-management/table/add') && !Str::contains(url()->current(), url('/system-management/table/edit')) && Str::contains(url()->current(), url('/system-management/table')))
                <div class="self-center float-right ml-auto md:hidden">
                    <button id="inventoryMenu" data-dropdown-toggle="dropdownInventoryMenu" class="inline-flex items-center h-8 text-base font-medium text-center text-white rounded-lg w-7 bg-white-700 focus:outline-none" type="button">
                        <i class="text-black uil uil-ellipsis-v"></i>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownInventoryMenu" class="z-10 hidden px-3 divide-y divide-gray-100">
                        <div class="px-3 border rounded-lg shadow-md bg-gray-50 w-44">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="inventoryMenu">
                                <li>
                                    <a href="{{ route('table.add') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">ADD</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        {{-- TABLE ADD END --}}

        {{-- CATEGORY ADD --}}
            @if (url()->current() != url('/system-management/category/add') && !Str::contains(url()->current(), url('/system-management/category/edit')) && Str::contains(url()->current(), url('/system-management/category')))
                <div class="self-center float-right ml-auto md:hidden">
                    <button id="inventoryMenu" data-dropdown-toggle="dropdownInventoryMenu" class="inline-flex items-center h-8 text-base font-medium text-center text-white rounded-lg w-7 bg-white-700 focus:outline-none" type="button">
                        <i class="text-black uil uil-ellipsis-v"></i>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownInventoryMenu" class="z-10 hidden px-3 divide-y divide-gray-100">
                        <div class="px-3 border rounded-lg shadow-md bg-gray-50 w-44">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="inventoryMenu">
                                <li>
                                    <a href="{{ route('category.add') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">ADD</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        {{-- CATEGORY ADD END --}}



    </div>
     
     <aside style="z-index: 200;" id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-50 w-64 h-screen transition-transform -translate-x-full lg:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-white border-r border-gray-200 navDiv">
            <div>
                <a href="#" class="flex items-center mb-3">
                    {{-- <img src="{{ asset('storage/images/logo/logo.png') }}" alt="" class="h-10"> --}}

                    <img src="{{ asset('storage/'.$settings->logo) }}" class="h-10" alt="">
                    {{-- <x-application-logo class="h-10 mr-3 text-gray-500 fill-current"/> --}}
                </a>
            </div>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ (Str::contains(url()->current(), url('/dashboard')) || url()->current() == url('/')) ? 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-white hover:shadow-md hover:border-gray-200 bg-gray-200 border border-gray-300 shadow-inner' : 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}">
                        <i class="text-2xl text-gray-500 transition duration-75 uil uil-analysis group-hover:text-gray-900"></i>
                        {{-- <svg aria-hidden="true" class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg> --}}
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('areport.index') }}" class="{{ (Str::contains(url()->current(), url('/reports'))) ? 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-white hover:shadow-md hover:border-gray-200 bg-gray-200 border border-gray-300 shadow-inner' : 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}">
                        <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Reports</span>
                    </a>
                </li>

                {{-- <li>
                    <a href="{{ route('inventory.index') }}" class="{{ (Str::contains(url()->current(), url('/inventory'))) ? 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-white hover:shadow-md hover:border-gray-200 bg-gray-200 border border-gray-300 shadow-inner' : 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}">
                        <i class="w-6 text-2xl text-gray-500 transition duration-75 uil uil-box group-hover:text-gray-900"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Inventory</span>
                    </a>
                </li> --}}
                <li>
                    <button type="button" class="{{ (Str::contains(url()->current(), url('/inventory')) || Str::contains(url()->current(), url('/menu'))) ? 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-white hover:shadow-md hover:border-gray-200 bg-gray-200 border border-gray-300 shadow-inner' : 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}" aria-controls="inventoryDropdown" data-collapse-toggle="inventoryDropdown">
                        <i class="text-2xl text-gray-500 transition duration-75 uil uil-box group-hover:text-gray-900"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap w-36 mr-2.5" sidebar-toggle-item>Inventory / Menu</span>
                        <i class="text-2xl text-gray-500 uil uil-angle-down"></i>
                    </button>
                    <ul id="inventoryDropdown" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ route('inventory.index') }}" class="{{ (Str::contains(url()->current(), url('/inventory'))) ? 'flex items-center w-46 p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg ml-5 pl-10 group border hover:bg-white hover:shadow-md hover:border-gray-200 shadow-inner border-gray-300 bg-gray-200' : 'flex items-center w-46 p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg ml-5 pl-10 group border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}">
                                Inventory
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('menu.index') }}" class="{{ (Str::contains(url()->current(), url('/menu'))) ? 'flex items-center w-46 p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg ml-5 pl-10 group border hover:bg-white hover:shadow-md hover:border-gray-200 shadow-inner border-gray-300 bg-gray-200' : 'flex items-center w-46 p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg ml-5 pl-10 group border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}">
                                Menu
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                   <a href="{{ route('expenses.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                      {{-- <i class="text-2xl text-gray-500 uil uil-monitor"></i> --}}
                         <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 -960 960 960">
                            <path xmlns="http://www.w3.org/2000/svg" d="M540-420q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM220-280q-24.75 0-42.375-17.625T160-340v-400q0-24.75 17.625-42.375T220-800h640q24.75 0 42.375 17.625T920-740v400q0 24.75-17.625 42.375T860-280H220Zm100-60h440q0-42 29-71t71-29v-200q-42 0-71-29t-29-71H320q0 42-29 71t-71 29v200q42 0 71 29t29 71Zm480 180H100q-24.75 0-42.375-17.625T40-220v-460h60v460h700v60ZM220-340v-400 400Z"/>
                         </svg>
                      <span class="ml-3">Today's Expenses</span>
                   </a>
                </li>
                <li>
                   <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-waste" data-collapse-toggle="dropdown-waste">
                         <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 -960 960 960">
                            <path xmlns="http://www.w3.org/2000/svg" d="M261-120q-24.75 0-42.375-17.625T201-180v-570h-41v-60h188v-30h264v30h188v60h-41v570q0 24-18 42t-42 18H261Zm438-630H261v570h438v-570ZM367-266h60v-399h-60v399Zm166 0h60v-399h-60v399ZM261-750v570-570Z"/>
                         </svg>
                         <span class="flex-1 ml-3 text-left whitespace-nowrap">Waste</span>
                         <i class="text-2xl text-gray-500 uil uil-angle-down"></i>
                   </button>
                   <ul id="dropdown-waste" class="hidden py-2 space-y-2">
                         <li>
                            <a href="{{ route('waste.inventory.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Inventory</a>
                         </li>
                         <li>
                            <a href="{{ route('waste.menu.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Menu</a>
                         </li>
                   </ul>
                </li>
                <li>
                    <button type="button" class="{{ (Str::contains(url()->current(), url('/system-management'))) ? 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-white hover:shadow-md hover:border-gray-200 bg-gray-200 border border-gray-300 shadow-inner' : 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}" aria-controls="smDropdown" data-collapse-toggle="smDropdown">
                        <i class="text-2xl text-gray-500 transition duration-75 uil uil-setting group-hover:text-gray-900"></i>
                        <span class="w-full ml-3 text-left whitespace-nowrap" sidebar-toggle-item>System Management</span>
                        <i class="text-2xl text-gray-500 uil uil-angle-down"></i>
                    </button>
                    <ul id="smDropdown" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ route('user.index') }}" class="{{ (Str::contains(url()->current(), url('/system-management/user'))) ? 'flex items-center w-46 p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg ml-5 pl-10 group border hover:bg-white hover:shadow-md hover:border-gray-200 shadow-inner border-gray-300 bg-gray-200' : 'flex items-center w-46 p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg ml-5 pl-10 group border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}">
                                Users
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('inventory.category.index') }}" class="{{ (Str::contains(url()->current(), url('/system-management/inventory-category'))) ? 'flex items-center w-46 p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg ml-5 pl-10 group border hover:bg-white hover:shadow-md hover:border-gray-200 shadow-inner border-gray-300 bg-gray-200' : 'flex items-center w-46 p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg ml-5 pl-10 group border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}">
                                Inventory Category
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('menu.category.index') }}" class="{{ (Str::contains(url()->current(), url('/system-management/menu-category'))) ? 'flex items-center w-46 p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg ml-5 pl-10 group border hover:bg-white hover:shadow-md hover:border-gray-200 shadow-inner border-gray-300 bg-gray-200' : 'flex items-center w-46 p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg ml-5 pl-10 group border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}">
                                Menu Category
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('table.index') }}" class="{{ (Str::contains(url()->current(), url('/system-management/table'))) ? 'flex items-center w-46 p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg ml-5 pl-10 group border hover:bg-white hover:shadow-md hover:border-gray-200 shadow-inner border-gray-300 bg-gray-200' : 'flex items-center w-46 p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg ml-5 pl-10 group border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}">
                                Table List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('settings.index') }}" class="flex items-center p-2 pl-10 ml-5 text-base font-normal text-gray-900 transition duration-75 border border-white rounded-lg w-46 group hover:bg-white hover:shadow-md hover:border-gray-200">
                                Settings
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                   <a href="{{ route('pricingReport') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                      {{-- <i class="text-2xl text-gray-500 uil uil-monitor"></i> --}}
                         <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 -960 960 960">
                            <path xmlns="http://www.w3.org/2000/svg" d="M560-574v-48q33-14 67.5-21t72.5-7q26 0 51 4t49 10v44q-24-9-48.5-13.5T700-610q-38 0-73 9.5T560-574Zm0 220v-49q33-13.5 67.5-20.25T700-430q26 0 51 4t49 10v44q-24-9-48.5-13.5T700-390q-38 0-73 9t-67 27Zm0-110v-48q33-14 67.5-21t72.5-7q26 0 51 4t49 10v44q-24-9-48.5-13.5T700-500q-38 0-73 9.5T560-464ZM248-300q53.566 0 104.283 12.5T452-250v-427q-45-30-97.619-46.5Q301.763-740 248-740q-38 0-74.5 9.5T100-707v434q31-14 70.5-20.5T248-300Zm264 50q50-25 98-37.5T712-300q38 0 78.5 6t69.5 16v-429q-34-17-71.822-25-37.823-8-76.178-8-54 0-104.5 16.5T512-677v427Zm-30 90q-51-38-111-58.5T248-239q-36.537 0-71.768 9Q141-221 106-208q-23.1 11-44.55-3Q40-225 40-251v-463q0-15 7-27.5T68-761q42-20 87.395-29.5Q200.789-800 248-800q63 0 122.5 17T482-731q51-35 109.5-52T712-800q46.868 0 91.934 9.5Q849-781 891-761q14 7 21.5 19.5T920-714v463q0 27.894-22.5 42.447Q875-194 853-208q-34-14-69.232-22.5Q748.537-239 712-239q-63 0-121 21t-109 58ZM276-489Z"/>
                         </svg>
                      <span class="ml-3">Pricing Report</span>
                   </a>
                </li>
                <li>
                   <a href="{{ route('financialReport') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                      {{-- <i class="text-2xl text-gray-500 uil uil-monitor"></i> --}}
                         <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 -960 960 960">
                            <path xmlns="http://www.w3.org/2000/svg" d="M540-420q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM220-280q-24.75 0-42.375-17.625T160-340v-400q0-24.75 17.625-42.375T220-800h640q24.75 0 42.375 17.625T920-740v400q0 24.75-17.625 42.375T860-280H220Zm100-60h440q0-42 29-71t71-29v-200q-42 0-71-29t-29-71H320q0 42-29 71t-71 29v200q42 0 71 29t29 71Zm480 180H100q-24.75 0-42.375-17.625T40-220v-460h60v460h700v60ZM220-340v-400 400Z"/>
                         </svg>
                      <span class="ml-3">Financial Report</span>
                   </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center p-2 text-base font-normal text-gray-900 border border-white rounded-lg hover:bg-white hover:shadow-md hover:border-gray-200">
                            <i class="text-2xl text-gray-500 uis uis-signout"></i>
                            <span class="flex-1 ml-3 whitespace-nowrap">Sign Out</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
     </aside>

     













    <!-- Primary Navigation Menu -->
    {{-- <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block w-auto text-gray-800 fill-current h-9" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div> --}}
</nav>
