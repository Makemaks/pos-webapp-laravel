@extends('layout.master')

@section('content')
    <div class="header">
        <h1 class="uk-heading-line uk-text-center"><span>{{ __('Events') }}</span></h1>
    </div>
    <div class="content">
        <ul class="uk-subnav uk-subnav-pill" uk-switcher>
            <li><a href="#" uk-icon="list"></a></li>
            @if(isset($viewer))
                <li><a href="#" uk-icon="plus"></a></li>
            @endif
        </ul>

        <ul class="uk-switcher uk-margin">
            <li class="uk-padding-small">
                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="uk-text-center">{{ __('Account') }}</th>
                        <th class="uk-text-center">{{ __('User') }}</th>
                        <th class="uk-width-small uk-text-center">{{ __('Name') }}</th>
                        <th class="uk-width-large uk-text-center">{{ __('Description') }}</th>
                        <th class="uk-width-medium uk-text-center">{{ __('Note') }}</th>
                        <th class="uk-width-medium uk-text-center">{{ __('Ticket') }}</th>
                        <th class="uk-width-medium uk-text-center">{{ __('File') }}</th>
                        <th class="uk-width-medium uk-text-center">{{ __('Floor plan') }}</th>
                        <th class="uk-width-small uk-text-center"></th>
                        <th class="uk-width-small uk-text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($events as $event)
                        <tr>
                            <th class="uk-text-center uk-text-middle">
                                {{ $event->getKey() }}
                            </th>
                            <th class="uk-text-center uk-text-middle">
                                {{ $event->event_account_id }}
                            </th>
                            <th class="uk-text-center uk-text-middle">
                                {{ $event->event_user_id }}
                            </th>
                            <th class="uk-width-small uk-text-center uk-text-middle">
                                {{ $event->event_name ?: '' }}
                            </th>
                            <th class="uk-width-xlarge uk-text-top">
                                {{ $event->event_description ?: '' }}
                            </th>
                            <th class="uk-width-xlarge uk-text-top"></span>
                                {{ $event->event_note['description'] ?? '' }}
                            </th>
                            <th class="uk-width-small uk-text-top">
                                <div>{{ !empty($event->event_ticket['name']) ? (__('Name') . ': ' . $event->event_ticket['name']) : '' }}</div>
                                <div>{{ !empty($event->event_ticket['type']) ? (__('Type') . ': ' . $event->event_ticket['type']) : '' }}</div>
                                <div>{{ !empty($event->event_ticket['quantity']) ? (__('Quantity') . ': ' . $event->event_ticket['quantity']) : '' }}</div>
                                <div>{{ !empty($event->event_ticket['cost']) ? (__('Cost') . ': ' . $event->event_ticket['cost']) : '' }}</div>
                                <div>{{ !empty($event->event_ticket['row']) ? (__('Row') . ': ' . $event->event_ticket['row']) : '' }}</div>
                            </th>
                            <th class="uk-width-small uk-text-center uk-text-middle">
                                @if(!empty($event->event_file) && !empty($event->event_file['name']))
                                    <a href="{{ asset('storage/' . $event->event_file['location']) }}" target="_blank">{{ __('open') }}</a>
                                @endif
                            </th>
                            <th class="uk-width-small uk-text-middle">
                                <div>{{ __('Building id') }}: {{ $event->event_floorplan['setting_building_id'] ?? '-' }}</div>
                                <div>{{ __('Room id') }}: {{ $event->event_floorplan['setting_room_id'] ?? '-' }}</div>
                            </th>
                            @if(isset($viewer) && (in_array($viewer->user_type, [0, 1]) || $event->event_user_id == $viewer->getKey()))
                                <td class="uk-width-small uk-text-middle">
                                    <a uk-icon="icon: pencil"
                                       href="{{ route('event.edit', ['event' => $event->getKey()]) }}"></a>
                                </td>
                                <td class="uk-width-small uk-text-middle">
                                    <a uk-toggle="target: #modal-event-{{ $event->getKey() }}" uk-icon="icon: trash"></a>
                                    @include('event.delete_confirmation', ['resource_id' => $event->getKey(), 'route_name' => 'event.destroy'])
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($events instanceof \Illuminate\Pagination\Paginator)
                    {{ $events->links() }}
                @endif
            </li>
            <li class="uk-padding-small">
                @if(isset($viewer))
                    @include('event.item_form', ['event' => null, 'route_name' => 'event.store'])
                @endif
            </li>
        </ul>
    </div>
@endsection


