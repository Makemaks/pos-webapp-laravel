@php
   use App\Models\Stock;
   use App\Helpers\ConfigHelper;
@endphp


<div class="uk-grid-match uk-grid-small uk-child-width-1-2" uk-grid>

   
        <div>
            <div class="uk-card uk-card-default uk-padding">
                <h3>GENERAL</h3>
                
                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                          {{--  @foreach ($tableHeader as $item)
                                <th>{{$item}}</th>
                           @endforeach --}}
                        </tr>
                    </thead>
                    <tbody>
                       {{-- @foreach (ConfigHelper::Nutrition() as $key => $item)
                            <tr>
                                <td><a href="{{route('stock.edit', $stock->stock_id)}}" class="uk-button uk-button-danger uk-border-rounded">{{$stock->stock_id}}</a></td>
                                <td>{{$stock->stock_name}}</td>
                                <td>{{$stock->stock_plu_id}}</td>
                                <td>{{$stock->stock_random_code}}</td>
                                <td>{{$stock->stock_quantity}}</td>
                            </tr>
                       @endforeach --}}
                    </tbody>
                </table>
           
                
            </div>
        </div>
   
  
</div>

