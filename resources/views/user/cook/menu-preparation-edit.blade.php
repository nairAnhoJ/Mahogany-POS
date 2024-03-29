<x-app-layout>
    @section('page_title', 'MENU SETUP')

    <div class="">
        <div style="height: calc(100vh - 48px);" class="flex {{ auth()->user()->role == 1 ? 'lg:ml-64 lg:pt-3' : '' }}">
            <div id="contentDiv" class="p-2 w-full h-full">
                <div class="bg-white overflow-x-hidden overflow-y-scroll shadow-md rounded-lg py-3 px-5 h-full">
                    <form action="{{ route('menu.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="counter" name="counter" value="{{ ($ingredients->count() == 0) ? 1 : $ingredients->count(); }}">
                        <input type="hidden" name="slug" value="{{$slug}}">
                        <div class="w-full lg:w-2/5 flex justify-between mb-3 pr-1">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ ($item->is_combo == 1) ? 'checked' : '' }} type="checkbox" name="combo" id="combo" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900">Combo Meal</span>
                            </label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ ($item->is_hidden == 1) ? 'checked' : '' }} type="checkbox" name="hidden" id="hidden" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900">Hidden</span>
                            </label>
                        </div>
                        <div class="mb-2">
                            <label for="name" class="block text-sm font-medium text-gray-900 lg:text-base">Menu name<span class="text-red-500"> *</span></label>
                            <input type="text" id="name" name="name" value="{{ $item->name }}" class="block w-full lg:w-2/5 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" required autocomplete="off">
                        </div>
                        <div class="mb-2">
                            <label for="category_id" class="block text-sm font-medium text-gray-900 lg:text-base">Category<span class="text-red-500"> *</span></label>
                            <select id="category_id" name="category_id" value="{{ old('category_id') }}" class="bg-gray-50 lg:w-2/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 lg:text-base">
                                @foreach ($categories as $category)
                                    <option {{ ($item->category_id == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="price" class="block text-sm font-medium text-gray-900 lg:text-base">Price<span class="text-red-500"> *</span></label>
                            <input type="text" id="price" name="price" value="{{ $item->price }}" class="block w-full lg:w-2/5 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-900 lg:text-base" for="image">Image</label>
                            <input class="px-1 block w-full lg:w-2/5 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none lg:text-base" id="image" name="image" type="file" accept="image/*">
                        </div>

                        <div class="mb-2">
                            <label for="reorder_point" class="block text-sm font-medium text-gray-900 lg:text-base">Reorder Point<span class="text-red-500">*</span></label>
                            <input type="text" id="reorder_point" name="reorder_point" value="{{ $item->reorder_point }}" class="block w-full lg:w-2/5 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off" required>
                        </div>
                        <div class="mb-2">
                            <label for="servings" class="block text-sm font-medium text-gray-900 lg:text-base">Servings<span class="text-red-500 text-sm italic"> *please base on ingredients</span></label>
                            <input type="text" id="servings" name="servings" value="{{ $item->servings }}" class="block w-full lg:w-2/5 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" required autocomplete="off">
                        </div>

                        <div class="mt-7 mb-2 flex justify-between">
                            <h2 class="font-bold text-2xl italic">Ingredients</h2>
                            <button id="addButton" type="button" class="text-3xl text-blue-500"><i class="uil uil-plus-circle"></i></button>
                        </div>

                        <div class="mb-2 flex flex-row gap-x-3 h-6">
                            <div class="w-2/5 text-center">
                                <label class="block font-medium text-gray-900">Name</label>
                            </div>
                            <div class="w-2/5 text-center">
                                <label class="block font-medium text-gray-900">Quantity</label>
                            </div>
                            <div class="w-1/5 flex">
                                <div class="w-1/2"></div>
                                <div class="w-1/2 text-center">Remove</div>
                            </div>
                        </div>

                        <div id="ingredientsDiv">
                            @php
                                $counter = $ingredients->count() + 1;
                                $x = 1;
                                
                                if ($ingredients->count() > 0) {
                                    foreach ($ingredients as $ingredient){
                                        if ($ingredient->is_menu == 1) {
                                            $ingName = $ingredient->menu->name;
                                        }else{
                                            $ingName = $ingredient->inv->name;
                                        }
                                        echo
                                        '<div id="ing'.$x.'" class="mb-5 flex flex-row gap-x-3">
                                            <div class="w-2/5">
                                                <div class="wrapper w-full relative">
                                                    <div class="select-btn flex items-center justify-between rounded-md bg-gray-100 border border-gray-300 p-2 h-9 cursor-pointer">
                                                        <span>'.$ingName.'</span>
                                                        <i class="uil uil-angle-down text-2xl transition-transform duration-300"></i>
                                                    </div>
                                                    <div class="content bg-gray-100 mt-1 rounded-md p-3 hidden absolute w-full z-50">
                                                        <div class="search relative">
                                                            <i class="uil uil-search absolute left-3 leading-9 text-gray-500"></i>
                                                            <input type="text" class="selectSearch w-full leading-9 text-gray-700 rounded-md pl-9 outline-none h-9" placeholder="Search">
                                                        </div>
                                                        <ul class="listOption options mt-2 max-h-52 overflow-y-auto">
                                                            <li data-id="" data-name="" data-unit="" data-is_menu="" data-idnum="'.$x.'" class="h-9 cursor-pointer hover:bg-gray-300 rounded-md flex items-center pl-3 leading-9">None</li>
                                                            ';foreach ($items as $item){
                                                                echo '<li data-id="'.$item->id.'" data-name="MENU-'.$item->name.'" data-unit="'.$item->unit.'" data-is_menu="'.$item->is_menu.'" data-idnum="'.$x.'" class="h-9 cursor-pointer hover:bg-gray-300 rounded-md flex items-center pl-3 leading-9">'.$item->name.'</li>';
                                                            }
                                                        echo '</ul>
                                                    </div>
                                                    <input type="hidden" name="item'.$x.'" value="'.$ingredient->is_menu.','.$ingredient->inventory_id.'">
                                                </div>
                                            </div>
                                            <div class="w-2/5">
                                                <input type="text" id="quantity'.$x.'" name="quantity'.$x.'" value="'.number_format($ingredient->quantity, 2, '.', '').'" class="quantity block w-full h-9 px-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base text-center" autocomplete="off">
                                            </div>
                                            <div class="w-1/5 flex">
                                                <div id="unit'.$x.'" class="w-1/2 text-lg leading-9">'.$ingredient->unit.'</div>
                                                <button type="button" data-thisid="ing'.$x++.'" class="removeButton w-1/2 text-center"><i class="uil uil-minus-circle text-red-500 text-3xl"></i></button>
                                            </div>
                                        </div>';
                                    }
                                }else{
                                    echo '
                                        <div id="ing'.$x.'" class="mb-5 flex flex-row gap-x-3">
                                            <div class="w-2/5">
                                                <div class="wrapper w-full relative">
                                                    <div class="select-btn flex items-center justify-between rounded-md bg-gray-100 border border-gray-300 p-2 h-9 cursor-pointer">
                                                        <span></span>
                                                        <i class="uil uil-angle-down text-2xl transition-transform duration-300"></i>
                                                    </div>
                                                    <div class="content bg-gray-100 mt-1 rounded-md p-3 hidden absolute w-full z-50">
                                                        <div class="search relative">
                                                            <i class="uil uil-search absolute left-3 leading-9 text-gray-500"></i>
                                                            <input type="text" class="selectSearch w-full leading-9 text-gray-700 rounded-md pl-9 outline-none h-9" placeholder="Search">
                                                        </div>
                                                        <ul class="listOption options mt-2 max-h-52 overflow-y-auto">
                                                            <li data-id="" data-name="" data-unit="" data-is_menu="" data-idnum="'.$x.'" class="h-9 cursor-pointer hover:bg-gray-300 rounded-md flex items-center pl-3 leading-9">None</li>
                                                            ';foreach ($items as $item){
                                                                echo '<li data-id="'.$item->id.'" data-name="'.$item->name.'" data-unit="'.$item->unit.'" data-is_menu="'.$item->is_menu.'" data-idnum="'.$x.'" class="h-9 cursor-pointer hover:bg-gray-300 rounded-md flex items-center pl-3 leading-9">'.$item->name.'</li>';
                                                            }
                                                        echo '</ul>
                                                    </div>
                                                    <input type="hidden" name="item'.$x.'" value="">
                                                </div>
                                            </div>
                                            <div class="w-2/5">
                                                <input type="text" id="quantity'.$x.'" name="quantity'.$x.'" value="" class="quantity block w-full h-9 px-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base text-center" autocomplete="off">
                                            </div>
                                            <div class="w-1/5 flex">
                                                <div id="unit'.$x.'" class="w-1/2 text-lg leading-9"></div>
                                                <button type="button" data-thisid="ing'.$x++.'" class="removeButton w-1/2 text-center"><i class="uil uil-minus-circle text-red-500 text-3xl"></i></button>
                                            </div>
                                        </div>
                                    ';
                                }

                            @endphp
                        </div>

                        <div class="flex justify-between">
                            <a href="{{ route('menu.index') }}" class="text-white w-1/2 max-w-xs bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none tracking-wider font-semibold text-center">BACK</a>
                            <button type="submit" class="text-white w-1/2 max-w-xs bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none tracking-wider font-semibold">SUBMIT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
     </div>

    <script>
        $(document).ready(function() {

            var counter = "<?php echo $counter; ?>";
            counter++;

            jQuery(document).on( "click", ".select-btn", function(e){
                $('.content').not($(this).closest('.wrapper').find('.content')).addClass('hidden');
                $(this).closest('.wrapper').find('.content').toggleClass('hidden');
                $(this).closest('.wrapper').find('.uil-angle-down').toggleClass('-rotate-180');
                e.stopPropagation();
            });

            function searchFilter(searchInput){
                $(".listOption li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchInput) > -1)
                });
            }

            jQuery(document).on( "click", ".content", function(e){
                e.stopPropagation();
            });
            
            jQuery(document).on( "input", ".selectSearch", function(){
                var value = $(this).val().toLowerCase();
                searchFilter(value);
            });

            jQuery(document).on( "click", ".listOption li", function(){
                var id = $(this).data('id');
                var name = $(this).data('name');
                var unit = $(this).data('unit');
                var is_menu = $(this).data('is_menu');
                var unitid = 'unit' + $(this).data('idnum');
                var qtyid = 'quantity' + $(this).data('idnum');

                if(id != ""){
                    $(this).closest('.wrapper').find('input').val(is_menu+','+id);
                    $(this).closest('.wrapper').find('.select-btn span').html(name);
                }else{
                    $(this).closest('.wrapper').find('input').val('');
                    $(this).closest('.wrapper').find('.select-btn span').html('');
                }

                $('.content').addClass('hidden');
                $('.selectSearch').val('');
                var value = $(".selectSearch").val().toLowerCase();
                searchFilter(value);

                $('#' + unitid).html(unit);
                $('#' + qtyid).val('');
                $('.uil-angle-down').removeClass('-rotate-180');

            });

            $(document).click(function() {
                $('.content').addClass('hidden');
                $('.uil-angle-down').removeClass('-rotate-180');
            });

            jQuery(document).on( "keyup", ".quantity", function(){
                var val = $(this).val().replace(/[^0-9.]/g, '');
                $(this).val(val);
            });

            $('#addButton').click(function(){
                if($('#combo').is(":checked")){
                    var combo = true;
                }else{
                    var combo = false;
                }
                _token = $('input[name="_token"]').val();

                $.ajax({
                    url:"{{ route('menu.addIng') }}",
                    method:"POST",
                    data:{
                        combo: combo,
                        counter : counter,
                        _token: _token
                    },
                    success:function(result){
                        console.log(result);
                        $('#ingredientsDiv').append(result);
                        $('#counter').val(counter);
                    }
                })
                counter++;
            });

            jQuery(document).on( "click", ".removeButton", function(){
                var thisid = $(this).data('thisid');
                $('#'+thisid).remove();
            });

            jQuery(document).on( "click", "#combo", function(){
                if($(this).is(":checked")){
                    var combo = true;
                }else{
                    var combo = false;
                }
                _token = $('input[name="_token"]').val();

                $.ajax({
                    url:"{{ route('menu.changeIng') }}",
                    method:"POST",
                    data:{
                        combo: combo,
                        _token: _token
                    },
                    success:function(result){
                        $('#ingredientsDiv').html(result);
                    }
                })
            });
        });
    </script>
</x-app-layout>
