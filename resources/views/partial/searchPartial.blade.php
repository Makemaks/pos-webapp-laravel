@push('scripts')
    <script src="{{ asset('js/jsuites.js') }}"></script> 
@endpush

@php
    if(!isset($placeholder)){
        $placeholder = '';  
    }
@endphp

<div class="uk-input" id="jsuiteDropdownID"></div>
<input id="hiddenInputID" name="{{$hidden_field_name}}" value="" hidden>

@error($hidden_field_name)
    <div class="uk-text-danger">{{ $message }}</div>
@enderror

<script>

    jSuites.dropdown(document.getElementById('jsuiteDropdownID'), {
        url: '/v4/large',
        autocomplete: true,
        lazyLoading: true,
        placeholder: @json($placeholder),
        width: '280px',
        data:  @json($searchArray),
        onload: function GetElement(){
            document.getElementById('hiddenInputID').value = "";
        },
        onchange: function GetElement(){
            document.getElementById('hiddenInputID').value = this.value;
        }
    
    });

   

  /*   document.getElementById('jsuiteDropdownID').addEventListener('onchange', function(event) {
          document.getElementById('hiddenInputID').value = this.value;
    }); */
</script>