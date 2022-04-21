@if($errors->any())
    @foreach ($errors->all() as $message) 
            
        <script>
                $(window).on('load', function(e) {
                    UIkit.notification(@json($message), 'danger'); 
                })
        </script>
    
    @endforeach
@endif 

@if(session()->get('success'))  
 
    <script>
            $(window).on('load', function(e) {
                UIkit.notification(@json(session()->get('success')), 'primary'); 
            })
    </script>
@endif


@if(session()->get('error'))  
 
    <script>
            $(window).on('load', function(e) {
                UIkit.notification(@json(session()->get('error')), 'danger'); 
            })
    </script>
@endif


