@php
   use App\Models\Stock;
   use App\Helpers\ConfigHelper;
@endphp


<div class="uk-grid-match uk-grid-small uk-child-width-1-2" uk-grid>

   @foreach (ConfigHelper::TerminalFlags() as $key => $terminalFlags)
        <div>
            <div class="uk-card uk-card-default uk-padding">
                <h3>{{Str::upper($key)}}</h3>
                
                <div uk-grid>
                    
                    @foreach ($terminalFlags as $item)
                        <div>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($item)}}</label>
                                <div class="uk-form-controls">
                                    <input class="uk-checkbox" type="checkbox">
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
                
            </div>
        </div>
   @endforeach
    
  
</div>

