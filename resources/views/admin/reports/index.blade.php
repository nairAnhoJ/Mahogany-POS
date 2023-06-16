<x-app-layout>
    @section('page_title', 'REPORTS')
    
    <div class="p-3 lg:ml-64 lg:pt-3">
    
        <div class="py-3">
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-3">
                <form action="{{ route('areport.generate') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="text-sm font-medium text-gray-900">Date</label>
                        <div date-rangepicker class="flex items-center w-full">
                            <div class="relative w-[calc(50%-24px)]">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input name="start" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" value="{{ date('m/d/Y') }}">
                            </div>
                            <span class="mx-4 text-gray-500">to</span>
                            <div class="relative w-[calc(50%-24px)]">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input name="end" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="block text-sm font-medium text-gray-900">Category</label>
                        <select id="category" name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="sales">Sales</option>
                            <option value="expenses">Expenses</option>
                            <option value="both">Sales & Expenses</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="report" class="block text-sm font-medium text-gray-900">Report</label>
                        <select id="report" name="report" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="list">Transaction Logs</option>
                            <option value="summary">Summary</option>
                            {{-- <option value="both">Both</option> --}}
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
                    $('#report').html(`
                        <option value="list">Transaction Logs</option>
                        <option value="summary">Summary</option>
                    `);
                }else{
                    $('#report').html(`
                        <option value="summary">Summary</option>
                    `);
                }
            });
        });
    </script>
</x-app-layout>
