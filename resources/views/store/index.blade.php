@extends('layout.master')
@inject('currencyHelper', 'App\Helpers\CurrencyHelper')
@php
    
@endphp
@section('content') 
<div class="uk-grid-match uk-child-width-1-4@m" uk-grid>
    @foreach ($data['storeList'] as $store)
        @php
          $open = '';
          if ($data['storeList']->first()->root_account_id == NULL) {
              $open = 'uk-open';
          }
        @endphp
        
          @include('store.partial.indexPartial')
        
    @endforeach
</div>
@endsection
