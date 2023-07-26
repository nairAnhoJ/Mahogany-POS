<x-app-layout>

    @section('page_title', 'EXPENSES - EDIT')

    <div class="p-3 lg:pt-3">
        <div id="contentDiv" class="p-2 w-full">
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-3">
                <div class="">
                    <form action="{{ route('expenses.update') }}" method="POST" enctype="multipart/form-data" class="grid" class="">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        {{-- <div class="mb-2">
                            <label for="item_code" class="block text-sm font-medium text-gray-900 lg:text-base">Item Code</label>
                            <input type="text" id="item_code" name="item_code" value="{{ $item->item_code }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base">
                        </div> --}}
                        <div class="mb-2">
                            <label for="name" class="block text-sm font-medium text-gray-900 lg:text-base">Item Name <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ $item->remarks }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" required>
                        </div>
                        {{-- <div class="mb-2">
                            <label for="category_id" class="block text-sm font-medium text-gray-900 lg:text-base">Category <span class="text-red-500">*</span></label>
                            <select id="category_id" name="category_id" value="{{ $item->category_id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 lg:text-base">
                                @foreach ($categories as $category)
                                    <option {{ ($item->category_id == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="mb-2">
                            <label for="quantity" class="block text-sm font-medium text-gray-900 lg:text-base">Quantity <span class="text-red-500">*</span></label>
                            <input type="text" id="quantity" name="quantity" value="{{ $item->quantity }}" class="inputNumber block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" required>
                        </div>

                        {{-- <div class="mb-2">
                            <label for="reorder_point" class="block text-sm font-medium text-gray-900 lg:text-base">Reorder Point<span class="text-red-500">*</span></label>
                            <input type="text" id="reorder_point" name="reorder_point" value="{{ $item->reorder_point }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" required>
                        </div> --}}
    
                        {{-- <div class="mb-5">
                            <label for="unit" class="block text-sm font-medium text-gray-900 lg:text-base">Unit <span class="text-red-500">*</span></label>
                            <select id="unit" name="unit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 lg:text-base">
                                <option {{ ($item->unit == 'tsp') ? 'selected' : '' }} value="tsp">teaspoon (tsp)</option>
                                <option {{ ($item->unit == 'tbsp') ? 'selected' : '' }} value="tbsp">tablespoon (tbsp)</option>
                                <option {{ ($item->unit == 'kg') ? 'selected' : '' }} value="kg">kilogram (kg)</option>
                                <option {{ ($item->unit == 'g') ? 'selected' : '' }} value="g">gram (g)</option>
                                <option {{ ($item->unit == 'mg') ? 'selected' : '' }} value="mg">milligram (mg)</option>
                                <option {{ ($item->unit == 'oz') ? 'selected' : '' }} value="oz">ounce (oz)</option>
                                <option {{ ($item->unit == 'lb') ? 'selected' : '' }} value="lb">pound (lb)</option>
                                <option {{ ($item->unit == 'gal') ? 'selected' : '' }} value="gal">gallon (gal)</option>
                                <option {{ ($item->unit == 'L') ? 'selected' : '' }} value="L">liter (L)</option>
                                <option {{ ($item->unit == 'mL') ? 'selected' : '' }} value="mL">milliliter (mL)</option>
                                <option {{ ($item->unit == 'c') ? 'selected' : '' }} value="c">cup (c)</option>
                                <option {{ ($item->unit == 'ea') ? 'selected' : '' }} value="ea">each (ea)</option>
                                <option {{ ($item->unit == 'doz') ? 'selected' : '' }} value="doz">dozen (doz)</option>
                            </select>
                        </div> --}}

                        <div class="mb-2">
                            <label for="price" class="block text-sm font-medium text-gray-900 lg:text-base">Price</label>
                            <input type="text" id="price" name="price" value="{{ $item->amount }}" class="inputNumber block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base">
                        </div>

                        <div class="mb-2">
                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Date</label>
                            <div class="relative max-w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input datepicker type="text" name="dateAdd" value="{{ date('m/d/Y') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Select date">
                            </div>
                        </div>
                        
                        {{-- <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-900 lg:text-base" for="image">Image</label>
                            <input class="px-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none lg:text-base" id="image" name="image" type="file" accept="image/*">
                        </div> --}}
                        
                        <div class="flex justify-between">
                            <a href="{{ route('expenses.index') }}" class="text-white w-1/2 max-w-xs bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none tracking-wider font-semibold text-center">BACK</a>
                            <button type="submit" class="text-white w-1/2 max-w-xs bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none tracking-wider font-semibold">UPDATE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
     </div>

     <script>
        $(document).ready(function() {
            $('.inputNumber').on('keypress keyup', function(event){
                var regex = /^[0-9.]+$/;
                var value = $(this).val() + String.fromCharCode(event.keyCode);
                if (!regex.test(value)) {
                event.preventDefault();
                return false;
                }
                if ((event.keyCode == 46) && ($(this).val().indexOf('.') >= 0)) {
                event.preventDefault();
                return false;
                }
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
        });      
     </script>
</x-app-layout>
