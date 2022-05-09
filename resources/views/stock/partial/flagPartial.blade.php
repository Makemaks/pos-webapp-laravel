@php
   use App\Models\Stock;
   use App\Helpers\ConfigHelper;
@endphp


<div class="uk-grid-match uk-grid-small uk-child-width-1-2@xl" uk-grid>

   @foreach (ConfigHelper::TerminalFlag() as $key => $terminalFlag)
        <div>
            <div class="uk-card uk-card-default uk-padding">
                <h3>{{Str::upper($key)}}</h3>
                
                <div uk-grid>
                    
                    @foreach ($terminalFlag as $keyflag => $flag)
                        @php
                            $checked = "";
                            $isflag = array_search($keyflag, $data['stockModel']->stock_terminal_flag[$key]);
                            if($isflag){
                                $checked = 'checked';
                            }
                        @endphp
                        <div>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($flag)}}</label>
                                <div class="uk-form-controls">
                                    <input class="uk-checkbox" type="checkbox" {{$checked}} value="1" name="stock_terminal_flag[{{$key}}][{{$keyflag}}]">
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
                
            </div>
        </div>
   @endforeach
    
  
</div>

