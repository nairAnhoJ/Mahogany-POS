<x-app-layout>
    <style>
        
        #chartDiv{
            height: 280px;
        }

        @media (min-width: 400px) {
            #chartDiv{
                height: calc(100vh - 535px);
            }
        }

        @media (min-width: 768px) {
            #contentDiv{
                /* max-height: calc(100vh - 68px); */
            }
            #chartDiv{
                height: calc(100vh - 450px);
            }
        }

        @media (min-width: 1024px) {
            /* #contentDiv{
                max-height: calc(100vh - 180px);
            } */
            #chartDiv{
                height: calc(100vh - 235px);
            }
        }
    </style>

    @section('page_title', 'DASHBOARD')
    
    <div class="p-3 lg:ml-64 lg:pt-3 h-auto">
        @csrf
        <div id="contentDiv" class="p-2 w-full flex flex-col lg:flex-row">
            <div class="bg-white shadow-md rounded-lg p-3 lg:w-[calc(100%-33vh)]">
                <div class="flex justify-end flex-row lg:justify-between mb-3">
                    <div class="hidden lg:block col-span-2 text-2xl">Overview</div>
                    <div class="justify-self-end flex items-center w-72">
                        <label for="timeframe" class="block text-sm font-medium text-gray-900 mr-4">Timeframe: </label>
                        <select id="timeframe" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full sm:w-80 p-2.5">
                            <option selected value="1">Daily</option>
                            <option value="2">Weekly</option>
                            <option value="3">Monthly</option>
                        </select>
                    </div>
                </div>
                <div class="lg:grid lg:grid-cols-3 lg:gap-2 space-y-2 lg:space-y-0">
                    <div>
                        <div class="block lg:max-w-sm p-6 bg-emerald-400 border border-gray-200 rounded-lg shadow md:flex md:justify-between lg:block">
                            <h5 class="mb-2 text-base font-medium tracking-tight text-gray-900 sm:text-xl lg:text-sm xl:text-base md:self-center md:mb-0">Total Profit</h5>
                            <p class="font-bold text-gray-700 text-2xl md:text-3xl md:self-center lg:text-2xl">₱ <span id="profit">{{$profit}}</span></p>
                        </div>
                    </div>
                    <div>
                        <div class="block lg:max-w-sm p-6 bg-sky-400 border border-gray-200 rounded-lg shadow md:flex md:justify-between lg:block">
                            <h5 class="mb-2 text-base font-medium tracking-tight text-gray-900 sm:text-xl lg:text-sm xl:text-base md:self-center md:mb-0">Total Sales</h5>
                            <p class="font-bold text-gray-700 text-2xl md:text-3xl md:self-center lg:text-2xl">₱  <span id="sales">{{$sales}}</span></p>
                        </div>
                    </div>
                    <div>
                        <div class="block lg:max-w-sm p-6 bg-red-400 border border-gray-200 rounded-lg shadow md:flex md:justify-between lg:block">
                            <h5 class="mb-2 text-base font-medium tracking-tight text-gray-900 sm:text-xl lg:text-sm xl:text-base md:self-center md:mb-0">Total Expenses</h5>
                            <p class="font-bold text-gray-700 text-2xl md:text-3xl md:self-center lg:text-2xl">₱  <span id="expenses">{{$expenses}}</span></p>
                        </div>
                    </div>
                    <div id="chartDiv" class="lg:col-span-3 lg:px-5">
                        <canvas id="myChart" class="w-full"></canvas>
                    </div>
                </div>
            </div>
            <div class="lg:w-[calc(33vh-20px)] mt-5 mb-4 lg:my-0 lg:ml-5 flex flex-col gap-5">
                <div class="bg-white shadow-md rounded-lg w-full aspect-square lg:h-1/3 flex items-center justify-center lg:justify-start p-4 flex-col">
                    <span class="font-bold text-2xl sm:text-4xl lg:text-sm xl:text-xl 2xl:text-2xl mt-5">OCCUPIED TABLE</span>
                    <span class="mt-5 text-9xl sm:text-[256px] lg:text-6xl xl:text-8xl 2xl:text-9xl font-bold text-emerald-600">{{ $table->count() }}</span>
                </div>
                <div class="bg-white shadow-md rounded-lg w-full aspect-square lg:h-1/3 flex items-center justify-center lg:justify-start p-4 flex-col">
                    <span class="font-bold text-2xl sm:text-4xl lg:text-sm xl:text-xl 2xl:text-2xl mt-5">LOW STOCK ITEMS</span>
                    <span class="mt-5 text-9xl sm:text-[256px] lg:text-6xl xl:text-8xl 2xl:text-9xl font-bold text-red-700">{{ $LSICount }}</span>
                </div>
                <div class="hidden lg:flex bg-white shadow-md rounded-lg w-full lg:h-1/3 items-center p-4 flex-col">
                    <span class="font-bold text-xl mt-5"></span>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var labelss = <?php echo $labels; ?>;
            var salesArray = <?php echo $salesArray; ?>;
            var expensesArray = <?php echo $expensesArray; ?>;
            var profitArray = <?php echo $profitArray; ?>;

            const DATA_COUNT = 7;
            const labels = [];
            const saless = [];
            const expensess = [];
            const profit = [];
            for (let i = 0; i < DATA_COUNT; ++i) {
                labels.push(labelss[i]);
            }

            for (let i = 0; i < DATA_COUNT; ++i) {
                saless.push(salesArray[i]);
            }

            for (let i = 0; i < DATA_COUNT; ++i) {
                expensess.push(expensesArray[i]);
            }

            for (let i = 0; i < DATA_COUNT; ++i) {
                profit.push(profitArray[i]);
            }

            const profits =     profit;
            const sales =       saless;
            const expenses =    expensess;
            const data = {
                labels: labels,
                datasets: [
                    {
                    label: 'Profit',
                    data: profits,
                    borderColor: 'rgb(52 211 153)',
                    fill: false,
                    cubicInterpolationMode: 'monotone',
                    tension: 0.4
                    },
                    {
                    label: 'Sales',
                    data: sales,
                    borderColor: 'rgb(56 189 248)',
                    fill: false,
                    cubicInterpolationMode: 'monotone',
                    tension: 0.4
                    },
                    {
                    label: 'Expenses',
                    data: expenses,
                    borderColor: 'rgb(248 113 113)',
                    fill: false,
                    cubicInterpolationMode: 'monotone',
                    tension: 0.4
                    },
                ]
            };

            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    // legend: {
                    //     display: false
                    // },
                    height: 500,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Daily Overview'
                        },
                        legend: {
                            display: true
                        },
                    },
                    interaction: {
                        intersect: false,
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                            display: true
                            }
                        },
                        y: {
                            display: true,
                            title: {
                            // display: true,
                            text: 'Value'
                            },
                            suggestedMin: 0,
                            suggestedMax: 200
                        }
                    }

                },
            });

            $('#navButton').click(function(){
                $('#topNav').addClass('absolute');
                $('#topNav').removeClass('sticky');
                $('#topNav').removeClass('z-50');
                $('#contentDiv').addClass('pt-14');
            });

            $(document).mouseup(function(e) {
                var container = $(".navDiv");

                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    $('#topNav').removeClass('absolute');
                    $('#topNav').addClass('sticky');
                    $('#topNav').addClass('z-50');
                $('#contentDiv').removeClass('pt-14');
                }
            });

            $('#timeframe').change(function(){
                var val = $(this).val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url:"{{ route('dashboard.change') }}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        val: val,
                        _token: _token
                    },
                    success:function(result){
                        $('#profit').html(result.profit);
                        $('#sales').html(result.sales);
                        $('#expenses').html(result.expenses);

                        var newData = {
                            labels: result.labels,
                            datasets: [
                                {
                                    label: 'Profit',
                                    data: result.p,
                                    borderColor: 'rgb(52 211 153)',
                                    fill: false,
                                    cubicInterpolationMode: 'monotone',
                                    tension: 0.4
                                },
                                {
                                    label: 'Sales',
                                    data: result.s,
                                    borderColor: 'rgb(56 189 248)',
                                    fill: false,
                                    cubicInterpolationMode: 'monotone',
                                    tension: 0.4
                                },
                                {
                                    label: 'Expenses',
                                    data: result.e,
                                    borderColor: 'rgb(248 113 113)',
                                    fill: false,
                                    cubicInterpolationMode: 'monotone',
                                    tension: 0.4
                                },
                            ]
                        };

                        myChart.data = newData;
                        myChart.update();
                    }
                })
            });
        });
    </script>
</x-app-layout>
