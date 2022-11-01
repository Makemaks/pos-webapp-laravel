@extends('layout.master')

@section('content')
    <div class="uk-container">
        <div class="uk-card uk-box-shadow-large uk-card-body uk-background-muted uk-padding-remove">
            <div uk-grid class="uk-margin-remove">
                <div class="uk-width-auto uk-flex-first uk-background-primary uk-padding-remove">
                    <div class="uk-width-medium uk-padding-small uk-text-center">
                        <h1 uk-icon="icon: bookmark; ratio: 2"></h1>
                    </div>
                </div>
                <div class="uk-width-auto uk-flex-first uk-padding-remove">
                    <hr class="uk-divider-vertical uk-height-1-1">
                </div>
                <div class="uk-width-expand uk-flex-last uk-background-primary uk-padding-remove">
                    <div class="uk-padding-small uk-width-1-1 uk-text-center">
                        <h2 class="uk-margin-remove">PosWebapp</h2>
                    </div>
                </div>
            </div>

            <div uk-grid class="uk-margin-remove">
                <div class="uk-width-auto uk-flex-first uk-padding-remove">
                    <div class="uk-width-medium">
                        <div class="uk-padding-remove uk-width-1-1">
                            <h2 class="uk-heading-medium uk-text-uppercase uk-text-bold uk-text-center uk-margin-remove-bottom">150</h2>
                        </div>
                        <div class="uk-padding-remove uk-width-1-1">
                            <h3 class="uk-text-uppercase uk-text-bold uk-text-center">Seat</h3>
                        </div>
                        <div class="uk-padding-remove uk-width-1-1 uk-text-center">
                            <img src="{{ asset('images/qr_code.png') }}" width="100" height="100" class="">
                        </div>
                    </div>
                </div>
                <div class="uk-width-auto uk-flex-first uk-padding-remove">
                    <hr class="uk-divider-vertical uk-height-1-1">
                </div>
                <div class="uk-width-expand uk-flex-last uk-padding-remove">
                    <div class="ul-width-large uk-padding-small uk-padding-remove-vertical">
                        <div uk-grid>
                            <div class="uk-width-expand">
                                <div class="uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top uk-text-emphasis">
                                    <h3 class="uk-margin-remove">Contrary to popular belief</h3>
                                    <span class="uk-text-muted">Event</span>
                                </div>
                                <div class="uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top uk-text-emphasis">
                                    <h3 class="uk-margin-remove">Nickolay Mykhalko</h3>
                                    <span class="uk-text-muted">Name</span>
                                </div>
                                <div uk-grid class="uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top uk-text-emphasis">
                                    <div class="uk-width-auto">
                                        <h3 class="uk-margin-remove">150</h3>
                                        <span class="uk-text-muted">Seat</span>
                                    </div>
                                    <div class="uk-width-auto">
                                        <h3 class="uk-margin-remove">12:00</h3>
                                        <span class="uk-text-muted">time</span>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-auto">
                                <div class="uk-padding-remove uk-height-1-1 uk-text-center">
                                    <img src="{{ asset('images/qr_code.png') }}" width="200" height="200">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


