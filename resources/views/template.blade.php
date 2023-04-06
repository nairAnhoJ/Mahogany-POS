<x-app-layout>
    @section('page_title', 'INVENTORY')
    
    <div class="p-3 lg:ml-64 h-screen pt-14 lg:pt-3">
    
        <div class="py-3">
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-3">
                Content Here
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
