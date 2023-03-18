<x-app-layout>

    @section('page_title', 'INVENTORY - ADD')

    <div class="p-3 lg:ml-64 max-h-screen pt-14 lg:pt-3 overflow-y-auto">
        
        {{-- <header class="bg-white shadow-md rounded-lg">
            <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    INVENTORY - ADD
                </h2>
            </div>
        </header> --}}
    
        <div class="">
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-3">
                <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data" class="grid">
                    @csrf
                    <div class="mb-2">
                        <label for="item_code" class="block text-sm font-medium text-gray-900">Item Code</label>
                        <input type="text" id="item_code" name="item_code" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="mb-2">
                        <label for="name" class="block text-sm font-medium text-gray-900">Item Name</label>
                        <input type="text" id="name" name="name" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div class="mb-2">
                        <label for="category_id" class="block text-sm font-medium text-gray-900">Category</label>
                        <select id="category_id" name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                          <option value="1">Cat 1</option>
                          <option value="2">Cat 2</option>
                          <option value="3">Cat 3</option>
                          <option value="4">Cat 4</option>
                          <option value="5">Cat 5</option>
                          <option value="6">Cat 6</option>
                          <option value="7">Cat 7</option>
                          <option value="8">Cat 8</option>
                          <option value="9">Cat 9</option>
                          <option value="10">Cat 10</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="quantity" class="block text-sm font-medium text-gray-900">Quantity</label>
                        <input type="text" id="quantity" name="quantity" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div class="mb-2">
                        <label for="price" class="block text-sm font-medium text-gray-900">Price</label>
                        <input type="text" id="price" name="price" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-900" for="image">Image</label>
                        <input class="py-2 px-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="image" name="image" type="file" accept="image/*">
                    </div>
                    <div>
                        <button type="submit" class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none tracking-wider font-semibold">SUBMIT</button>
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
        });      
     </script>
</x-app-layout>
