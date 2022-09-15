@if($errors->any())
    @foreach ($errors->all() as $message) 
            
        <script>
                $(window).on('load', function(e) {
                    UIkit.notification(@json($message), 'danger'); 
                })
        </script>
    
    @endforeach
@endif 

@isset($success)
   

    <script>
            $(window).on('load', function(e) {
                UIkit.notification(@json($success), 'muted'); 
            })
    </script>
   
@endisset

{{-- 
@if($error)  
 
    <script>
            $(window).on('load', function(e) {
                UIkit.notification(@json(session()->get('error')), 'danger'); 
            })
    </script>
@endif --}}




