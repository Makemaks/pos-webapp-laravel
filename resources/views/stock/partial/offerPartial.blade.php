

<div  class="uk-card uk-card-default uk-padding">
    <h3>GENERAL</h3>
    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li><a href="#">Item</a></li>
        <li><a href="#">Item</a></li>
    </ul>
    
    <ul class="uk-switcher uk-margin">
        <li>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">PLU</label>
                <select class="uk-select" name="form[stock_nutrition]" id="">
                    <option selected disabled>SELECT...</option>
                    {{-- 
                    @foreach ($data['settingModel']->setting_stock_nutrition as $item)
                            <option value="">{{$item}}</option>
                    @endforeach --}}
                </select>
            </div>
        </li>
        <li>
            
        </li>
    </ul>

</div>


<div class="uk-margin">
    <div class="uk-card uk-card-default uk-padding">
    
    
    
        <div>
            <h3></h3>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">SET MENU</label>
                <select class="uk-select" name="form[stock_nutrition]" id="">
                    <option selected disabled>SELECT...</option>
                    {{-- 
                    @foreach ($data['settingModel']->setting_stock_nutrition as $item)
                            <option value="">{{$item}}</option>
                    @endforeach --}}
                </select>
            </div>
        </div>
        
        
        <div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">MIX & MATCH</label>
                <select class="uk-select" name="form[stock_nutrition]" id="">
                    <option selected disabled>SELECT...</option>
                    {{-- 
                    @foreach ($data['settingModel']->setting_stock_nutrition as $item)
                            <option value="">{{$item}}</option>
                    @endforeach --}}
                </select>
            </div>
        </div>
        
    </div>
</div>

