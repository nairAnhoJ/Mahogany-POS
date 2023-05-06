<x-app-layout>

    <style>

            .displayDiv0{
                height: calc(100vh - 48px);
            }

        @media (min-width: 768px) {

        }

        @media (min-width: 1024px) {
            .displayDiv0{
                height: calc(100vh - 96px);
            }
            .displayDiv{
                width: calc(100vw - 256px);
            }
            .displayDiv2{
                max-height: calc(100vh - 96px);
            }
        }
    </style>

    @section('page_title', 'KITCHEN DISPLAY')

    {{-- LOADING --}}
        <div wire:loading id="loadingScreen" class="hidden fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-[60] overflow-hidden bg-gray-600 opacity-75 opa flex flex-col items-center justify-center">
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
    
    <div class="">
        @csrf
        <div style="" class="displayDiv0 flex">
            <div class="hidden lg:block h-full w-64 text-white font-black text-xl bg-gradient-to-r from-slate-800 to-slate-700 overflow-x-hidden overflow-y-auto">
                <div class="flex justify-between p-2">
                    <h1>PRODUCT</h1>
                    <h1 class="w-10 text-center">QTY</h1>
                </div>
                <div class="">
                    @foreach ($cats as $cat)
                        <div class="mt-1">
                            <div>
                                <p class="text-center bg-gradient-to-r from-slate-700 to-slate-600">{{ $cat->name }}</p>
                            </div>
                            <div>
                                @foreach ($sOrders as $sOrder)
                                    @if ($sOrder->category_id == $cat->category_id)
                                        <div class="p-2 text-xl font-semibold tracking-wide flex justify-between">
                                            <span>{{ $sOrder->name }}</span><span class="w-10 text-center">{{ $sOrder->total_quantity }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    {{-- <div class="mt-1">
                        <div>
                            <p class="text-center bg-gradient-to-r from-slate-700 to-slate-600">Soup</p>
                        </div>
                        <div>
                            
                            <div class="p-2 text-xl font-semibold tracking-wide flex justify-between">
                                <span>Bulalo Special</span><span class="w-10 text-center">1</span>
                            </div>
                            
                        </div>
                    </div> --}}
                </div>
            </div>

            <div style="" class="displayDiv h-full w-full overflow-y-auto bg-gray-200">
                <div style="" class="displayDiv2 grid lg:grid-cols-3 gap-4 p-4">

                    @foreach ($trans as $tran)

                        <div class="bg-white shadow">
                            <div data-id="{{ $tran->id }}" class="{{ ($tran->table == 1) ? 'bg-amber-500' : 'bg-red-400'; }} tranButton grid grid-cols-2 h-14 text-xl content-center px-2 font-bold tracking-wider text-slate-700 cursor-pointer">
                                <div>{{ $tran->table_name }}</div>
                                @php
                                    $code = ltrim(substr($tran->number, -7), '0');
                                    $time = date("h:i a", strtotime($tran->created_at));
                                @endphp
                                <div class="justify-self-end">#{{ $code }}</div>
                                <div class="text-base">{{ $time }}</div>
                            </div>
                            <div>
                                @foreach ($ordereds as $ordered)
                                    @if ($tran->id == $ordered->tran_id)
                                        <div data-id="{{ $ordered->id }}" class="foodOrdered p-2 text-xl font-semibold tracking-wide border-b border-gray-400 cursor-pointer">
                                            <h1 class="{{ ($ordered->status == 'PREPARED') ? 'line-through' : ''; }}">&nbsp;&nbsp;{{$ordered->quantity}}x&nbsp;&nbsp;&nbsp;<span>{{$ordered->name}}</span>&nbsp;&nbsp;</h1>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                    @endforeach

                    {{--  --}}
                        {{-- <div class="bg-white shadow">
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
                        </div> --}}
                    {{--  --}}
                </div>
            </div>
        </div>
        <div class="hidden h-12 lg:flex w-screen">
            <div class="w-full h-full">
                <div class="w-full h-full grid grid-cols-5">
                    <div class="text-center leading-10 pt-1 text-xl font-black bg-red-400 tracking-wider text-slate-800">DINE-IN</div>
                    <div class="text-center leading-10 pt-1 text-xl font-black bg-amber-500 tracking-wider text-slate-800">TAKE-OUT</div>
                    <div class="bg-slate-700 col-span-2"></div>
                    <button id="serveButton" disabled class="disabled:pointer-events-none disabled:opacity-30 text-center leading-10 pt-1 text-xl font-black bg-emerald-400 hover:bg-emerald-500 tracking-wider text-slate-800">
                            SERVE
                    </button>
                </div>
            </div>
        </div>
     </div>

    <script>
        $(document).ready(function() {
            var _token;
            var id;

            $('.foodOrdered').click(function(){
                var id = $(this).data('id');
                _token = $('input[name="_token"]').val();

                $('#loadingScreen').removeClass('hidden');

                $.ajax({
                    url:"{{ route('kitchen.change') }}",
                    method:"POST",
                    data:{
                        id: id,
                        _token: _token
                    },
                    success:function(result){
                        console.log(result);
                        location.reload();
                    }
                })
            });

            $('.tranButton').click(function(){
                id = $(this).data('id');
                _token = $('input[name="_token"]').val();

                $.ajax({
                    url:"{{ route('kitchen.check') }}",
                    method:"POST",
                    data:{
                        id: id,
                        _token: _token
                    },
                    success:function(result){
                        if(result == 1){
                            $('#serveButton').prop('disabled', false);
                        }else{
                            $('#serveButton').prop('disabled', true);
                        }
                    }
                })
            });

            $('#serveButton').click(function(){
                _token = $('input[name="_token"]').val();

                $.ajax({
                    url:"{{ route('kitchen.serve') }}",
                    method:"POST",
                    data:{
                        id: id,
                        _token: _token
                    },
                    success:function(result){
                        location.reload();
                    }
                })
            });
        });
    </script>
</x-app-layout>
