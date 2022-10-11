<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class ReservationController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $users =  User::get();
        $reservationList = Reservation::paginate(10);
        return view('reservation.index', compact('reservationList','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $users =  User::get();
        return view('reservation.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(isset($request->is_delete_request)) {
            foreach($request->reservation as $reservationData) {
                if(isset($reservationData['checked_row'])) {
                    Reservation::where('reservation_id',$reservationData['reservation_id'])->delete();
                }
            }
            return redirect()->route('reservation.index');
        }
        if($request->has('reservation')) {
            foreach($request->reservation as $reservationData) {
                Reservation::where('reservation_id',$reservationData['reservation_id'])->update($reservationData);
                return redirect()->route('reservation.index');
            }
        } else {
            $reservation = $request->except('_token');
            Reservation::create($reservation);
            return redirect()->route('reservation.index');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $users =  User::get();    
        $reservation = Reservation::find($id);
        return view('reservation.edit', compact('reservation','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reservation = $request->except('_token','_method');
        Reservation::where('reservation_id',$id)->update($reservation);
        return redirect()->route('reservation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {   
    dd($request->all());
       Reservation::destroy($id);
       return redirect()->route('reservation.index');
    }
}
