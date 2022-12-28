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
                            <th>NAME</th>
                            @for ($i = 0; $i < count($data['settingModel']->setting_group); $i++)
                                <th>{{$i + 1}}</th>
                            @endfor
                            <th>KPCAT</th>
                       
                    </tr>
                </thead>
                <tbody>
                        
                    @php
                        $stockList = $data['stockList']->whereNotNULL('stock_manager_special')->take(5);
                    @endphp

                  

                  @foreach ($stockList as $stockModel)
                      
                            <tr>
                                <td>
                                    <button class="uk-button uk-button-default uk-border-rounded">
                                        {{$stockModel->stock_id}}
                                    </button>
                                </td>

                                <td>
                                    {{$stockModel->stock_merchandise['stock_name']}}
                                </td>

                                @for ($j=0; $j < count($stockModel->stock_manager_special); $j++)
                                    <td>
                                        @php
                                            $price = $stockModel->stock_manager_special[$j + 1][1]['price'];
                                        @endphp
                                        <input class="uk-input" id="form-stacked-text" type="number" step="0.01" value="{{$price}}" name="stock_price[{{$j + 1}}][{{$i + 1}}][price]">
                                        
                                    </td>           
                                @endfor

                                <td>
                                    {{$data['settingModel']->setting_stock_set[$stockModel->stock_merchandise['category_id']]['name']}}
                                </td>
                            
                            </tr>
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
