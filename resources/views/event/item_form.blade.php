@php
$event = $event ?? null;
@endphp
<form action="{{ route($route_name, $event ? $event->getKey() : []) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($method))
        @method('PUT')
    @endif
    <input type="hidden" name="event_account_id" value="{{ $viewer->user_account_id }}">
    <input type="hidden" name="event_user_id" value="{{ $viewer->getKey() }}">
    <div uk-grid>
        <div class="uk-width-medium">
            <label class="uk-form-label uk-text-muted" for="new_event_name">{{ __('Name') }}</label>
            <div class="uk-form-controls">
                <input type="text" class="uk-input" id="new_event_name" name="event_name" value="{{ $event ? $event->event_name : '' }}" required>
            </div>
        </div>
    </div>
    <div uk-grid>
        <div class="uk-width-xlarge">
            <label class="uk-form-label uk-text-muted" for="new_event_description">{{ __('Description') }}</label>
            <div class="uk-form-controls">
                <textarea class="uk-textarea" id="new_event_description" name="event_description">{{ $event ? $event->event_description : '' }}</textarea>
            </div>
        </div>
    </div>
    <div uk-grid>
        <div class="uk-width-xlarge">
            <label class="uk-form-label uk-text-muted" for="new_event_note_description">{{ __('Note') }}</label>
            <div class="uk-form-controls">
                <textarea class="uk-textarea" id="new_event_note_description" name="event_note[description]">{{ $event ? $event->event_note['description'] : '' }}</textarea>
            </div>
        </div>
    </div>
    <div uk-grid>
        <div class="uk-width-medium">
            <label class="uk-form-label uk-text-muted" for="new_event_ticket_name">{{ __('Ticket name') }}</label>
            <div class="uk-form-controls">
                <input type="text" class="uk-input" id="new_event_ticket_name" name="event_ticket[name]" value="{{ $event ? $event->event_ticket['name'] : '' }}">
            </div>
        </div>
        <div class="uk-width-medium">
            <label class="uk-form-label uk-text-muted" for="new_event_ticket_type">{{ __('Ticket type') }}</label>
            <select class="uk-select" id="new_event_ticket_type" name="event_ticket[type]">
                <option value="">{{ __('Please select...') }}</option>
                @php $event_ticket_type_value = $event ? $event->event_ticket['type'] : null; @endphp
                @foreach(\App\Models\Event::ticketType() as $key => $ticket_type)
                    <option value="{{ $key }}"{{ $event_ticket_type_value && $event_ticket_type_value == $key ? ' selected' : '' }}>{{ $ticket_type }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div uk-grid>
        <div class="uk-width-medium">
            <label class="uk-form-label uk-text-muted" for="new_event_ticket_quantity">{{ __('Ticket quantity') }}</label>
            <div class="uk-form-controls">
                <input type="number" class="uk-input" id="new_event_ticket_quantity" name="event_ticket[quantity]" min="0" value="{{ $event ? $event->event_ticket['quantity'] : '' }}">
            </div>
        </div>
        <div class="uk-width-medium">
            <label class="uk-form-label uk-text-muted" for="new_event_ticket_cost">{{ __('Ticket cost') }}</label>
            <div class="uk-form-controls">
                <input type="number" class="uk-input" id="new_event_ticket_cost" name="event_ticket[cost]" min="0" value="{{ $event ? $event->event_ticket['cost'] : '' }}">
            </div>
        </div>
    </div>
    <div uk-grid>
        <div class="uk-width-medium">
            <label class="uk-form-label uk-text-muted" for="new_event_ticket_row">{{ __('Ticket row') }}</label>
            <div class="uk-form-controls">
                <input type="number" class="uk-input" id="new_event_ticket_row" name="event_ticket[row]" min="0" value="{{ $event ? $event->event_ticket['row'] : '' }}">
            </div>
        </div>
    </div>
    <div uk-grid>
        <div class="uk-width-medium">
            <div uk-form-custom>
                <input type="file" name="event_file">
                <button class="uk-button uk-button-default uk-width-medium" type="button" tabindex="-1">{{ __('File') }}</button>
            </div>
        </div>
        @if($event && !empty($event->event_file['name']))
            <div class="uk-width-medium">
                <a class="uk-text-center uk-text-middle" href="{{ asset('storage/' . $event->event_file['location']) }}" target="_blank">{{ __('Open the file') }}</a>
            </div>
        @endif
    </div>
    <div uk-grid>
        <div class="uk-width-medium">
            <label class="uk-form-label uk-text-muted" for="new_event_floorplan_room">{{ __('Room') }}</label>
            <select class="uk-select" id="new_event_floorplan_room" name="event_floorplan[setting_room_id]">
                <option value="">{{ __('Please select...') }}</option>
                @php $event_setting_room_id_value = $event ? $event->event_floorplan['setting_room_id'] : '' @endphp
                @foreach($setting['setting_room'] ?? [] as $key => $setting_room)
                    <option value="{{ $key }}"{{ $event_setting_room_id_value && $event_setting_room_id_value == $key ? ' selected' : '' }}>{{$key . ' - ' . $setting_room['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="uk-child-width-expand" uk-grid>
        <div>
            <button type="submit"
                    class="uk-button uk-button-default uk-border-rounded uk-width-1-1 uk-button-primary"
            >{{ __('Save') }}</button>
        </div>
    </div>
</form>
