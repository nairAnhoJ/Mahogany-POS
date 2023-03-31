<x-app-layout>
    @section('page_title', 'KITCHEN DISPLAY')
    
    <div class="">
        <div style="height: calc(100vh - 96px);" class="flex">
            <div class="w-64 bg-gradient-to-r from-slate-800 to-slate-700">
                <div class="flex justify-between text-white font-bold text-lg p-2">
                    <h1>PRODUCT</h1>
                    <h1>QTY</h1>
                </div>
            </div>
            <div style="width: calc(100vw - 256px);" class="h-full overflow-y-auto bg-gray-200">
                <div style="height: calc(200vh - 208px);" class="grid grid-cols-4 grid-rows-4 gap-4 p-4">
                    <div class="bg-white overflow-hidden">
                        <div class="bg-red-500 grid grid-cols-2 h-8">
                            <div>TABLE 1</div>
                            <div>#9999</div>
                        </div>
                    </div>
                    <div class="bg-white">q</div>
                    <div class="bg-white">q</div>
                    <div class="bg-white">q</div>
                    <div class="bg-white">q</div>
                    <div class="bg-white">q</div>
                    <div class="bg-white">q</div>
                    <div class="bg-white">q</div>

                    <div class="bg-white">q</div>
                    <div class="bg-white">q</div>
                    <div class="bg-white">q</div>
                    <div class="bg-white">q</div>
                    <div class="bg-white">q</div>
                    <div class="bg-white">q</div>
                    <div class="bg-white">q</div>
                    <div class="bg-white">q</div>
                </div>
            </div>
        </div>
        <div class="h-12 flex">
            <div>

            </div>
        </div>
     </div>

    <script>
        $(document).ready(function() {

        });
    </script>
</x-app-layout>
