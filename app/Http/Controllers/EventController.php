<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;
use App\Models\Setting;
use App\Models\User;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function index(Request $request)
    {
        $events = Event::orderBy('created_at', 'DESC')->simplePaginate(20);

        $viewer = \Auth::user();
        if ($viewer) {
            $account = User::Account('account_id', $viewer->user_account_id)->first();
            $setting = Setting::where('settingtable_id', $account->store_id)->first();
        }

        return view('event.index', ['events' => $events, 'viewer' => $viewer, 'setting' => $setting ?? null]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $viewer = \Auth::user();
        if (!$viewer) {
            return redirect()->route('authentication.login');
        }

        $account = User::Account('account_id', $viewer->user_account_id)->first();
        $setting = Setting::where('settingtable_id', $account->store_id)->first();

        return view('event.create', ['viewer' => $viewer, 'setting' => $setting]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $viewer = \Auth::user();
        if (!$viewer) {
            return redirect()->route('authentication.login');
        }

        $account = User::Account('account_id', $viewer->user_account_id)->first();
        $setting = Setting::where('settingtable_id', $account->store_id)->first();

        $values = $request->except('_token', '_method', 'created_at', 'updated_at');

        // event note
        $values['event_note']['user_id'] = $viewer->getKey();
        $values['event_note']['created_at'] = time();

        // setting_building_id
        if (!empty($values['event_floorplan']['setting_room_id']) && isset($setting['setting_room'][$values['event_floorplan']['setting_room_id']])) {
            $values['event_floorplan']['setting_building_id'] = $setting['setting_room'][$values['event_floorplan']['setting_room_id']]['setting_building_id'];
        }

        // upload file
        if ($request->has('event_file')) {
            $uploadedFile = $request->file('event_file');
            $filename = time().$uploadedFile->getClientOriginalName();
            Storage::disk('public')->putFileAs(
                'event',
                $uploadedFile,
                $filename
            );
            $values['event_file'] = [];
            $values['event_file']['user_id'] = $viewer->getKey();
            $values['event_file']['name'] = $filename;
            $values['event_file']['location'] = 'event/'.$filename;
            $values['event_file']['type'] = $uploadedFile->getClientMimeType();
        }

        // clear empty field
        $values = array_filter($values);
        $values = array_map(function($item) { return is_array($item) ? array_filter($item) : $item; }, $values);

        // parse default event attributes
        $event_attributes = (new Event)->getAttributes();
        $event_attributes = array_map(function ($item) { return json_decode($item, true); }, $event_attributes);

        // fill event values with default attributes
        $values = array_replace_recursive($event_attributes, $values);

        // create event
        $event = new Event($values);
        $event->save();

        return redirect()->route('event.index')->with('success', 'Event successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, $id)
    {
        $event = Event::find($id);
        if (!$event) {
            return redirect()->route('event.index')->withErrors(['error' => trans('Event not found')]);
        }

        return view('event.index', ['events' => [$event]]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $viewer = \Auth::user();
        if (!$viewer) {
            return redirect()->route('authentication.login');
        }

        $event = Event::find($id);
        if (!$event) {
            return redirect()->route('event.index')->withErrors(['error' => trans('Event not found')]);
        }

        if (!in_array($viewer->user_type, [0, 1]) && $event->event_user_id !== $viewer->getKey()) {
            return redirect()->back()->withErrors(['error' => trans('Permission denied')]);
        }

        $account = User::Account('account_id', $viewer->user_account_id)->first();
        $setting = Setting::where('settingtable_id', $account->store_id)->first();

        return view('event.edit', ['event' => $event, 'viewer' => $viewer, 'setting' => $setting]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $viewer = \Auth::user();
        if (!$viewer) {
            return redirect()->route('authentication.login');
        }

        $event = Event::find($id);
        if (!$event) {
            return redirect()->back()->withErrors(['error' => trans('Event not found')]);
        }

        if (!in_array($viewer->user_type, [0, 1]) && $event->event_user_id !== $viewer->getKey()) {
            return redirect()->back()->withErrors(['error' => trans('Permission denied')]);
        }

        $account = User::Account('account_id', $viewer->user_account_id)->first();
        $setting = Setting::where('settingtable_id', $account->store_id)->first();

        $values = $request->except('_token', '_method', 'created_at', 'updated_at');

        // event note
        $values['event_note']['user_id'] = $viewer->getKey();
        $values['event_note']['created_at'] = time();

        // setting_building_id
        if (!empty($values['event_floorplan']['setting_room_id']) && isset($setting['setting_room'][$values['event_floorplan']['setting_room_id']])) {
            $values['event_floorplan']['setting_building_id'] = $setting['setting_room'][$values['event_floorplan']['setting_room_id']]['setting_building_id'];
        }

        // upload file
        if ($request->has('event_file')) {
            $uploadedFile = $request->file('event_file');
            $filename = time().$uploadedFile->getClientOriginalName();
            Storage::disk('public')->putFileAs(
                'event',
                $uploadedFile,
                $filename
            );
            $values['event_file'] = [];
            $values['event_file']['user_id'] = $viewer->getKey();
            $values['event_file']['name'] = $filename;
            $values['event_file']['location'] = 'event/'.$filename;
            $values['event_file']['type'] = $uploadedFile->getClientMimeType();
            // drop old event file
            if (!empty($event->event_file['location']) && Storage::disk('public')->exists($event->event_file['location'])) {
                Storage::disk('public')->delete($event->event_file['location']);
            }
        }

        // clear empty field
        $values = array_filter($values);
        $values = array_map(function($item) { return is_array($item) ? array_filter($item) : $item; }, $values);

        // parse default event attributes
        $event_attributes = (new Event)->getAttributes();
        $event_attributes = array_map(function ($item) { return json_decode($item, true); }, $event_attributes);

        // fill event values with default attributes
        $values = array_replace_recursive($event_attributes, $values);

        // update event values
        $event->fill($values);
        $event->save();

        return redirect()->route('event.index')->with('success', 'Event successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $viewer = \Auth::user();
        if (!$viewer) {
            return redirect()->route('authentication.login');
        }

        $event = Event::find($id);
        if (!$event) {
            return redirect()->back()->withErrors(['error' => trans('Event not found')]);
        }

        if (!in_array($viewer->user_type, [0, 1]) && $event->event_user_id !== $viewer->getKey()) {
            return redirect()->back()->withErrors(['error' => trans('Permission denied')]);
        }

        // drop event file
        if (!empty($event->event_file['location']) && Storage::disk('public')->exists($event->event_file['location'])) {
            Storage::disk('public')->delete($event->event_file['location']);
        }
        $event->delete();
        return redirect()->route('event.index')->with('success', 'Successfully deleted');
    }
}
