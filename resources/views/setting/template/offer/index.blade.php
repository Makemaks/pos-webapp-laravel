@extends('layout.master')

@section('content')
    <div class="uk-container">
        <div class="uk-card uk-box-shadow-large uk-card-body uk-border-rounded uk-background-muted">
            <div uk-grid>
                <div class="uk-width-auto uk-flex-first uk-padding-remove">
                    <div class="uk-width-medium uk-padding uk-padding-remove-vertical">
                        <div class="uk-padding-small uk-padding-remove uk-width-1-1">
                            <h2 class="uk-text-uppercase uk-text-bold">Gift<br>voucher</h2>
                        </div>
                        <div class="uk-padding-small uk-padding-remove uk-width-1-1">
                            <h1 class="uk-heading-large uk-text-uppercase uk-text-bold uk-margin-remove-bottom">£10</h1>
                        </div>
                    </div>
                </div>
                <div class="uk-width-expand uk-flex-last uk-padding-remove">
                    <div class="ul-width-large uk-padding-small uk-padding-remove-vertical">
                        <div uk-grid>
                            <div class="uk-width-expand">
                                <div class="uk-padding uk-padding-remove-horizontal uk-padding-remove-top uk-text-emphasis">
                                    There are many variations of passages of Lorem Ipsum available, but the majority have suffered
                                    alteration in some form, by injected humour, or randomised words which don't look even slightly believable.
                                </div>
                            </div>
                            <div class="uk-width-auto">
                                <div class="uk-padding uk-padding-remove-horizontal uk-padding-remove-top uk-text-emphasis">
                                    <h1 class="uk-heading-medium" uk-icon="icon: play-circle; ratio: 3"></h1>
                                </div>
                            </div>
                        </div>
                        <div>
                            <form>
                                <div class="uk-margin">
                                    <div class="uk-form-controls">
                                        <input class="uk-input uk-border-rounded" id="name" type="text" placeholder="Name">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <div class="uk-form-controls">
                                        <input class="uk-input uk-border-rounded" id="expired" type="text" placeholder="Expired">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


