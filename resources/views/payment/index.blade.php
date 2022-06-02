@extends('layout.master')

@php
  
@endphp
@section('content')    
<div class="uk-child-width-1-2@s" uk-grid>
    
    @isset($data['cardList'])
        @foreach ($data['cardList'] as $item)       
            <div>
                <div class="uk-card uk-card-default uk-card-small uk-card-body">
                    <div uk-grid>
                        <div class="uk-width-expand"><h3 class="">{{$item->card_name}}</h3></div>
                        <div class="uk-margin-remove uk-align-right">
                            @include('partial.dropDownPartial')
                        </div>
                    </div>
                    <p>{{$stringHelper->Mask($item->card_number)}}</p>
                    <p>{{$item->card_type}}</p>
                </div>
            </div>
        @endforeach
    @endisset
    
</div>
@endsection
