@extends('layout.master')

@section('content')
    <div class="header">
        <h1 class="uk-heading-line uk-text-center"><span>{{ __('Menu Builder') }}</span></h1>
    </div>
    <div class="content">
        <div uk-grid class="uk-margin-remove">
            <div class="uk-width-auto uk-flex-first uk-padding-small">
                <div uk-grid class="uk-margin-remove">
                    <form action="#" method="POST" onsubmit="javascript: return false;">
                        <fieldset class="uk-fieldset">

                            <legend class="uk-legend">Legend</legend>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="level">Level</label>
                                <div class="uk-form-controls">
                                    <select class="uk-select" id="level" name="level">
                                        @for($i = 1; $i < 11; $i++)
                                            <option value="{{ $i }}">Level {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">File</label>
                                <div class="uk-form-controls">
                                    <select class="uk-select" id="function" name="file">
                                        <option value="">No Function</option>
                                    </select>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <div uk-grid class="uk-margin-remove">
                                    <div class="uk-padding-remove uk-width-1-4">
                                        <div class="uk-margin uk-margin-small-right">
                                            <label class="uk-form-label" for="record">Record</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input" id="record" type="text" value="0" name="record">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-padding-remove uk-width-3-4">
                                        <div class="uk-margin uk-margin-small-left">
                                            <label class="uk-form-label" for="record-select">&nbsp;</label>
                                            <div class="uk-form-controls">
                                                <select class="uk-select" id="record-select" name="record_select">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <div uk-grid class="uk-margin-remove">
                                    <div class="uk-padding-remove uk-width-4-5">
                                        <div class="uk-margin">
                                            <label class="uk-form-label" for="keyboard">Keyboard Text</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input" id="keyboard" type="text" name="keyboard">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-padding-remove uk-width-1-5">
                                        <div class="uk-margin uk-margin-small-left">
                                            <label class="uk-form-label" for="keyboard-icon">&nbsp;</label>
                                            <div class="uk-form-controls">
                                                <button type="button" class="uk-button uk-button-default uk-padding-remove uk-width-1-1" id="keyboard-icon"><span uk-icon="icon: image; ratio: 1.5"></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="font">Font</label>
                                <div class="uk-form-controls">
                                    <select class="uk-select" id="font" name="font">
                                        <option value="courier_new_bold_16">Courier New Bold 16</option>
                                        <option value="helvetica">Helvetica</option>
                                        <option value="arial">Arial</option>
                                        <option value="arial_black">Arial Black</option>
                                        <option value="times_new_roman">Times New Roman</option>
                                        <option value="georgia">Georgia</option>
                                        <option value="comic_sans_ms">Comic Sans MS</option>
                                    </select>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="button_style">Button Style</label>
                                <div class="uk-form-controls">
                                    <select class="uk-select" id="button_style" name="button_style">
                                        <option value="small_button_light">Small button light</option>
                                        <option value="small_button_bold">Small button bold</option>
                                        <option value="large_button_light">Large button light</option>
                                        <option value="large_button_bold">Large button bold</option>
                                    </select>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="text_colour">Text Colour</label>
                                <div class="uk-form-controls">
                                    <select class="uk-select" id="text_colour" name="text_colour">
                                        <option value="black">Black</option>
                                        <option value="red">Red</option>
                                        <option value="white">White</option>
                                        <option value="blue">Blue</option>
                                        <option value="yellow">Yellow</option>
                                        <option value="grey">Grey</option>
                                    </select>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="text_colour">Background Colour</label>
                                <div class="uk-form-controls">
                                    <select class="uk-select" id="background_colour" name="background_colour">
                                        <option value="black">Black</option>
                                        <option value="red">Red</option>
                                        <option value="white">White</option>
                                        <option value="blue">Blue</option>
                                        <option value="yellow">Yellow</option>
                                        <option value="grey">Grey</option>
                                    </select>
                                </div>
                            </div>

                            <div class="uk-margin uk-grid-small uk-child-width-auto">
                                <label><input class="uk-radio" type="radio" name="type" value="live_edit"> Live Edit</label>
                                <label><input class="uk-radio" type="radio" name="type" value="schedule" checked> Schedule</label>
                            </div>

                            <div class="uk-margin">
                                <button type="submit"
                                        class="uk-button uk-button-default uk-border-rounded uk-width-1-1 uk-button-primary"
                                >Save changes</button>
                            </div>

                        </fieldset>
                    </form>
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
                            @for($i = 0; $i < 5; $i++)
                                <div uk-grid class="uk-margin-remove">
                                    @foreach(['&nbsp;','&nbsp;','&nbsp;','&nbsp;'] as $title)
                                        <div class="uk-width-1-4@m uk-padding-remove uk-margin-remove">
                                            <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large">{!! $title !!}</button>
                                        </div>
                                    @endforeach
                                </div>
                            @endfor
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
                                @foreach(['&nbsp;', '&nbsp;', '&nbsp;'] as $title)
                                    <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove">
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-height-1-1 uk-padding-small uk-text-large">{!! $title !!}</button>
                                    </div>
                                @endforeach
                            </div>
                            <div uk-grid class="uk-margin-remove uk-background-primary">
                                @foreach(['&nbsp;', '&nbsp;', '&nbsp;'] as $title)
                                    <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove">
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-height-1-1 uk-padding-small uk-text-large">{!! $title !!}</button>
                                    </div>
                                @endforeach
                            </div>
                            <div uk-grid class="uk-margin-remove uk-background-primary">
                                @foreach(['&nbsp;', '&nbsp;', '&nbsp;'] as $title)
                                    <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove">
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-height-1-1 uk-padding-small uk-text-large">{!! $title !!}</button>
                                    </div>
                                @endforeach
                            </div>
                            <div uk-grid class="uk-margin-remove uk-background-primary">
                                <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove" uk-height-match=".double-height-element">
                                    <button class="uk-button uk-button-default uk-width-1-1 uk-height-1-1 uk-padding-small uk-height-1-1 uk-text-large">&nbsp;</button>
                                </div>
                                <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove double-height-element">
                                    <div uk-grid class="uk-margin-remove">
                                        <div class="uk-width-1-1@m uk-padding-remove uk-margin-remove">
                                            <button class="uk-button uk-button-default uk-width-1-1 uk-height-1-1 uk-padding-small uk-text-large">&nbsp;</button>
                                        </div>
                                        <div class="uk-width-1-1@m uk-padding-remove uk-margin-remove">
                                            <div uk-grid class="uk-margin-remove">
                                                <div class="uk-width-1-2 uk-padding-remove uk-margin-remove">
                                                    <button class="uk-button uk-button-default uk-width-1-1 uk-height-1-1 uk-padding-small uk-text-large">&nbsp;</button>
                                                </div>
                                                <div class="uk-width-1-2 uk-padding-remove uk-margin-remove">
                                                    <button class="uk-button uk-button-default uk-width-1-1 uk-height-1-1 uk-padding-small uk-text-large">&nbsp;</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-width-1-3@m uk-padding-remove uk-margin-remove">
                                    <div uk-grid class="uk-margin-remove">
                                        <div class="uk-width-1-1@m uk-padding-remove uk-margin-remove">
                                            <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large">&nbsp;</button>
                                        </div>
                                        <div class="uk-width-1-1@m uk-padding-remove uk-margin-remove">
                                            <button class="uk-button uk-button-default uk-width-1-1 uk-padding-small uk-text-large">&nbsp;</button>
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


