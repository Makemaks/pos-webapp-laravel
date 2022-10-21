@php
use App\Models\Stock;
use App\Helpers\ConfigHelper;
@endphp


<div class="uk-grid-match uk-grid-small uk-child-width-1-2@xl" uk-grid>

    @foreach (ConfigHelper::TerminalFlag() as $key => $terminalFlag)
        <div>
            <div class="uk-card uk-card-default uk-padding">
                <h3>{{ Str::upper($key) }}</h3>

                <div class="uk-child-width-1-2@s" uk-grid>

                    @foreach ($terminalFlag as $keyflag => $flag)
                        @php
                            $checked = '';
                            $isflag = array_search($keyflag, $data['stockModel']->stock_terminal_flag[$key]);
                            if ($isflag) {
                                $checked = 'checked';
                            }
                        @endphp
                        <div>
                            <input class="uk-checkbox" type="checkbox" {{ $checked }}
                            value="{{ $key }}"
                            name="stock_terminal_flag[{{ $key }}][{{ $keyflag }}]">
                            <label class="uk-form-label">{{ Str::upper($flag) }}</label>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
    @endforeach


</div>
