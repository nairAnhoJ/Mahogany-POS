<x-app-layout>
    @section('page_title', 'REPORTS')
    
    <div class="p-3 lg:pt-3 {{ (Auth::user()->role == 2) ? '' : ' lg:ml-64' }}">
        <div class="py-3">
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-3">
                <form action="{{ route('areport.generate') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="text-sm font-medium text-gray-900">Date</label>
                        <div class="flex items-center w-full gap-x-5 text-gray-700 font-medium">
                            <input type="datetime-local" name="start" id="dateStart" class="w-full bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-3 p-2.5" value="{{ date('Y-m-d 00:00:00') }}">
                            <span class="">to</span>
                            <input type="datetime-local" name="end" id="dateEnd" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-3 p-2.5" value="{{ date('Y-m-d 23:59:00') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="block text-sm font-medium text-gray-900">Category</label>
                        <select id="category" name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="sales">Sales</option>
                            <option value="expenses">Expenses</option>
                            <option value="both">Sales & Expenses</option>
                            <option value="inventory">Inventory</option>
                            <option value="menu">Menu</option>
                            <option value="waste">Waste</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="report" class="block text-sm font-medium text-gray-900">Report</label>
                        <select id="report" name="report" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="list">Transaction Logs</option>
                            <option value="summary">Summary</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button class="bg-blue-600 font-bold text-white px-20 py-2 rounded-lg hover:scale-105">Generate</button>
                    </div>
                </form>
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

            $('#category').on('change', function(){
                var category = $(this).val();

                $('#report').empty();

                if(category != 'both'){
                    if(category == 'expenses'){
                        $('#report').html(`
                            <option value="list">Transaction Logs</option>
                            <option value="summary">Summary</option>
                            <option value="unpaid">Unpaid</option>
                        `);
                    }else if(category == 'inventory'){
                        $('#report').html(`
                            <option value="logs">Logs</option>
                            <option value="stock">Stocks</option>
                        `);
                    }else if(category == 'menu'){
                        $('#report').html(`
                            <option value="rank">Rankings</option>
                        `);
                    }else if(category == 'waste'){
                        $('#report').html(`
                            <option value="raw">Raw Inventory</option>
                            <option value="menu">Menu</option>
                        `);
                    }else{
                        $('#report').html(`
                            <option value="list">Transaction Logs</option>
                            <option value="summary">Summary</option>
                        `);
                    }
                }else{
                    $('#report').html(`
                        <option value="summary">Summary</option>
                    `);
                }
            });
        });
    </script>
</x-app-layout>
