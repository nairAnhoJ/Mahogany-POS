<x-app-layout>
    @section('page_title', 'SETTINGS')
    
    <div class="p-3 lg:ml-64 h-screen pt-14 lg:pt-3">
        <div class="py-3">
            <div class="bg-white overflow-x-hidden overflow-y-auto shadow-md rounded-lg p-5 h-[calc(100vh-48px)]">
                <form method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data" class="w-full h-full">
                    @csrf
                    <div class="flex gap-x-5 items-end">
                        <div class="mb-3 w-2/3">
                            <label class="block text-sm font-medium text-gray-900" for="logo">Logo</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" name="logo" type="file" accept="image/*">
                        </div>
                        <div class="w-1/3 border mb-2 rounded-xl overflow-hidden flex items-center shadow">
                            <img src="{{ asset('storage/'.$settings->logo) }}" class="w-full" alt="">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="block text-sm font-medium text-gray-900">Restaurant Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ $settings->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="block text-sm font-medium text-gray-900">Address <span class="text-red-500">*</span></label>
                        <input type="text" name="address" value="{{ $settings->address }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="number" class="block text-sm font-medium text-gray-900">Contact Number</label>
                        <input type="text" name="number" value="{{ $settings->number }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-bold rounded-lg text-sm px-10 py-2.5 mr-2 mb-2 focus:outline-none">Save</button>
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
        });
    </script>
</x-app-layout>
