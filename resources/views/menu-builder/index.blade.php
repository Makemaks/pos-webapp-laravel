@extends('layout.master')

@section('content')
    <div class="header">
        <h1 class="uk-heading-line uk-text-center"><span>{{ __('Menu Builder') }}</span></h1>
    </div>
    <div class="content">
        <div uk-grid class="uk-margin-remove">
            <div class="uk-width-auto uk-flex-first uk-padding-remove">
                <div class="uk-width-medium uk-padding-small">
                    <span>MENU...</span>
                </div>
            </div>
            <div class="uk-width-expand uk-flex-last uk-padding-small">
                <div uk-grid class="uk-margin-remove">
                    <div class="uk-width-1-1 uk-flex-first uk-padding-remove">
                        <div class="uk-width-1-1 uk-padding-small uk-padding-remove-bottom">
                            <div uk-grid class="uk-margin-remove uk-background-primary">
                                <div class="uk-width-1-4@m uk-padding-remove uk-margin-remove">
                                    <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large uk-text-capitalize">Sign On</button>
                                </div>
                                <div class="uk-width-1-4@m uk-padding-remove uk-margin-remove">
                                    <div uk-grid class="uk-margin-remove">
                                        <div class="uk-width-1-2@m uk-padding-remove uk-margin-remove">
                                            <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large"><span uk-icon="icon: home; ratio: 1.5"></span></button>
                                        </div>
                                        <div class="uk-width-1-2@m uk-padding-remove uk-margin-remove">
                                            <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large"><span uk-icon="icon: more; ratio: 1.5"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-width-1-4@m uk-padding-remove uk-margin-remove">
                                    <div uk-grid class="uk-margin-remove">
                                        <div class="uk-width-1-2@m uk-padding-remove uk-margin-remove">
                                            <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large uk-text-capitalize">Prev</button>
                                        </div>
                                        <div class="uk-width-1-2@m uk-padding-remove uk-margin-remove">
                                            <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large"><span uk-icon="icon: print; ratio: 1.5"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-width-1-4@m uk-padding-remove uk-margin-remove">
                                    <div uk-grid class="uk-margin-remove">
                                        <div class="uk-width-1-2@m uk-padding-remove uk-margin-remove">
                                            <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large uk-text-capitalize">T</button>
                                        </div>
                                        <div class="uk-width-1-2@m uk-padding-remove uk-margin-remove">
                                            <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large uk-text-capitalize">Er</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div uk-grid class="uk-margin-remove">
                                @foreach(['&nbsp;','&nbsp;','&nbsp;','&nbsp;'] as $title)
                                    <div class="uk-width-1-4@m uk-padding-remove uk-margin-remove">
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large">{!! $title !!}</button>
                                    </div>
                                @endforeach
                            </div>
                            <div uk-grid class="uk-margin-remove">
                                @foreach(['&nbsp;','&nbsp;','&nbsp;','&nbsp;'] as $title)
                                    <div class="uk-width-1-4@m uk-padding-remove uk-margin-remove">
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large">{!! $title !!}</button>
                                    </div>
                                @endforeach
                            </div>
                            <div uk-grid class="uk-margin-remove">
                                @foreach(['&nbsp;','&nbsp;','&nbsp;','&nbsp;'] as $title)
                                    <div class="uk-width-1-4@m uk-padding-remove uk-margin-remove">
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large">{!! $title !!}</button>
                                    </div>
                                @endforeach
                            </div>
                            <div uk-grid class="uk-margin-remove">
                                @foreach(['&nbsp;','&nbsp;','&nbsp;','&nbsp;'] as $title)
                                    <div class="uk-width-1-4@m uk-padding-remove uk-margin-remove">
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large">{!! $title !!}</button>
                                    </div>
                                @endforeach
                            </div>
                            <div uk-grid class="uk-margin-remove">
                                @foreach(['&nbsp;','&nbsp;','&nbsp;','&nbsp;'] as $title)
                                    <div class="uk-width-1-4@m uk-padding-remove uk-margin-remove">
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large">{!! $title !!}</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-auto uk-flex-first uk-padding-remove uk-margin-remove">
                        <div class="uk-width-medium uk-padding-small uk-padding-remove-right uk-padding-remove-top">
                            <div uk-grid class="uk-margin-remove">
                                <div class="uk-width-2-3 uk-padding-remove">
                                    <button class="uk-button uk-button-default uk-width-1-1 uk-text-large uk-padding-small uk-text-primary">C</button>
                                </div>
                                <div class="uk-width-1-3 uk-padding-remove uk-margin-remove default-height-element">
                                    <button class="uk-button uk-button-default uk-width-1-1 uk-text-large uk-padding-small uk-text-primary">X</button>
                                </div>
                            </div>
                            <div uk-grid class="uk-margin-remove">
                                @foreach([7, 8, 9] as $title)
                                    <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove">
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-text-large uk-padding-small">{{ $title }}</button>
                                    </div>
                                @endforeach
                            </div>
                            <div uk-grid class="uk-margin-remove">
                                @foreach([4, 5, 6] as $title)
                                    <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove">
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-text-large uk-padding-small">{{ $title }}</button>
                                    </div>
                                @endforeach
                            </div>
                            <div uk-grid class="uk-margin-remove">
                                @foreach([1, 2, 3] as $title)
                                    <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove">
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-text-large uk-padding-small">{{ $title }}</button>
                                    </div>
                                @endforeach
                            </div>
                            <div uk-grid class="uk-margin-remove">
                                @foreach(['0', '00', '.'] as $title)
                                    <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove">
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-text-large uk-padding-small">{{ $title }}</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-expand uk-flex-last uk-padding-remove uk-margin-remove">
                        <div class="uk-width-1-1 uk-padding-small uk-padding-remove-left uk-padding-remove-top">
                            <div uk-grid class="uk-margin-remove uk-background-primary">
                                @foreach(['CHEQUE' => '', 'ERROR CORR' => 'uk-text-lowercase', 'SUSPEND' => 'uk-text-lowercase'] as $title => $class)
                                    <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove">
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-height-1-1 uk-padding-small uk-text-large {{ $class }}">{{ $title }}</button>
                                    </div>
                                @endforeach
                            </div>
                            <div uk-grid class="uk-margin-remove uk-background-primary">
                                @foreach(['CREDIT CARD' => '', 'cancel' => 'uk-text-lowercase', 'RESUME' => 'uk-text-lowercase'] as $title => $class)
                                    <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove">
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-height-1-1 uk-padding-small uk-text-large {{ $class }}">{{ $title }}</button>
                                    </div>
                                @endforeach
                            </div>
                            <div uk-grid class="uk-margin-remove uk-background-primary">
                                @foreach(['SUBTOTAL' => '', 'NO SALE' => 'uk-text-lowercase', 'PLU SEARCH' => 'uk-text-lowercase'] as $title => $class)
                                    <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove">
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-height-1-1 uk-padding-small uk-text-large {{ $class }}">{{ $title }}</button>
                                    </div>
                                @endforeach
                            </div>
                            <div uk-grid class="uk-margin-remove uk-background-primary">
                                <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove" uk-height-match=".double-height-element">
                                    <button class="uk-button uk-button-default uk-width-1-1 uk-height-1-1 uk-text-large uk-padding-small uk-height-1-1 uk-text-success">CASHE</button>
                                </div>
                                <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove double-height-element">
                                    <div uk-grid class="uk-margin-remove">
                                        <div class="uk-width-1-1@m uk-padding-remove uk-margin-remove">
                                            <button class="uk-button uk-button-default uk-width-1-1 uk-height-1-1 uk-padding-small uk-text-large uk-text-lowercase">REFUND</button>
                                        </div>
                                        <div class="uk-width-1-1@m uk-padding-remove uk-margin-remove">
                                            <div uk-grid class="uk-margin-remove">
                                                <div class="uk-width-1-2 uk-padding-remove uk-margin-remove">
                                                    <button class="uk-button uk-button-default uk-width-1-1 uk-height-1-1 uk-padding-small uk-text-large uk-text-lowercase">+%</button>
                                                </div>
                                                <div class="uk-width-1-2 uk-padding-remove uk-margin-remove">
                                                    <button class="uk-button uk-button-default uk-width-1-1 uk-height-1-1 uk-padding-small uk-text-large uk-text-lowercase">-%</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove">
                                    <div uk-grid class="uk-margin-remove">
                                        <div class="uk-width-1-1@m uk-padding-remove uk-margin-remove">
                                            <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large uk-text-lowercase">ACCOUNT</button>
                                        </div>
                                        <div class="uk-width-1-1@m uk-padding-remove uk-margin-remove">
                                            <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large uk-text-lowercase">REDEEM</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


