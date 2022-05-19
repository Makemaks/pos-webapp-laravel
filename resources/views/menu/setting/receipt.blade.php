@extends('layout.master')
@inject('settingModel', 'App\Models\Setting')

@php
    use App\Models\Setting;
    use App\Models\Project;
    use App\Models\Stock;
@endphp

@section('content')
    <h3>{{Str::upper(Request::get('view'))}}</h3>
   
    <div class="uk-grid-small uk-child-width-expand@s" uk-grid>
        <div>
            <form action="">
                @foreach ($data['settingModel']->setting_receipt as $setting_receipt)
                    @if ($setting_receipt['default'] == 0)
                        @foreach ($setting_receipt as $keySetting_receipt => $itemSetting_receipt)
                            <h5>{{Str::upper($keySetting_receipt)}}</h5>
                        {{--  @foreach ($itemSetting_receipt as $item)
                                @dump($item)
                            @endforeach --}}

                        @endforeach
                    @endif
                    
                @endforeach
            </form>
        </div>
        <div>
            <div class="uk-card uk-card-default uk-card-body">Item</div>
        </div>
      
    </div>
@endsection


