<x-app-layout>

    @section('page_title', 'INVENTORY - EDIT')

    <div class="p-3 lg:ml-64 max-h-screen pt-14 lg:pt-3 overflow-y-auto">
    
        <div class="">
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-3">
                <div class="">
                    <form action="{{ route('inventory.update') }}" method="POST" enctype="multipart/form-data" class="grid" class="">
                        @csrf
                        <input type="hidden" name="slug" value="{{ $item->slug }}">
                        <div class="mb-2">
                            <label for="item_code" class="block text-sm font-medium text-gray-900 lg:text-base">Item Code</label>
                            <input type="text" id="item_code" name="item_code" value="{{ $item->item_code }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base">
                        </div>
                        <div class="mb-2">
                            <label for="name" class="block text-sm font-medium text-gray-900 lg:text-base">Item Name <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ $item->name }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" required>
                        </div>
                        <div class="mb-2">
                            <label for="category_id" class="block text-sm font-medium text-gray-900 lg:text-base">Category <span class="text-red-500">*</span></label>
                            <select id="category_id" name="category_id" value="{{ $item->category_id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 lg:text-base">
                              <option {{ ($item->category_id == 1) ? 'selected' : ''; }} value="1">Cat 1</option>
                              <option {{ ($item->category_id == 2) ? 'selected' : ''; }} value="2">Cat 2</option>
                              <option {{ ($item->category_id == 3) ? 'selected' : ''; }} value="3">Cat 3</option>
                              <option {{ ($item->category_id == 4) ? 'selected' : ''; }} value="4">Cat 4</option>
                              <option {{ ($item->category_id == 5) ? 'selected' : ''; }} value="5">Cat 5</option>
                              <option {{ ($item->category_id == 6) ? 'selected' : ''; }} value="6">Cat 6</option>
                              <option {{ ($item->category_id == 7) ? 'selected' : ''; }} value="7">Cat 7</option>
                              <option {{ ($item->category_id == 8) ? 'selected' : ''; }} value="8">Cat 8</option>
                              <option {{ ($item->category_id == 9) ? 'selected' : ''; }} value="9">Cat 9</option>
                              <option {{ ($item->category_id == 10) ? 'selected' : ''; }} value="10">Cat 10</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="quantity" class="block text-sm font-medium text-gray-900 lg:text-base">Quantity <span class="text-red-500">*</span></label>
                            <input type="text" id="quantity" name="quantity" value="{{ $item->quantity }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" required>
                        </div>
                        <div class="mb-2">
                            <label for="price" class="block text-sm font-medium text-gray-900 lg:text-base">Price</label>
                            <input type="text" id="price" name="price" value="{{ $item->price }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base">
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-900 lg:text-base" for="image">Image</label>
                            <input class="py-2 px-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none lg:text-base" id="image" name="image" type="file" accept="image/*">
                        </div>
                        <div class="flex justify-between">
                            <a href="{{ route('inventory.index') }}" class="text-white w-1/2 max-w-xs bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none tracking-wider font-semibold text-center">BACK</a>
                            <button type="submit" class="text-white w-1/2 max-w-xs bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none tracking-wider font-semibold">UPDATE</button>
                        </div>
                    </form>
                </div>
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
        });      
     </script>
</x-app-layout>
