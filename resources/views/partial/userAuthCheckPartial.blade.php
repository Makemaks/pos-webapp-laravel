@php

    use App\Helpers\NumpadHelper;

    $lockScreenMenu = [
        
        'cancel',
        
    ];
@endphp


<div class="uk-margin">
    <input class="uk-input" type="text" placeholder="xxxx" type="password" id="lockInputID" onkeyup="unlockScreen(this)">
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
        if(element.innerText != "Back") {
            lockInputID.value = lockInputID.value + element.innerText;
        } else {
            lockInputID.value = lockInputID.value.length >= 1 ? lockInputID.value.substr(0, lockInputID.value.length - 1) : '';
        }
        unlockScreen(lockInputID);
    }

    function unlockScreen(lockInput){
        const value = lockInput.value;
        if(value.length == 4) {
            $.ajax({        
                url:"app-api/",
                method: 'GET',
                data: {
                    lock_screen: true,
                    pin: value
                },      
                success:function(data){
                    if(data.status) {
                        UIkit.modal($('#modal-lock-screen-center')).hide();
                        localStorage.setItem('lock_screen', 0);
                    }
                }
            });  
        } else {
            console.log('Pin code should be length of 4 digits.');
        }
    }
</script>