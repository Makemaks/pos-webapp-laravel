<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Setting;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

        // orderSetting List
        $this->orderSettingList = $datePeriod['orderSettingList'];

        // Stock Each Receipt List
        $this->orderListASC = $datePeriod['orderListASC'];

        // clerk List
        $this->clerkList = $datePeriod['clerkList'];

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

        // dd($this->settingModel);

        $this->is_pdf_csv = 0;
        // If its export PDF / CSV
        if ($request->fileName) {
            // If PDF
            $this->title = $request->session()->get('title')['title'];
            $this->is_pdf_csv = 1;
            if ($request->format === 'pdf') {
                // dd($this->Data());
                $this->pdfView = view('report.partial.pages.' . $request->fileName, ['data' => $this->Data()])->render();
                // dd($this->pdfView);
                $render = \view('report.create', ['data' => $this->Data()])->render();
                $pdf = App::make('dompdf.wrapper');
                $pdf->loadHTML($render)->setPaper('a4', 'portrait')->setWarnings(false)->save('myfile.pdf');
                return $pdf->stream();
            } else if ($request->format === 'csv') {
                // dd($request->fileName);
                dd('csv');
                $arrayList = [];
                switch ($request->fileName) {
                    case 'payratePartial':
                        $datas = $this->employmentList->groupBy('user_id');
                        // dd($datas[0]);
                        foreach($datas as $index => $data) {
                            $timeIn = $data->created_at;
                            $rate = (int) json_decode($data->employment_user_pay)->pay_rate;
                            $userId = $data->user_id;
                            $name = json_decode($data->person_name)->person_firstname;
                            $timeOut = $data->created_at;

                            $totalHours = $timeOut->diff($timeIn);
                            $minutes = $totalHours->h * 60;
                            $total = ($rate / 60) * $minutes;
                            if($data->attendace_status == 0) {
                                $arrayList[$index] = [
                                    'Name' => json_decode($data->person_name)->person_firstname,
                                    'Clocked In' => $data->created_at,
                                    'Clocked Out' => $data->created_at,
                                    'Total Hours' => $data->created_at->diff($data->created_at),
                                    'Rate' => (int) json_decode($data->employment_user_pay)->pay_rate,
                                    'Total Wage' => \App\Helpers\MathHelper::FloatRoundUp($total, 2),
                                ];
                            }
                            // dd($arrayList);
                        }
                        break;
                    
                    case 'attendanceTrail':
                        # code...
                        break;
                    
                    case 'attendancePartial':
                        # code...
                        break;
                    
                    case 'attendanceHoursWorked':

                        break;

                    default:
                        # code...
                        break;
                }
                // --------------------------


                dd($this->Data());
                dd($request->fileName);
                dd($this->Data()['attendanceTrail']);
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->getCell('A1')->setValue('John');
                $sheet->getCell('A2')->setValue('Smith');
                $sheet->getCell('B1')->setValue('Test');

                $writer = new Xlsx($spreadsheet);
                // dd($sheet);
                $writer->save('hell_world.xlsx');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="myfile.xls"');
                header('Cache-Control: max-age=0');

                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
                $writer->save('php://output');

            }
        } else {
            // flushing sessions
            $request->session()->forget('date');
            $request->session()->forget('user');

            
            // New Session, If user Filter 
            if ($datePeriod['user_id']) {
                // dd($this->data()['employmentList']->first());
                $request->session()->put('user', [
                    'started_at' => $datePeriod['started'],
                    'ended_at' => $datePeriod['ended'],
                    'user_id' => $datePeriod['user_id'],
                    'title' => $datePeriod['title'],
                ]);
            } elseif ($request->started_at && $request->ended_at) {
                // dd($this->data()['employmentList']->first());
                // if period/date range only
                $request->session()->put('date', [
                    'started_at' => $datePeriod['started'],
                    'ended_at' => $datePeriod['ended'],
                    'title' => $datePeriod['title'],
                ]);
            } else {
                // dd($this->data()['employmentList']->first());
                // No Filters
                $request->session()->put('title', [
                    'title' => $datePeriod['title'],
                ]);
            }
            
            // dd($this->Data());
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
            'clerkList' => $this->clerkList ?? null,
            'is_pdf_csv' => $this->is_pdf_csv ? 1 : 0
        ];
    }
}
