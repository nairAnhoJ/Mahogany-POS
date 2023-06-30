<div class="flex justify-between bg-white h-12 shadow">
    <div class="flex items-center">
        <button class="text-gray-800 hover:bg-gray-100 flex items-center justify-center w-12 h-12" type="button" data-drawer-target="drawer-navigation" data-drawer-show="drawer-navigation" aria-controls="drawer-navigation">
            <i class="uil uil-bars text-3xl"></i>
        </button>
        <h2 class="font-semibold text-base text-gray-600 leading-tight">
            @yield('page_title')
        </h2>
    </div>
    <form method="POST" action="{{ route('logout') }}" class="h-12 w-12 flex bg-red-600 hover:bg-red-700">
        @csrf
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="h-full w-full flex items-center justify-center">
            <i class="uis uil-sign-out-alt text-3xl text-white"></i>
        </a>
    </form>
</div>


<!-- drawer component -->
<div id="drawer-navigation" class="fixed top-0 left-0 z-40 w-64 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white" tabindex="-1" aria-labelledby="drawer-navigation-label">
    <h5 id="drawer-navigation-label" class="text-base font-semibold text-gray-500 uppercase">Menu</h5>
    <button type="button" data-drawer-hide="drawer-navigation" aria-controls="drawer-navigation" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center" >
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        <span class="sr-only">Close menu</span>
    </button>
  <div class="pt-4 overflow-y-auto flex flex-col justify-between h-[calc(100vh-72px)]">
      <ul class="space-y-2 font-medium">
         <li>
            <a href="{{ route('pos.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
               <i class="uil uil-monitor text-2xl text-gray-500"></i>
               <span class="ml-3">POS</span>
            </a>
         </li>
         <li>
            <a href="{{ route('orders.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
               <i class="uil uil-utensils-alt text-2xl text-gray-500"></i>
               <span class="ml-3">Orders</span>
            </a>
         </li>
         <li>
            <a href="{{ route('transactions.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
               <span class="ml-3">Transactions</span>
            </a>
         </li>
         <li>
             <a href="{{ route('areport.index') }}" class="{{ (Str::contains(url()->current(), url('/reports'))) ? 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-white hover:shadow-md hover:border-gray-200 bg-gray-200 border border-gray-300 shadow-inner' : 'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg border border-white hover:bg-white hover:shadow-md hover:border-gray-200';}}">
                 <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 -960 960 960" xmlns="http://www.w3.org/2000/svg"><path xmlns="http://www.w3.org/2000/svg" d="M180-120q-24 0-42-18t-18-42v-600q0-24 18-42t42-18h462l198 198v462q0 24-18 42t-42 18H180Zm0-60h600v-428.571H609V-780H180v600Zm99-111h402v-60H279v60Zm0-318h201v-60H279v60Zm0 159h402v-60H279v60Zm-99-330v171.429V-780v600-600Z"/></svg>
                 <span class="flex-1 ml-3 whitespace-nowrap">Reports</span>
             </a>
         </li>
         <li>
            <a href="{{ route('kitchen.display') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
               <i class="uil uil-monitor text-2xl text-gray-500"></i>
               <span class="ml-3">Kitchen Display</span>
            </a>
         </li>
         <li>
            <a href="{{ route('menu.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
               <i class="uil uil-utensils-alt text-2xl text-gray-500"></i>
               <span class="ml-3">Menu Preparation</span>
            </a>
         </li>
         <li>
            <a href="{{ route('inventory.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
               {{-- <i class="uil uil-monitor text-2xl text-gray-500"></i> --}}
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="text-gray-500 h-6 w-6"><path d="M120-142v-492q-14-2-27-20t-13-39v-127q0-23 18-41.5t42-18.5h680q23 0 41.5 18.5T880-820v127q0 21-13 39t-27 20v492q0 23-18.5 42.5T780-80H180q-24 0-42-19.5T120-142Zm60-491v493h600v-493H180Zm640-60v-127H140v127h680ZM360-423h240v-60H360v60ZM180-140v-493 493Z"/></svg>
               <span class="ml-3">Inventory</span>
            </a>
         </li>
         <li>
            <a href="{{ route('expenses.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
               {{-- <i class="uil uil-monitor text-2xl text-gray-500"></i> --}}
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="text-gray-500 h-6 w-6"><path xmlns="http://www.w3.org/2000/svg" d="M540-420q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM220-280q-24.75 0-42.375-17.625T160-340v-400q0-24.75 17.625-42.375T220-800h640q24.75 0 42.375 17.625T920-740v400q0 24.75-17.625 42.375T860-280H220Zm100-60h440q0-42 29-71t71-29v-200q-42 0-71-29t-29-71H320q0 42-29 71t-71 29v200q42 0 71 29t29 71Zm480 180H100q-24.75 0-42.375-17.625T40-220v-460h60v460h700v60ZM220-340v-400 400Z"/></svg>
               <span class="ml-3">Expenses</span>
            </a>
         </li>
         <li>
            <a href="{{ route('report.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
               <i class="uil uil-newspaper text-2xl text-gray-500"></i>
               <span class="ml-3">Low Stock Report</span>
            </a>
         </li>
      </ul>
      <a href="{{ route('pos.send') }}" id="sendSSButton" class="text-sm underline text-blue-600">Send Sales Summary</a>
   </div>
</div>