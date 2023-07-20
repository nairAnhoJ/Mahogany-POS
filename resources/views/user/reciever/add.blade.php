<x-app-layout>

    @section('page_title', 'INVENTORY - ADD')

    {{-- ERROR NOTIFICATION --}}
        @if (session('error'))
            <div class="notif absolute left-1/2 top-14 -translate-x-1/2 w-96 h-12 bg-red-200 rounded-lg z-50 shadow-md shadow-red-800 flex flex-row justify-between px-2">
                <div class="flex">
                    <i class="self-center uil uil-cloud-check text-red-800 text-2xl"></i>
                    <h1 class="self-center text-red-800 font-semibold ml-1">{{ session('error') }}</h1>
                </div>
                <button class="notifButton self-center">
                    <i class="uil uil-times text-2xl text-red-800"></i>
                </button>
            </div>
        @endif
    {{-- ERROR NOTIFICATION END --}}

    <div class="p-3 lg:pt-3">
        <div id="contentDiv" class="p-2 w-full">
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-3">
                <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data" class="grid">
                    @csrf
                    <div class="mb-2">
                        <label for="item_code" class="block text-sm font-medium text-gray-900 lg:text-base">Item Code</label>
                        <input type="text" id="item_code" name="item_code" value="{{ old('item_code') }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off">
                    </div>

                    <div class="mb-2">
                        <label for="name" class="block text-sm font-medium text-gray-900 lg:text-base">Item Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off" required>
                    </div>

                    <div class="mb-2">
                        <label for="category_id" class="block text-sm font-medium text-gray-900 lg:text-base">Category <span class="text-red-500">*</span></label>
                        <select id="category_id" name="category_id" value="{{ old('category_id') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 lg:text-base">
                            @foreach ($categories as $category)
                                <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- <div class="mb-2">
                        <label for="quantity" class="block text-sm font-medium text-gray-900 lg:text-base">Quantity <span class="text-red-500">*</span></label>
                        <input type="text" id="quantity" name="quantity" value="{{ old('quantity') }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off" required>
                    </div> --}}

                    <div class="mb-2">
                        <label for="reorder_point" class="block text-sm font-medium text-gray-900 lg:text-base">Reorder Point<span class="text-red-500">*</span></label>
                        <input type="text" id="reorder_point" name="reorder_point" value="{{ old('reorder_point') }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off" required>
                    </div>

                    <div class="mb-5">
                        <label for="unit" class="block text-sm font-medium text-gray-900 lg:text-base">Unit<span class="text-red-500">*</span></label>
                        <select id="unit" name="unit" value="{{ old('unit') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 lg:text-base">
                            <option {{ old('unit') == 'tsp' ? 'selected' : '' }} value="tsp">teaspoon (tsp)</option>
                            <option {{ old('unit') == 'tbsp' ? 'selected' : '' }} value="tbsp">tablespoon (tbsp)</option>
                            <option {{ old('unit') == 'kg' ? 'selected' : '' }} value="kg">kilogram (kg)</option>
                            <option {{ old('unit') == 'g' ? 'selected' : '' }} value="g">gram (g)</option>
                            <option {{ old('unit') == 'mg' ? 'selected' : '' }} value="mg">milligram (mg)</option>
                            <option {{ old('unit') == 'oz' ? 'selected' : '' }} value="oz">ounce (oz)</option>
                            <option {{ old('unit') == 'lb' ? 'selected' : '' }} value="lb">pound (lb)</option>
                            <option {{ old('unit') == 'gal' ? 'selected' : '' }} value="gal">gallon (gal)</option>
                            <option {{ old('unit') == 'L' ? 'selected' : '' }} value="L">liter (L)</option>
                            <option {{ old('unit') == 'mL' ? 'selected' : '' }} value="mL">milliliter (mL)</option>
                            <option {{ old('unit') == 'c' ? 'selected' : '' }} value="c">cup (c)</option>
                            <option {{ old('unit') == 'ea' ? 'selected' : '' }} value="ea">each (ea)</option>
                            <option {{ old('unit') == 'doz' ? 'selected' : '' }} value="doz">dozen (doz)</option>
                        </select>
                    </div>

                    {{-- <div class="mb-2">
                        <label for="price" class="block text-sm font-medium text-gray-900 lg:text-base">Price</label>
                        <input type="text" id="price" name="price" value="{{ old('price') }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off">
                    </div> --}}

                    {{-- <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-900 lg:text-base" for="image">Image</label>
                        <input class="px-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none lg:text-base" id="image" name="image" type="file" accept="image/*">
                    </div> --}}

                    <div class="flex justify-between">
                        <a href="{{ route('inventory.index') }}" class="text-white w-1/2 max-w-xs bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none tracking-wider font-semibold text-center">BACK</a>
                        <button type="submit" class="text-white w-1/2 max-w-xs bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none tracking-wider font-semibold">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
     </div>

     <script>
        $(document).ready(function() {
            $('#price').on('input', function() {
                var val = $(this).val().replace(/[^0-9]/g, '');
                $(this).val(val);
            });
            $('#quantity').on('input', function() {
                var val = $(this).val().replace(/[^0-9]/g, '');
                $(this).val(val);
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

            $('.notifButton').click(function(){
                $('.notif').addClass('hidden');
            });
        });      
     </script>
</x-app-layout>
