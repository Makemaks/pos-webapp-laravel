
@php
    use App\Models\Setting;
@endphp
@push('scripts')
    <script src="{{ asset('js/cart.js') }}"></script>
@endpush


<div class="">

    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Receipt Prefix" value="{{ old('setting_receipt_prefix', $data['settingModel']->setting_receipt_prefix) }}">
    </div>
    @error('setting_receipt_prefix')
            <div class="uk-text-danger">{{ $message }}</div>
    @enderror

    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Invoice Prefix" value="{{ old('setting_invoice_prefix', $data['settingModel']->setting_invoice_prefix) }}">
    </div>
    @error('setting_invoice_prefix')
            <div class="uk-text-danger">{{ $message }}</div>
    @enderror

    <div class="uk-margin">
        <div id="jsuiteProductCategoryID"></div>
        <input id="settingProductCategoryID" class="uk-input" type="text" placeholder="Setting Scheme" value="{{ old('setting_product_category', $data['settingModel']->setting_product_category) }}" hidden>
    </div>
    @error('setting_product_category')
            <div class="uk-text-danger">{{ $message }}</div>
    @enderror

    <div class="uk-margin">
        @include('partial.controlsPartial', ['quantity' => $data['settingModel']->setting_product_level])
    </div>
   
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Setting Vat" value="{{ old('setting_vat', $data['settingModel']->setting_vat) }}">
    </div>
    @error('setting_vat')
            <div class="uk-text-danger">{{ $message }}</div>
    @enderror

    <div class="uk-card uk-card-default uk-card-small uk-card-body uk-margin">
        <h5>Store API</h5>
        @foreach (Setting::API() as $setting)
            <div class="uk-margin">
                <input class="uk-input" type="text" placeholder="API Url" value="{{ old('setting_api', $data['settingModel']->setting_api) }}">
            </div>
            @error('setting_api')
                    <div class="uk-text-danger">{{ $message }}</div>
            @enderror
        @endforeach
    </div>

   
    
   

   
</div>

<script>
    jSuites.tags(document.getElementById('jsuiteProductCategoryID'), {
    placeholder: 'Product Category',
    value: '{{ old('setting_product_category', $data['settingModel']->setting_product_category) }}'
  });

  document.getElementById('jsuiteProductCategoryID').addEventListener('keydown', function(event) {
          document.getElementById('settingProductCategoryID').value = this.value;
    });
   
</script>
