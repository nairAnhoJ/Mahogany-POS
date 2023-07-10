<x-app-layout>

    @section('page_title', 'EXPENSES - ADD')

    <div class="p-3 lg:pt-3">
        <div id="contentDiv" class="p-2 w-full">
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-3">
                <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data" class="grid">
                    @csrf
                    {{-- <div class="mb-2">
                        <label for="item_code" class="block text-sm font-medium text-gray-900 lg:text-base">Item Code</label>
                        <input type="text" id="item_code" name="item_code" value="{{ old('item_code') }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off">
                    </div> --}}

                    <div class="mb-2">
                        <label for="name" class="block text-sm font-medium text-gray-900 lg:text-base">Item Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off" required>
                    </div>

                    {{-- <div class="mb-2">
                        <label for="category_id" class="block text-sm font-medium text-gray-900 lg:text-base">Category <span class="text-red-500">*</span></label>
                        <select id="category_id" name="category_id" value="{{ old('category_id') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 lg:text-base">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="mb-2">
                        <label for="quantity" class="block text-sm font-medium text-gray-900 lg:text-base">Quantity <span class="text-red-500">*</span></label>
                        <input type="text" id="quantity" name="quantity" value="{{ old('quantity') }}" class="inputNumber block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off" required>
                    </div>

                    {{-- <div class="mb-2">
                        <label for="reorder_point" class="block text-sm font-medium text-gray-900 lg:text-base">Reorder Point<span class="text-red-500">*</span></label>
                        <input type="text" id="reorder_point" name="reorder_point" value="{{ old('reorder_point') }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off" required>
                    </div> --}}

                    {{-- <div class="mb-5">
                        <label for="unit" class="block text-sm font-medium text-gray-900 lg:text-base">Unit<span class="text-red-500">*</span></label>
                        <select id="unit" name="unit" value="{{ old('unit') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 lg:text-base">
                            <option value="tsp">teaspoon (tsp)</option>
                            <option value="tbsp">tablespoon (tbsp)</option>
                            <option value="kg">kilogram (kg)</option>
                            <option value="g">gram (g)</option>
                            <option value="mg">milligram (mg)</option>
                            <option value="oz">ounce (oz)</option>
                            <option value="lb">pound (lb)</option>
                            <option value="gal">gallon (gal)</option>
                            <option value="L">liter (L)</option>
                            <option value="mL">milliliter (mL)</option>
                            <option value="c">cup (c)</option>
                            <option value="ea">each (ea)</option>
                            <option value="doz">dozen (doz)</option>
                        </select>
                    </div> --}}

                    <div class="mb-2">
                        <label for="price" class="block text-sm font-medium text-gray-900 lg:text-base">Price <span class="text-red-500">*</span></label>
                        <input type="text" id="price" name="price" value="{{ old('price') }}" class="inputNumber block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off">
                    </div>

                    {{-- <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-900 lg:text-base" for="image">Image</label>
                        <input class="px-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none lg:text-base" id="image" name="image" type="file" accept="image/*">
                    </div> --}}

                    <div class="flex justify-between">
                        <a href="{{ route('expenses.index') }}" class="text-white w-1/2 max-w-xs bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none tracking-wider font-semibold text-center">BACK</a>
                        <button type="submit" class="text-white w-1/2 max-w-xs bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none tracking-wider font-semibold">SUBMIT</button>
                    </div>
                </form>
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
