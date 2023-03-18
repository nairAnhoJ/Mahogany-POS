<nav x-data="{ open: false }" class="absolute bg-white shadow-md w-full">
    <div class="lg:hidden flex flex-row {{ (url()->current() == url('/inventory')) ? 'justify-between' : ''; }} ">
        <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center h-12 p-2 ml-3 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
        </button>
    
        <div class="self-center">
            <h2 class="font-semibold text-base text-gray-600 leading-tight ml-3">
                @yield('page_title')
            </h2>
        </div>


        @if (url()->current() == url('/inventory'))
            <div class="self-center float-right md:hidden ml-auto">
                <button id="inventoryMenu" data-dropdown-toggle="dropdownInventoryMenu" class="text-white h-8 w-7 bg-white-700 focus:outline-none font-medium rounded-lg text-base text-center inline-flex items-center" type="button">
                    <i class="uil uil-ellipsis-v text-black"></i>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownInventoryMenu" class="z-10 hidden divide-y divide-gray-100 px-3">
                    <div class="bg-gray-50 rounded-lg w-44 px-3 border shadow-md">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="inventoryMenu">
                            <li>
                                <a href="{{ route('inventory.add') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">ADD</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
     
     <aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full lg:translate-x-0" aria-label="Sidebar">

        <div class="h-full px-3 py-4 overflow-y-auto bg-white border-r border-gray-200">
            <div>
                <a href="#" class="flex items-center mb-3">
                    <x-application-logo class="h-10 fill-current text-gray-500 mr-3"/>
                </a>
            </div>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ (Str::contains(url()->current(), url('/dashboard')) || url()->current() == url('/')) ? 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-white hover:shadow-md hover:border-gray-200 bg-gray-200 border border-gray-300 shadow-inner' : 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}">
                        <svg aria-hidden="true" class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="{{ (Str::contains(url()->current(), url('/reports'))) ? 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-white hover:shadow-md hover:border-gray-200 bg-gray-200 border border-gray-300 shadow-inner' : 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}">
                        <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Reports</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('inventory.index') }}" class="{{ (Str::contains(url()->current(), url('/inventory'))) ? 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-white hover:shadow-md hover:border-gray-200 bg-gray-200 border border-gray-300 shadow-inner' : 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}">
                        <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Inventory</span>
                    </a>
                </li>
                <li>
                    <button type="button" class="{{ (Str::contains(url()->current(), url('/system-management'))) ? 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-white hover:shadow-md hover:border-gray-200 bg-gray-200 border border-gray-300 shadow-inner' : 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                        <i class="uil uil-setting text-2xl text-gray-500"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>System Management</span>
                        <i class="uil uil-angle-down text-2xl text-gray-500"></i>
                    </button>
                    <ul id="dropdown-example" class="hidden py-2 space-y-2">
                        <li>
                            <a href="#" class="flex items-center w-46 p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg  ml-7 pl-11 group border border-white hover:bg-white hover:shadow-md hover:border-gray-200">Users</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center w-46 p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg ml-7 pl-11 group border border-white hover:bg-white hover:shadow-md hover:border-gray-200">Table List</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center w-46 p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg ml-7 pl-11 group border border-white hover:bg-white hover:shadow-md hover:border-gray-200">Settings</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg border border-white hover:bg-white hover:shadow-md hover:border-gray-200">
                            <i class="uis uis-signout text-2xl text-gray-500"></i>
                            <span class="flex-1 ml-3 whitespace-nowrap">Sign Out</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
     </aside>
     













    <!-- Primary Navigation Menu -->
    {{-- <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
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
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
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
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
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
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
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
