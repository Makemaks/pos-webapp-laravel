@php

    use App\Helpers\NumpadHelper;

    $lockScreenMenu = [
        'log out',
        'break',
        'cancel',
        
    ];
@endphp


<div class="uk-margin">
    <input class="uk-input" type="text" placeholder="xxxx" type="password">
</div>

<div class="uk-margin">
    <div class="uk-grid-small uk-child-width-1-4@s uk-text-center" uk-grid>
        @for ($i = 0; $i < count(NumpadHelper::Numpad()); $i++)
            
            
            @for ($j = 0; $j < count(NumpadHelper::Numpad()[$i]); $j++)
                
                    <div>
                        <div class="uk-padding-small uk-box-shadow-small uk-border-rounded" onclick="numpad(this)">
                            {{ NumpadHelper::Numpad()[$i][$j]}}
                        </div>
                    </div>
            @endfor
            

        @endfor
    </div>
</div>