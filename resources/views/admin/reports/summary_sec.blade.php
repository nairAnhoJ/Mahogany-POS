<x-app-layout>
    @section('page_title', 'REPORTS')
    
    <div class="p-3 lg:ml-64 lg:pt-3">
        <div id="contentDiv" class="p-2 w-full">
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-4">
                {{-- CONTROLS --}}
                    <div class="mb-3">
                        <div class="flex justify-between">
                            <div class="w-32">
                                <a href="{{ route('areport.index') }}" class="hidden md:block text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-semibold rounded-lg text-sm px-5 py-2.5 focus:outline-none my-px text-center"><i class="uil uil-arrow-left mr-1"></i>BACK</a>
                            </div>
                            <div class="w-32">
                                <a href="{{ url('/report/print/'.$startDate.'/'.$endDate.'/'.$category.'/'.$report) }}" target="_blank" class="hidden md:block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 focus:outline-none my-px text-center"><i class="uil uil-print mr-1"></i>PRINT</a>
                            </div>
                        </div>
                    </div>
                {{-- CONTROLS END --}}

                <div>
                    <div class="mt-4 flex justify-between">
                        <h1 class="text-3xl">S&E Summary Report</h1>
                        <h1 class="flex items-center">{{ date('M j, Y', strtotime($startDate)).' - '.date('M j, Y', strtotime('-1 day', strtotime($endDate))) }}</h1>
                    </div>
                    {{-- TABLE --}}
                        <div class="hidden md:block">
                            <div id="inventoryTable" class="overflow-auto w-full shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr class="border-b">
                                            <th class="px-6 text-center">
                                                Date
                                            </th>
                                            <th class="px-6 text-center">
                                                Total Sales
                                            </th>
                                            <th class="px-6 text-center">
                                                Total Expenses
                                            </th>
                                            <th class="px-6 text-center">
                                                Total Profit
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $feCDate = strtotime($startDate);
                                            $feEDate = strtotime($endDate);
                                        @endphp
                                        @while ($feCDate < $feEDate)
                                            @php
                                                $sTotal = 0;
                                                $eTotal = 0;
                                                $pTotal = 0;
                                                $x = 0;
                                                $fCurDate = date("Y-m-d", $feCDate);
                                            @endphp
                                            @foreach ($results as $result)
                                                @php
                                                    $fResDate = date("Y-m-d", strtotime($result->date));
                                                @endphp
                                                @if ($fResDate == $fCurDate)
                                                    <tr class="border-b">
                                                        <th class="px-6 py-1 text-center font-medium text-gray-900 whitespace-nowrap">
                                                            {{ date('M d, Y', $feCDate) }}
                                                        </th>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            ₱ {{ $result->stotal }}.00
                                                        </td>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap">
                                                            ₱ {{ $result->etotal }}.00
                                                        </td>
                                                        <td class="px-6 py-1 text-center whitespace-nowrap font-semibold {{ ($result->stotal - $result->etotal) < 0 ? 'text-red-500' : 'text-emerald-500' }}">
                                                            ₱ {{ $result->stotal - $result->etotal }}.00
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $x = 1;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @if ($x == 0)
                                                <tr class="border-b">
                                                    <th class="px-6 py-1 text-center font-medium text-gray-900 whitespace-nowrap">
                                                        {{ date('M d, Y', $feCDate) }}
                                                    </th>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        ₱ 0.00
                                                    </td>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap">
                                                        ₱ 0.00
                                                    </td>
                                                    <td class="px-6 py-1 text-center whitespace-nowrap font-semibold">
                                                        ₱ 0.00
                                                    </td>
                                                </tr>
                                            @endif
                                            @php
                                                $feCDate = strtotime('+1 day', $feCDate);
                                            @endphp
                                        @endwhile
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    {{-- TABLE END --}}
                </div>
            </div>
        </div>
     </div>

    <script>
        $(document).ready(function() {
            $('#navButton').click(function(){
                    $('#topNav').addClass('absolute');
                    $('#topNav').removeClass('sticky');
                    $('#contentDiv').addClass('pt-14');
                });

            $(document).mouseup(function(e) {
                var container = $(".navDiv");

                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    $('#topNav').removeClass('absolute');
                    $('#topNav').addClass('sticky');
                $('#contentDiv').removeClass('pt-14');
                }
            });
        });
    </script>
</x-app-layout>
