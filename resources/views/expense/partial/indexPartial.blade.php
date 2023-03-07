<button class="uk-button uk-button-default uk-border-rounded uk-button-primary top-save-btn">Save</button>
<a class="uk-button uk-button-danger uk-border-rounded delete-btn">Delete</a>
<ul class="uk-subnav uk-subnav-pill" uk-switcher>
    <li>
        <a href="#">
            Expense
        </a>
    </li>
    <li><a href="#" uk-icon="plus"></a></li>
</ul>
<ul class="uk-switcher uk-margin">
    <li>
        <form action="{{route('expense.store')}}" method="post">
            @csrf
            <table class="uk-table uk-table-small uk-table-divider">
                <thead>
                    <tr>
                        <th><input class="uk-checkbox expense-checkbox" type="checkbox"></th>
                        <th>Expense Amount</th>   
                        <th>Expense VAT</th>
                        <th>Expense Frequency</th>
                        <th>Expense Settings Expense Type</th>
                        <th>Expense Description</th>
                    </tr>
                </thead>

                <tbody>
                    <div id="appendDelete" style="display: none"></div>
                    @isset($expenses)
                    @foreach ($expenses as $key => $item)
                    <tr>
                        <input class="uk-input" type="hidden" name="expense[{{$key}}][expense_id]"
                            value="{{$item->expense_id ?? ''}}">
                        <td>
                            <input class="uk-checkbox" type="checkbox" name="expense[{{$key}}][checked_row]">
                        </td>
                        <td>
                            <input class="uk-input" type="number" name="expense[{{$key}}][expense_amount]"
                            value="{{$item->expense_amount ?? ''}}">
                        </td>
                        <td><input class="uk-input" type="number" name="expense[{{$key}}][expense_vat]"
                            value="{{$item->expense_vat ?? ''}}">
                        </td>
                        <td>
                            <select class="uk-select" name="expense[{{$key}}][expense_frequency]">
                                @for($i=1;$i<=12;$i++)
                                    <option value="{{$i}}" @if($item->expense_frequency == $i) selected @endif>
                                        {{$i}}
                                    </option>
                                @endfor
                            </select>
                        </td>
                        <td>
                            <select class="uk-select" name="expense[{{$key}}][expense_setting_expense_type]">
                                @for($i=1;$i<=5;$i++)
                                    <option value="{{$i}}" @if($item->expense_setting_expense_type == $i) selected @endif>
                                        {{$i}}
                                    </option>
                                @endfor
                            </select>
                        </td>
                        <td>
                            <textarea class="uk-textarea" name="expense[{{$key}}][expense_description]" id="" cols="30" rows="3">
                                {{$item->expense_description ?? ''}}
                            </textarea>
                        </td>
                    </tr>
                    @endforeach
                    @endisset
                </tbody>
            </table>
            <button class="uk-button uk-button-default uk-border-rounded uk-button-primary save-btn" style="display: none">Save</button>
        </form>
    </li>
    <li>
        <form action="{{route('expense.store')}}" method="post">
            @csrf
            <button class="uk-button uk-button-default uk-border-rounded uk-button-primary">Submit</button>
            <div class="uk-container uk-container-xsmall">
                <fieldset class="uk-fieldset">
                    <input type='hidden' name='is_save_request' value='true'>
                    <legend class="uk-legend"></legend>
                    <div class="uk-margin">
                        <label for="">Expense Amount</label>
                        <input class="uk-input" type="number" name="expense_amount">
                    </div>
                    <div class="uk-margin">
                        <label for="">Expense Vat</label>
                        <input class="uk-input" type="number" name="expense_vat">
                    </div>
                    <div class="uk-margin">
                        <label for="">Expense Frequency</label>
                        <select class="uk-select" name="expense_frequency">
                            @for($i=1;$i<=12;$i++)
                                <option value="{{$i}}">
                                    {{$i}}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="uk-margin">
                        <label for="">Expense Setting Expense Type</label>
                        <select class="uk-select" name="expense_setting_expense_type">
                            @for($i=1;$i<=5;$i++)
                                <option value="{{$i}}" @if($item->expense_setting_expense_type == $i) selected @endif>
                                    {{$i}}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="uk-margin">
                        <label for="">Expense Description</label>
                        <textarea class="uk-textarea" name="expense_description" cols="30" rows="3"></textarea>
                    </div>
                </fieldset>
            </div>
        </form>
    </li>
</ul>

{{-- @isset($expenses)
@include('partial.paginationPartial', ['paginator' => $expenses]) --}}
<script>
    $(document).on('click', '.expense-checkbox', function () {
        $(':checkbox').each(function () {
            this.checked = !this.checked;
        });
    });
    $(document).on('click', '.delete-btn', function () {
        $('#appendDelete').append("<input type='text' name='is_delete_request' value='true'></td>");
        $('.save-btn').click();
    });
    $(document).on('click','.top-save-btn', function() {
        $('.save-btn').click();
    });
</script>
{{-- @endisset --}}
