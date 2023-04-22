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
                            {{-- <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-full border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <span class="sr-only">Search</span>
                            </button> --}}
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
                            <div class="hidden p-8" id="all-menu" role="tabpanel" aria-labelledby="all-menu-tab">
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
                        <button type="button" data-modal-target="tableModal" data-modal-show="tableModal" class="p-1 rounded-lg shadow border border-gray-100">
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
                                        <button data-slug="{{ $order->slug }}" class="aspect-square w-full bg-red-600 rounded-lg"><i class="uil uil-times text-xl text-red-200"></i></button>
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
                                                <strong class="text-slate-600 text-2xl font-medium"><span class="text-3xl">₱ </span><span id="total">{{ number_format($subTotal, 2, '.', ',') }}</span></strong>
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
            })

            $('.scroll-left').click(function() {
                var divW = (($('#menuTabs').width() * 2) / 3);
                $('#menuTabs').animate({scrollLeft: '-=' + divW + 'px'}, 'slow');
            });
            
            $('.scroll-right').click(function() {
                var divW = (($('#menuTabs').width() * 2) / 3);
                $('#menuTabs').animate({scrollLeft: '+=' + divW + 'px'}, 'slow');
            });


            jQuery(document).on( "click", ".menu", function(){
                var slug = $(this).data('slug');
                var _token = $('input[name="_token"]').val();

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
                    }
                })
            });

            jQuery(document).on( "click", ".incQty", function(){
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
                    }
                })
            });

            jQuery(document).on( "click", ".descQty", function(){
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
                    }
                })
            });
        });
    </script>
</x-app-layout>
