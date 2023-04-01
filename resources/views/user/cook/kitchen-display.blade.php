<x-app-layout>
    @section('page_title', 'KITCHEN DISPLAY')
    
    <div class="">
        <div style="height: calc(100vh - 96px);" class="flex">
            <div class="h-full w-64 text-white font-black text-xl bg-gradient-to-r from-slate-800 to-slate-700 overflow-x-hidden overflow-y-auto">
                <div class="flex justify-between p-2">
                    <h1>PRODUCT</h1>
                    <h1 class="w-10 text-center">QTY</h1>
                </div>
                <div class="">
                    {{--  --}}
                    <div class="mt-1">
                        <div>
                            <p class="text-center bg-gradient-to-r from-slate-700 to-slate-600">Soup</p>
                        </div>
                        <div>
                            {{--  --}}
                            <div class="p-2 text-xl font-semibold tracking-wide flex justify-between">
                                <span>Bulalo Special</span><span class="w-10 text-center">1</span>
                            </div>
                            <div class="p-2 text-xl font-semibold tracking-wide flex justify-between">
                                <span>Sinigang na Baka</span><span class="w-10 text-center">2</span>
                            </div>
                            {{--  --}}
                        </div>
                    </div>
                    {{--  --}}

                    <div class="mt-1">
                        <div>
                            <p class="text-center bg-gradient-to-r from-slate-700 to-slate-600">Pork</p>
                        </div>
                        <div>
                            <div class="p-2 text-xl font-semibold tracking-wide flex justify-between">
                                <span>Adobong Spare Ribs</span><span class="w-10 text-center">1</span>
                            </div>
                            <div class="p-2 text-xl font-semibold tracking-wide flex justify-between">
                                <span>Crispy Pata</span><span class="w-10 text-center">2</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-1">
                        <div>
                            <p class="text-center bg-gradient-to-r from-slate-700 to-slate-600">Beef</p>
                        </div>
                        <div>
                            <div class="p-2 text-xl font-semibold tracking-wide flex justify-between">
                                <span>Beef Tapa Steak Tagalog</span><span class="w-10 text-center">2</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-1">
                        <div>
                            <p class="text-center bg-gradient-to-r from-slate-700 to-slate-600">Seafood</p>
                        </div>
                        <div>
                            <div class="p-2 text-xl font-semibold tracking-wide flex justify-between">
                                <span>Buttered Shrimp</span><span class="w-10 text-center">2</span>
                            </div>
                            <div class="p-2 text-xl font-semibold tracking-wide flex justify-between">
                                <span>Boneless Daing na Bangus</span><span class="w-10 text-center">2</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-1">
                        <div>
                            <p class="text-center bg-gradient-to-r from-slate-700 to-slate-600">Rice</p>
                        </div>
                        <div>
                            <div class="p-2 text-xl font-semibold tracking-wide flex justify-between">
                                <span>Platter Plain Rice</span><span class="w-10 text-center">5</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>











            <div style="width: calc(100vw - 256px);" class="h-full overflow-y-auto bg-gray-200">
                <div style="max-height: calc(100vh - 96px);" class="grid grid-cols-3 gap-4 p-4">
                    {{--  --}}
                    <div class="bg-white shadow">
                        <div class="bg-red-400 grid grid-cols-2 h-10 text-xl content-center px-2 font-bold tracking-wider text-slate-700">
                            <div>TABLE 1</div>
                            <div class="justify-self-end">#9999</div>
                        </div>
                        <div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Bulalo Special</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Adobong Spare Ribs</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Platter Plain Rice</span>&nbsp;&nbsp;</h1>
                            </div>
                        </div>
                    </div>
                    {{--  --}}

                    <div class="bg-white shadow">
                        <div class="bg-red-400 grid grid-cols-2 h-10 text-xl content-center px-2 font-bold tracking-wider text-slate-700">
                            <div>TABLE 7</div>
                            <div class="justify-self-end">#9999</div>
                        </div>
                        <div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Beef Tapa Steak Tagalog</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Sinigang na Baka</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Platter Plain Rice</span>&nbsp;&nbsp;</h1>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white shadow">
                        <div class="bg-amber-500 grid grid-cols-2 h-10 text-xl content-center px-2 font-bold tracking-wider text-slate-700">
                            <div>TAKE-OUT</div>
                            <div class="justify-self-end">#9999</div>
                        </div>
                        <div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Beef Tapa Steak Tagalog</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Sinigang na Baka</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Platter Plain Rice</span>&nbsp;&nbsp;</h1>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white shadow">
                        <div class="bg-red-400 grid grid-cols-2 h-10 text-xl content-center px-2 font-bold tracking-wider text-slate-700">
                            <div>TABLE 4</div>
                            <div class="justify-self-end">#9999</div>
                        </div>
                        <div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Buttered Shrimp</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Boneless Daing na Bangus</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Crispy Pata</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Platter Plain Rice</span>&nbsp;&nbsp;</h1>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white shadow">
                        <div class="bg-amber-500 grid grid-cols-2 h-10 text-xl content-center px-2 font-bold tracking-wider text-slate-700">
                            <div>TAKE-OUT</div>
                            <div class="justify-self-end">#9999</div>
                        </div>
                        <div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Buttered Shrimp</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Boneless Daing na Bangus</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Crispy Pata</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                <h1>&nbsp;&nbsp;1x&nbsp;&nbsp;&nbsp;<span>Platter Plain Rice</span>&nbsp;&nbsp;</h1>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="h-12 flex w-screen">
            <div class="w-full h-full">
                <div class="w-full h-full grid grid-cols-5 bg-slate-700">
                    <div class="text-center leading-10 pt-1 text-xl font-black bg-red-400 tracking-wider text-slate-800">DINE-IN</div>
                    <div class="text-center leading-10 pt-1 text-xl font-black bg-amber-500 tracking-wider text-slate-800">TAKE-OUT</div>
                </div>
            </div>
        </div>
     </div>

    <script>
        $(document).ready(function() {
            $('.foodOrdered').click(function(){
                $(this).find('h1').toggleClass('line-through');
            });
        });
    </script>
</x-app-layout>
