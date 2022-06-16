@php
    use App\Helpers\StringHelper;
    use App\Models\Setting;
    use App\Models\Stock;
@endphp

<nav class="uk-navbar-container uk-margin-bottom" uk-navbar>
    <div class="uk-navbar-left">

        <div class="uk-navbar-item">
           <div>
                <h3 class="uk-margin-remove-bottom">{{Str::ucfirst(Session::get('view'))}}</h3>
                <p class="uk-text-meta uk-margin-remove-top">{{$data['settingModel']->setting_pos[1]['name']}}</p>
           </div>
        </div>
    </div>


    <div class="uk-navbar-right">

        <div class="uk-navbar-item">
            <form action="javascript:void(0)">
                {{-- <input class="uk-input uk-form-width-medium" type="text" placeholder="" id="inputID"> --}}
                <a class="uk-button uk-button-default uk-border-rounded" href="#modal-center" uk-toggle uk-icon="icon: search"></a>
                @include('partial.numpadPartial')
                
                <div class="uk-inline">
                    <button class="uk-button uk-button-default uk-border-rounded" type="button"><span uk-icon="icon:  triangle-down"></span></button>
                    <div uk-dropdown="mode: click; boundary: ! .uk-button-group; boundary-align: true;">
                        <ul class="uk-nav uk-dropdown-nav">
                            <li class="uk-nav-header">Home</li>
                            @foreach (Setting::SettingStockCostGroup() as $item)
                                <li><a href="{{route('home.index', ['id' => $loop->iteration,'type' => $item])}}">{{Str::ucfirst($item)}}</a></li>
                            @endforeach
                            
                            <li class="uk-nav-header">Top Brands</li>
                            <li><a href="#">Item</a></li>
                            <li><a href="#">Item</a></li>
                            <li class="uk-nav-divider"></li>
                            <li><a href="#">Item</a></li>
                        </ul>
                    </div>
                </div>
                
            </form>
        </div>

   </div>

</nav>



    
@if ($data['settingModel']->setting_stock_group && Session::has('view'))
   
    
   
    <div class="uk-grid-small uk-child-width-1-4@s" uk-grid>


        @foreach ($data['settingModel']->setting_stock_group  as $keysetting_stock_group => $setting_stock_group)
        
            <div>
                <a class="uk-link-reset" href="{{route('home.index', ['id' => $keysetting_stock_group, 'view' => Session::get('view')])}}">
            
                    <div class="uk-padding-small uk-height-small uk-light uk-border-rounded" style="background-color: #{{StringHelper::getColor()}}">
                        
                        <div>
                            <div uk-grid>
                                <div class="uk-width-expand">
                                    <span class="uk-text-lead">{{Str::ucfirst($setting_stock_group['description'])}}</span>
                                </div>
                                <div class="uk-align-right uk-width-auto">
                                    @if (Session::get('id') == $keysetting_stock_group)
                                        <input class="uk-radio" type="radio" checked>
                                    @endif
                                </div>
                            </div>
                        
                        
                            <div class="uk-margin">
                                @php
                                        $where = 'stock_merchandise->'.Session::get('view').'_id';
                                @endphp
                                {{Stock::where($where, $keysetting_stock_group)->count()}} Item(s)
                            </div>
                        </div>
                    
                    </div>
                   
                </a>
            </div>
                                            
        @endforeach
    </div>
    <hr>
@else
  
    <p class="uk-text-danger">No Records</p>
    <hr>
@endif
  

