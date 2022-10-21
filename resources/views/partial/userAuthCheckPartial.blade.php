@php

    use App\Helpers\NumpadHelper;

    $lockScreenMenu = [
        
        'cancel',
        
    ];
@endphp


<div class="uk-margin">
    <input class="uk-input" type="text" placeholder="xxxx" type="password" id="lockInputID">
</div>

<div class="uk-margin">
    <div class="uk-grid-small uk-child-width-1-3@s uk-text-center" uk-grid>
        @for ($i = 0; $i < count(NumpadHelper::Lockpad()); $i++)
            
            
            @for ($j = 0; $j < count(NumpadHelper::Lockpad()[$i]); $j++)
                
                    <div>
                        <div class="uk-padding-small uk-box-shadow-small uk-border-rounded" onclick="lockscreen(this)">
                            {{ NumpadHelper::Lockpad()[$i][$j]}}
                        </div>
                    </div>
            @endfor
            

        @endfor
    </div>
</div>

<script>
    function lockscreen(element){

        var lockInputID = document.getElementById('lockInputID')
        lockInputID.value = lockInputID.value + element.innerText;
    }
</script>