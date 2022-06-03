<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Setting;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $datePeriod = Store::DatePeriod($request);

        // attendance by trail
        $this->attendanceModel = $datePeriod['attendanceModel'];

        // Account Last Used
        $this->accountModel = $datePeriod['accountModel'];

        // Account Company
        $this->accountCompanyModel = $datePeriod['accountCompanyModel'];

        // clerk Payrate
        $this->employmentList = $datePeriod['employmentList'];

        // dropdown option
        $this->clerkBreakdownOption = $datePeriod['clerkBreakdownOption'];

        // title and table each report
        $this->title = $datePeriod['title'];
        $this->table = $datePeriod['table'];

        // date period
        $this->started = $datePeriod['started'];
        $this->ended = $datePeriod['ended'];

        // addresses
        $this->addressCompany = $datePeriod['addressCompany'];
        $this->addressPerson = $datePeriod['addressPerson'];

        // dept average
        $this->settingModel = $datePeriod['settingModel'];
        $this->orderList = $datePeriod['orderList'];

        // If its export PDF / CSV
        if ($request->fileName) {

            // If PDF
            if ($request->format === 'pdf') {
                $this->pdfView = view('report.partial.pages.' . $request->fileName, ['data' => $this->Data()])->render();
                $render = \view('report.create', ['data' => $this->Data()])->render();
                $pdf = App::make('dompdf.wrapper');
                $pdf->loadHTML($render)->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf');
                return $pdf->stream();
            } else {
            }
        } else {

            // flushing sessions
            $request->session()->forget('date');
            $request->session()->forget('user');

            // New Session, If user Filter 
            if ($datePeriod['user_id']) {

                $request->session()->flash('user', [
                    'started_at' => $datePeriod['started'],
                    'ended_at' => $datePeriod['ended'],
                    'user_id' => $datePeriod['user_id'],
                    'title' => $datePeriod['title'],
                ]);
            } elseif ($request->started_at && $request->ended_at) {

                // if period/date range only
                $request->session()->flash('date', [
                    'started_at' => $datePeriod['started'],
                    'ended_at' => $datePeriod['ended'],
                    'title' => $datePeriod['title'],
                ]);
            } else {
                // No Filters
                $request->session()->flash('title', [
                    'title' => $datePeriod['title'],
                ]);
            }

            return view('report.index', ['data' => $this->Data()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function Data()
    {

        return [

            'attendanceModel' => $this->attendanceModel ?? null,
            'userModel' => $this->userModel ?? null,
            'orderHourly' => $this->orderHourly ?? null,
            'orderList' => $this->orderList ?? null,
            'orderSettingList' => $this->orderSettingList ?? null,
            'orderListASC' => $this->orderListASC ?? null,
            'orderListLimited100' => $this->orderListLimited100 ?? null,
            'storeList' => $this->storeList ?? null,
            'customerTop' => $this->customerTop ?? null,
            'clerkBreakdownOption' => $this->clerkBreakdownOption ?? null,
            'clerkBreakdown' => $this->clerkBreakdown ?? null,
            'pdfView' => $this->pdfView ?? null,
            'employmentList' => $this->employmentList ?? null,
            'csvView' => $this->csvView ?? null,
            'title' => $this->title ?? null,
            'started' => $this->started ?? null,
            'table' => $this->table ?? null,
            'ended' => $this->ended ?? null,
            'addressCompany' => $this->addressCompany ?? null,
            'addressPerson' => $this->addressPerson ?? null,
            'accountModel' => $this->accountModel ?? null,
            'accountCompanyModel' => $this->accountCompanyModel ?? null,
            'settingModel' => $this->settingModel ?? null,
        ];
    }
}
