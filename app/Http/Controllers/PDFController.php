<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use App\Models\Funct;
use App\Models\Approval;
use App\Models\Duration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    public function print($print)
    {
        $functs = Funct::all();

        $data = [
            'number' => 1,
            'functs' => $functs
        ];

        if ($print == 'ipcr') {
            $pdf = PDF::loadView('print.ipcr', $data);
            return $pdf->download('ipcr.pdf');
        } else {
            session()->flash('message', 'Invalid data. Not Found!');
        }
    }

    public function view(Request $request)
    {
        $superior1 = '';
        $superior2 = '';
        $duration = Duration::orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->first();

        if ($duration) {
            $approval = Approval::orderBy('id', 'DESC')
                ->where('user_id', Auth::user()->id)
                ->where('type', 'ipcr')
                ->where('duration_id', $duration->id)
                ->where('user_type', $request->userType)
                ->first();

            $superior1 = User::where('id', $approval->superior1_id)->first();
            $superior2 = User::where('id', $approval->superior2_id)->first();
        }

        $functs = Funct::all();

        return view('print.ipcr', [
            'functs' => $functs,
            'core' => $request->core,
            'strategic' => $request->strategic,
            'support' => $request->support,
            'userType' => $request->userType,
            'superior1' => $superior1,
            'superior2' => $superior2,
            'approval' => $approval,
            'duration' => $duration,
        ]);
    }
}
