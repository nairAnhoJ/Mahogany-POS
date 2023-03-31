<x-app-layout>

    @section('page_title', 'USER - EDIT')

    <div class="p-3 lg:ml-64 max-h-screen lg:pt-3 overflow-y-auto">
        
        {{-- <header class="bg-white shadow-md rounded-lg">
            <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    INVENTORY - ADD
                </h2>
            </div>
        </header> --}}
    
        <div id="contentDiv" class="p-2 w-full">
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-3">
                <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data" class="grid">
                    @csrf
                    <input type="hidden" name="slug" value="{{ $user->slug }}">
                    <div class="mb-2">
                        <label for="name" class="block text-sm font-medium text-gray-900 lg:text-base">Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off" required>
                    </div>
                    <div class="mb-2">
                        <label for="username" class="block text-sm font-medium text-gray-900 lg:text-base">Username <span class="text-red-500">*</span></label>
                        <input type="text" id="username" name="username" value="{{ $user->username }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off" required>
                    </div>

                    <div class="mb-2">
                        <label for="role" class="block text-sm font-medium text-gray-900 lg:text-base">Role<span class="text-red-500">*</span></label>
                        <select id="role" name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 lg:text-base">
                            <option {{ ($user->role == '1') ? 'selected' : '' }} value="1">Administrator</option>
                            <option {{ ($user->role == '2') ? 'selected' : '' }} value="2">Cashier</option>
                            <option {{ ($user->role == '3') ? 'selected' : '' }} value="3">Cook</option>
                            <option {{ ($user->role == '4') ? 'selected' : '' }} value="4">Reciever</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-900 lg:text-base">Password</label>
                        <input type="password" id="password" name="password" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base">
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-900 lg:text-base">Password Confirmation</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base">
                    </div>
                    <div class="flex justify-between">
                        <a href="{{ route('user.index') }}" class="text-white w-1/2 max-w-xs bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none tracking-wider font-semibold text-center">BACK</a>
                        <button type="submit" class="text-white w-1/2 max-w-xs bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none tracking-wider font-semibold">SUBMIT</button>
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
