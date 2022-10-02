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
                <input id="searchInputID" class="uk-input uk-form-width-large" type="text" autofocus onclick="showKeypad()" 
                onchange="searchInput(this)" autocomplete="off">
                {{-- <input autofocus class="uk-input uk-form-width-large" type="text" id="keypadInputID" hidden> --}}
            </div>
        </div>
        
        <div class="uk-navbar-right">
            <div class="uk-navbar-item">
                <button class="uk-button uk-button-default" onclick="closeKeypad()">X</button>
            </div>
       </div>
       
    </nav>
    
   {{--  @if ($type == 0) --}}
        {{-- uppercase --}}
        <div id="layoutUpperID" hidden>
        
            @for ($i = 0; $i < count(NumpadHelper::Keypad()[0]); $i++)
        
                <div class="uk-margin-small">
                    <div class="uk-grid-small uk-child-width-expand uk-text-center" uk-grid>
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
    
    {{-- @else --}}
       {{-- lowercase --}}
        <div id="layoutLowerID" hidden>
            
            @for ($i = 0; $i < count(NumpadHelper::Keypad()[1]); $i++)
        
                <div class="uk-margin-small">
                    <div class="uk-grid-small uk-child-width-expand uk-text-center" uk-grid>
                        @for ($j = 0; $j < count(NumpadHelper::Keypad()[1][$i]); $j++)
                            
                                <div>
                                    <div class="uk-padding-small uk-box-shadow-small uk-border-rounded" onclick="numpad(this)">
                                        {{ NumpadHelper::Keypad()[1][$i][$j] }}
                                    </div>
                                </div>
                        @endfor
                    </div>
                </div>
    
            @endfor
        </div>

        {{-- other characters--}}
        <div id="layoutCharacterID" hidden>
            
            @for ($i = 0; $i < count(NumpadHelper::Keypad()[2]); $i++)
        
                <div class="uk-margin-small">
                    <div class="uk-grid-small uk-child-width-expand uk-text-center" uk-grid>
                        @for ($j = 0; $j < count(NumpadHelper::Keypad()[2][$i]); $j++)
                            
                                <div>
                                    <div class="uk-padding-small uk-box-shadow-small uk-border-rounded" onclick="numpad(this)">
                                        {{ NumpadHelper::Keypad()[2][$i][$j]}}
                                    </div>
                                </div>
                        @endfor
                    </div>
                </div>
    
            @endfor
        </div>
    
</div>

<script>

    {
        letterType = 'lowercase';
    }

    function numpad(element){
        
        var searchInputID = document.getElementById('searchInputID');
        
    
        if (element.innerText == 'C') {
            searchInputID.value = '';
        } 
        else if (element.innerText == 'Back') {
            let str =  searchInputID.value;
            searchInputID.value = str.slice(0, -1);
        } 
        else if (element.innerText == 'Space') {
            let str =  searchInputID.value;
            searchInputID.value = searchInputID.value + ' ';
        } 
        else if (element.innerText == 'Shift') {
            let str =  searchInputID.value;
            searchInputID.value = str.slice(0, -1);
        } 
        else if (element.innerText == 'Enter') {
            update(element);
          
        } 
        else if (element.innerText == 'Aa') {

            if ( letterType == 'lowercase' ) {
                letterType = 'uppercase';
                document.getElementById('layoutUpperID').hidden = false;
                document.getElementById('layoutCharacterID').hidden = true;
                document.getElementById('layoutLowerID').hidden = true;
            } else {
                letterType = 'lowercase';
                document.getElementById('layoutUpperID').hidden = true;
                document.getElementById('layoutCharacterID').hidden = true;
                document.getElementById('layoutLowerID').hidden = false;
            }
        } 
        else if (element.innerText == 'fn') {
           
            letterType = 'charactercase';
            document.getElementById('layoutUpperID').hidden = true;
            document.getElementById('layoutCharacterID').hidden = false;
            document.getElementById('layoutLowerID').hidden = true;

        } 
        else {
            searchInputID.value = searchInputID.value + element.innerText;
        }

        setFocus('keypadInputID');
    
    }

    function showKeypad(element, type = null){
       
        if (type != 'lockScreen') {
            document.getElementById('navigationBottomID').hidden = true;
           
        }

        document.getElementById('keypadID').hidden = false;
        document.getElementById('layoutUpperID').hidden = true;
        document.getElementById('layoutCharacterID').hidden = true;
        document.getElementById('layoutLowerID').hidden = false;
        letterType = 'lowercase';
        //sessionStorage.setItem('buttonType', element.id);
        sessionStorage.setItem('openKeypad', true);
      
        
    }

    function closeKeypad(){
        document.getElementById('keypadID').hidden = true;
        document.getElementById('navigationBottomID').hidden = false;
        document.getElementById('searchInputID').value = '';
        document.getElementById('searchInputID').focus();
        sessionStorage.setItem('openKeypad', false);
        //sessionStorage.removeItem('buttonType');
    }

</script>








