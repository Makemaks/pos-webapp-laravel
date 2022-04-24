<fieldset class="uk-fieldset">

    <legend class="uk-legend">{{$data['storeModel']->store_name}}</legend>

    <div class="uk-margin">
        <img src="{{$data['storeModel']->store_image}}" alt="" width="200" height="100">
    </div>

    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Name" name="store_name" value="{{ old('store_name', $data['storeModel']->store_name ) }}"/>
    </div>
    @error('store_name')
        <div class="uk-text-danger">{{ $message }}</div>
    @enderror

    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Location" name="store_location" value="{{ old('store_location', $data['storeModel']->store_location ) }}"/>
    </div>
    @error('store_location')
        <div class="uk-text-danger">{{ $message }}</div>
    @enderror

    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Vat" name="store_vat" value="{{ old('store_vat', $data['storeModel']->store_vat ) }}"/>
    </div>
    @error('store_vat')
        <div class="uk-text-danger">{{ $message }}</div>
    @enderror

    <div class="uk-margin">
        <div id="jsuiteBusinessHoursID"></div>
        <input class="uk-input" type="text" placeholder="Business Hours" name="store_business_hours" value="{{ old('store_business_hours', $data['storeModel']->store_business_hours ) }}" hidden/>
    </div>
    @error('store_business_hours')
        <div class="uk-text-danger">{{ $message }}</div>
    @enderror


   @if ($data['storeList'] && count($data['storeList']) > 0)
        <div class="uk-margin">
            <label for="">
                <input class="uk-checkbox" type="checkbox" name="store_is_main" value="{{ old('store_is_main') }}"/>
                Main
            </label>
        </div>
        @error('store_is_main')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
   @endif
</fieldset>

<script>
    jSuites.tags(document.getElementById('jsuiteBusinessHoursID'), {
    placeholder: 'Business Hours',
    value: '{{ old('store_business_hours', $data['storeModel']->store_business_hours) }}'
  });

  document.getElementById('jsuiteBusinessHoursID').addEventListener('keydown', function(event) {
          document.getElementById('settingBusinessHoursID').value = this.value;
    });

</script>
