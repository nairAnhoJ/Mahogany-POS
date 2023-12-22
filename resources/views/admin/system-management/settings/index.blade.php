<x-app-layout>
    @section('page_title', 'SETTINGS')
    
    <div class="h-screen p-3 lg:ml-64 pt-14 lg:pt-3">
        <div class="py-3">
            <div class="bg-white overflow-x-hidden overflow-y-auto shadow-md rounded-lg p-5 h-[calc(100vh-48px)]">
                <form method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data" class="w-full h-full">
                    @csrf
                    <div class="text-xl font-bold">
                        General Settings
                    </div>
                    <div class="flex items-end gap-x-5">
                        <div class="w-2/3 mb-3">
                            <label class="block text-sm font-medium text-gray-900" for="logo">Logo</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" name="logo" type="file" accept="image/*">
                        </div>
                        <div class="flex items-center w-1/3 mb-2 overflow-hidden border shadow rounded-xl">
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
                        <label for="footer" class="block text-sm font-medium text-gray-900">Footer Message</label>
                        <input type="text" name="footer" value="{{ $settings->footer }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                        <input type="text" name="email" value="{{ $settings->email }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                    </div>

                    <hr class="mt-8 mb-6">
                    
                    <div class="mb-3 text-xl font-bold">
                        Pricing Report Settings
                    </div>
                    
                    <div class="mb-3">
                        <label for="buffer_margin" class="block text-sm font-medium text-gray-900">Buffer Margin (%)</label>
                        <input type="text" name="buffer_margin" value="{{ ($settings->buffer_margin * 100) }}" class="inputNumber bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="markup" class="block text-sm font-medium text-gray-900">Markup (%)</label>
                        <input type="text" name="markup" value="{{ ($settings->markup * 100) }}" class="inputNumber bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="price_adjustment" class="block text-sm font-medium text-gray-900">Price adjustment (%)</label>
                        <input type="text" name="price_adjustment" value="{{ ($settings->price_adjustment * 100) }}" class="inputNumber bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="staff_incentives" class="block text-sm font-medium text-gray-900">Staff Incentive (₱)</label>
                        <input type="text" name="staff_incentives" value="{{ $settings->staff_incentives }}" class="inputNumber bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="manager_incentives" class="block text-sm font-medium text-gray-900">Manager Incentives (%)</label>
                        <input type="text" name="manager_incentives" value="{{ ($settings->manager_incentives * 100) }}" class="inputNumber bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="vat" class="block text-sm font-medium text-gray-900">VAT (%)</label>
                        <input type="text" name="vat" value="{{ ($settings->vat * 100) }}" class="inputNumber bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off" required>
                    </div>

                    <hr class="mt-8 mb-6">
                    
                    <div class="mb-3 text-xl font-bold">
                        Other Settings
                    </div>

                    <div class="mb-6">
                        <label for="service_charge" class="block text-sm font-medium text-gray-900">Service Charge (₱)</label>
                        <input type="text" name="service_charge" value="{{ $settings->service_charge }}" class="inputNumber bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off" required>
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
        });
    </script>
</x-app-layout>
