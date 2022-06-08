@php


@endphp
<div>
    @if ($data['stockList']->whereNotNULL('stock_special_manager'))
        <div>
            <h3 class="uk-card-title">SPECIALS MANAGER</h3>

            <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
                <thead>
                    <tr>
                        <th>REF</th>
                       
                            <th>REF</th>
                            <th>NAME</th>
                            @for ($i = 0; $i < $data['settingModel']->setting_group['group_stock_cost']; $i++)
                                <th>{{$i + 1}}</th>
                            @endfor
                            <th>KPCAT</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                        
                        
                        
                    @foreach ($data['stockList']->whereNotNULL('stock_special_manager') as $stockModel)
                        @php
                            $category_id = json_decode($data['settingModel']->stock_merchandise, true)['category_id'];
                            $setting_stock_group = json_decode($data['settingModel']->setting_stock_group, true)[$category_id];
                            

                            $price = $stockModel->stock_cost[$j + 1][$i + 1]['price'];
                        @endphp
                        <tr>
                            <td>
                                <button class="uk-button uk-button-danger uk-border-rounded">
                                    {{ $stockModel->stock_id}}
                                </button>
                            </td>
                            <td>
                                {{$stockModel->stock_name}}
                            </td>

                            @for ($j=0; $j < count($data['stockModel']->stock_special_manager[1]); $j++)
                                <td>
                                    <input class="uk-input" id="form-stacked-text" type="number" step="0.01" value="{{$price}}" name="stock_cost[{{$j + 1}}][{{$i + 1}}][price]">
                                    
                                </td>
                                
                            @endfor

                            <td>
                                {{$setting_stock_group['description']}}
                            </td>
                        <tr>
                            
                    @endforeach

                       
                    
                </tbody>
            </table>
        </div>    
    @else
        <div>
            <h3 class="uk-card-title">SPECIALS MANAGER</h3>
            <h6>INSTRUCTIONS FOR USE</h6>
            <p class="uk-text-tiny">The Specials Manager widget is designed to allow limited access users to
                edit
                nominated fields of PLU's within defined PLU Ranges at a site level. <br> <br> To configure this
                widget
                please select a site from the Site Selecter at the top of the page and then click the settings
                link
                in
                the top right corner of this widget.</p>
        </div>
    @endif
</div>
