

<div  class="uk-card uk-card-default uk-padding">
    <h3>GENERAL</h3>
    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li><a href="#">Item</a></li>
        <li><a href="#">Item</a></li>
    </ul>
    
    <ul class="uk-switcher uk-margin">
        <li>
            <table class="uk-table uk-table-small uk-table-divider">
                <thead>
                    <tr>
                        <th></th>
                        <th>PLU</th>
                        <th>Table Heading</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($data['stockModel']->stock_merchandise['plu_id'])
                        @foreach ($data['stockModel']->stock_merchandise['plu_id']  as $keyPlu => $itemPlu)
                            <tr>
                                <td>
                                    <input type="checkbox">
                                </td>
                                <td>
                                    <select class="uk-select" name="stock_merchandise[plu_id]">
                                        <option selected="selected" disabled>SELECT ...</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                </tbody>
            </table>
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

