@php
     use App\Helpers\NumpadHelper;
     use App\Helpers\StringHelper;
     
     if (!isset($type)) {
        $type=1;
     }
@endphp

<div class="uk-margin">
    <input class="uk-input uk-form-width-expand" type="text" placeholder="" autofocus id="searchInputID" onchange="SearchInput(this)">
</div>

@if ($type == 0)
       
    <div>

       
    
        @for ($i = 0; $i < count(NumpadHelper::Numpad()); $i++)
                            
            <div class="uk-margin-small">
                <div class="uk-grid-small uk-child-width-expand uk-text-center uk-button-small" uk-grid>
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

@else

   
    <div>
        @for ($i = 0; $i < count(NumpadHelper::Keypad()[0]); $i++)
    
            <div class="uk-margin-small">
                <div class="uk-grid-small uk-child-width-expand uk-text-center uk-button-small" uk-grid>
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

@endif







