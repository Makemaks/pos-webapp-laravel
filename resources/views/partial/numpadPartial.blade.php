@php
     use App\Helpers\NumpadHelper;
     use App\Helpers\StringHelper;
     
     if (!isset($type)) {
        $type=1;
     }
@endphp

<div id="keypadID" hidden>


    <nav class="uk-navbar-container uk-margin" uk-navbar>

        <div class="uk-navbar-left">
            <a class="uk-navbar-item uk-logo" href="#">
                <span uk-icon="grid"></span>
            </a>
        </div>

        <div class="uk-navbar-center">
            
            <div class="uk-navbar-item">
                <input autofocus class="uk-input uk-form-width-large" type="text" id="keypadInputID" hidden>
            </div>
        </div>
        
        <div class="uk-navbar-right">
            <div class="uk-navbar-item">
                <button class="uk-button uk-button-default" onclick="closeKeypad()">X</button>
            </div>
       </div>
       
    </nav>
    
   {{--  @if ($type == 0) --}}
           
        <div id="numpadLayoutID" hidden>
        
            @for ($i = 0; $i < count(NumpadHelper::Numpad()); $i++)
                                
                <div class="uk-margin-small">
                    <div class="uk-grid-small uk-child-width-expand uk-text-center uk-button" uk-grid>
                        @for ($j = 0; $j < count(NumpadHelper::Numpad()[$i]); $j++)
                            
                                <div>
                                    <div class="uk-padding-small uk-box-shadow-small uk-border-rounded" onclick="numpad(this)">
                                        {{ NumpadHelper::Numpad()[$i][$j]}}
                                    </div>
                                </div>
                        @endfor
                    </div>
                </div>
        
            @endfor
    
        </div>
    
    {{-- @else --}}
       
        <div id="keypadLayoutID">
            
            @for ($i = 0; $i < count(NumpadHelper::Keypad()[0]); $i++)
        
                <div class="uk-margin-small">
                    <div class="uk-grid-small uk-child-width-expand uk-text-center uk-button-small uk-button" uk-grid>
                        @for ($j = 0; $j < count(NumpadHelper::Keypad()[0][$i]); $j++)
                            
                                <div>
                                    <div class="uk-padding-small uk-box-shadow-small uk-border-rounded" onclick="numpad(this)">
                                        {{ NumpadHelper::Keypad()[0][$i][$j]}}
                                    </div>
                                </div>
                        @endfor
                    </div>
                </div>
    
            @endfor
        </div>
    
    {{-- @endif --}}

</div>

<script>
    function numpad(element){

       
        var searchInputID = document.getElementById(sessionStorage.getItem('inputID'));
       

        setFocus('keypadInputID');
    
        if (element.innerText == 'C') {
            searchInputID.value = '';
        } 
        else if (element.innerText == 'BACK') {
            let str =  searchInputID.value;
            searchInputID.value = str.slice(0, -1);
        } 
        else if (element.innerText == 'SPACE') {
            let str =  searchInputID.value;
            searchInputID.value = searchInputID.value + ' ';
        } 
        else if (element.innerText == 'Shift') {
            let str =  searchInputID.value;
            searchInputID.value = str.slice(0, -1);
        } 
        else if (element.innerText == 'ENTER') {
            sessionStorage.removeItem('buttonType');
        } 
        else {
            searchInputID.value =  searchInputID.value + element.innerText;
        }

        
    
    }

    function showKeypad(element){
        document.getElementById('navigationBottomID').hidden = true;
        document.getElementById('keypadID').hidden = false;
        

        document.getElementById('numpadLayoutID').hidden = true;
        document.getElementById('keypadLayoutID').hidden = false;

        /* sessionStorage.setItem('inputID', element.id);
       if (element.id == 'receiptInputID') {
            document.getElementById('numpadLayoutID').hidden = false;
            document.getElementById('keypadLayoutID').hidden = true;
        }
        else if(element.id == 'numpadLayoutID'){
            document.getElementById('numpadLayoutID').hidden = true;
            document.getElementById('keypadLayoutID').hidden = false;
        } */

        
    }

    function closeKeypad(element){
        document.getElementById('keypadID').hidden = true;
        //document.getElementById('keypadInputID').value = '';
        document.getElementById('navigationBottomID').hidden = false;
        document.getElementById('searchInputID').focus();
    }

</script>








