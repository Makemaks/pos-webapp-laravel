@php
    use App\Models\warehouse;
    $action =  Str::after(Request::route()->getName(), '.');
@endphp
<div class="">
    <form>
        <fieldset class="uk-fieldset">
    
            <legend class="uk-legend"></legend>

            <div class="uk-margin uk-text-center">
                <img class="uk-border-rounded" src="{{$data['warehouseModel']->warehouse_image}}" width="200" height="200">
                <div class="uk-margin" uk-margin>
                    <div uk-form-custom="target: true">
                        <input type="file">
                        <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
                    </div>
                </div>
                <div  class="uk-margin">
                   {{--  @if ($data['warehouseModel']->warehouse_id)
                        @if ($data['warehouseModel']->person_barcode)
                            {!!$data['warehouseModel']->person_barcode!!}
                            <a class="uk-margin uk-border-rounded uk-button uk-button-default uk-text-primary" href="{{route('init.print', ['membershipCard', $data['warehouseModel']->warehouse_id])}}" uk-icon="icon: print"></a>
                        @else
                            <a class="uk-border-rounded uk-button uk-button-default uk-text-primary" href="{{route('init.card', ['warehouse', $data['warehouseModel']->warehouse_id])}}" uk-icon="icon: credit-card"></a>
                        @endif
                    @endif --}}
                </div>
            </div>

           
            
            @include('person.partial.createPartial')
    
            <div class="uk-margin">
                <select class="uk-select">
                    @foreach (warehouse::warehouseType() as $typeItem => $typeValue)
                        <option value="{{$typeItem}}"{{ old('warehouse_type', $data['warehouseModel']->warehouse_type) == $typeItem ? ' selected="selected"' : '' }}>{{Str::ucfirst($typeValue)}}</option>                           
                    @endforeach
                </select>
            </div>
    
            <div class="uk-margin">
                <input class="uk-input" type="text" placeholder="Email" value="{{ old('email', $data['warehouseModel']->email) }}">
            </div>
            @error('email')
                    <div class="uk-text-danger">{{ $message }}</div>
            @enderror
    
            <div class="uk-margin">
                <input class="uk-input" type="text" placeholder="Password" value="{{ old('password') }}">
            </div>
            @error('passoword')
                    <div class="uk-text-danger">{{ $message }}</div>
            @enderror
            <div class="uk-margin">
                <button type="button" class="uk-button uk-button-default" onclick="generatePassword()" >Generate</button>
                <button type="button" class="uk-button uk-button-default" onclick="showPassword(this)">Show</button>
            </div>
            
            <div class="uk-margin">
                <select name="warehouse_is_notifiable" class="uk-select">
                   {{--  @foreach (warehouse::SelectType() as $count =>$type)
                        <option value="{{$count}}" {{ old('warehouse_is_notifiable', $data['warehouseModel']->warehouse_is_notifiable) == $count ? 'selected' : '' }}>{{$type}}</option>
                    @endforeach --}}
                </select>
            </div>
    
            <div class="uk-margin">
                <select name="warehouse_is_disabled" class="uk-select">
                   {{--  @foreach (warehouse::SelectType() as $count =>$type)
                        <option value="{{$count}}" {{ old('warehouse_is_disabled', $data['warehouseModel']->warehouse_is_disabled) == $count ? 'selected' : '' }}>{{$type}}</option>
                    @endforeach --}}
                </select>
            </div>
    
        </fieldset>
    </form>
    
</div>

