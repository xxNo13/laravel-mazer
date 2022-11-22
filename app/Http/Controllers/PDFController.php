<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use App\Models\Funct;
use App\Models\Target;
use App\Models\ScoreEq;
use App\Models\Approval;
use App\Models\Duration;
use App\Models\Percentage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    public function print($print, Request $request)
    {
        $superior1 = '';
        $superior2 = '';
        $assess = '';
        $assess1 = '';
        $assess2 = '';
        $duration = Duration::orderBy('id', 'DESC')
            ->where('start_date', '<=', date('Y-m-d'))
            ->first();
        if ($print != 'opcr') {
            $percentage = Percentage::where('user_id', Auth::user()->id)
                ->where('type', 'ipcr')
                ->where('duration_id', $duration->id)
                ->where('userType', $request->userType)
                ->first();
        } else {
            $percentage = Percentage::where('user_id', Auth::user()->id)
                ->where('type', 'opcr')
                ->where('duration_id', $duration->id)
                ->where('userType', $request->userType)
                ->first();
        }


        if ($duration) {
            $approval = Approval::orderBy('id', 'DESC')
                ->where('name', 'approval')
                ->where('user_id', Auth::user()->id)
                ->where('type', $print)
                ->where('duration_id', $duration->id)
                ->where('user_type', $request->userType)
                ->first();

            $superior1 = User::where('id', $approval->superior1_id)->first();
            $superior2 = User::where('id', $approval->superior2_id)->first();

            if ($print != 'standard') {
                $assess = Approval::orderBy('id', 'DESC')
                    ->where('name', 'assess')
                    ->where('user_id', Auth::user()->id)
                    ->where('type', $print)
                    ->where('duration_id', $duration->id)
                    ->where('user_type', $request->userType)
                    ->first();

                $assess1 = User::where('id', $assess->superior1_id)->first();
                $assess2 = User::where('id', $assess->superior2_id)->first();
            }

        }

        $functs = Funct::all();
        $scoreEq = ScoreEq::first();

        $data = [
            'functs' => $functs,
            'userType' => $request->userType,
            'superior1' => $superior1,
            'superior2' => $superior2,
            'approval' => $approval,
            'duration' => $duration,
            'percentage' => $percentage,
            'assess' => $assess,
            'assess1' => $assess1,
            'assess2' => $assess2,
            'scoreEq' => $scoreEq,
        ];

        if ($print == 'ipcr') {
            $pdf = PDF::loadView('print.ipcr', $data)->setPaper('a4','landscape');
            return $pdf->stream('ipcr.pdf');
        } elseif ($print == 'opcr') {
            $pdf = PDF::loadView('print.opcr', $data)->setPaper('a4','landscape');
            return $pdf->stream('opcr.pdf');
        } elseif ($print == 'standard') {
            if ($request->userType == 'office') {
                $data['type'] = 'opcr';
            } else {
                $data['type'] = 'ipcr';
            }
            $pdf = PDF::loadView('print.standard', $data)->setPaper('a4','landscape');
            return $pdf->stream('standard.pdf');
        } else {
            session()->flash('message', 'Invalid data. Not Found!');
        }
    }

    public function rankings(Request $request) {
        $superior1 = '';
        $superior2 = '';
        $assess = '';
        $assess1 = '';
        $assess2 = '';
        $duration = Duration::orderBy('id', 'DESC')
            ->where('start_date', '<=', date('Y-m-d'))
            ->first();
        $percentage = Percentage::where('user_id', Auth::user()->id)
            ->where('type', 'ipcr')
            ->where('duration_id', $duration->id)
            ->where('userType', $request->userType)
            ->first();
        $users = User::orderBy('name', 'ASC')->where('office_id', Auth::user()->office_id)->get();

        if ($duration) {
            $approval = Approval::orderBy('id', 'DESC')
                ->where('name', 'approval')
                ->where('user_id', Auth::user()->id)
                ->where('type', 'ipcr')
                ->where('duration_id', $duration->id)
                ->where('user_type', $request->userType)
                ->first();

            $superior1 = User::where('id', $approval->superior1_id)->first();
            $superior2 = User::where('id', $approval->superior2_id)->first();

                $assess = Approval::orderBy('id', 'DESC')
                    ->where('name', 'assess')
                    ->where('user_id', Auth::user()->id)
                    ->where('type', 'ipcr')
                    ->where('duration_id', $duration->id)
                    ->where('user_type', $request->userType)
                    ->first();

                $assess1 = User::where('id', $assess->superior1_id)->first();
                $assess2 = User::where('id', $assess->superior2_id)->first();
            
        }

        $functs = Funct::all();
        $scoreEq = ScoreEq::first();

        $data = [
            'functs' => $functs,
            'userType' => $request->userType,
            'approval' => $approval,
            'duration' => $duration,
            'percentage' => $percentage,
            'assess' => $assess,
            'assess1' => $assess1,
            'assess2' => $assess2,
            'superior1' => $superior1,
            'superior2' => $superior2,
            'scoreEq' => $scoreEq,
            'users' => $users
        ];

        
        $pdf = PDF::loadView('print.rankings', $data)->setPaper('a4');
        return $pdf->stream('rankings.pdf');
    }

    public function calculation() {
        $duration = Duration::orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->first();
        $percentage = Percentage::where('user_id', Auth::user()->id)
                ->where('type', 'ipcr')
                ->where('duration_id', $duration->id)
                ->where('userType', 'staff')
                ->first();
        $targets = Target::where('user_id', Auth::user()->id)
                ->where('type', 'ipcr')
                ->where('duration_id', $duration->id)
                ->where('user_type', 'staff')
                ->get();
        

        $totalCore = 0;
        $numberCore = 0;
        $totalStrategic = 0;
        $numberStrategic = 0;
        $numberSupp = 0;

        foreach ($percentage->supports as $support) {
            $totalSub[$support->id] = 0;
            $number[$support->id] = 0;
            $percent[$support->id] = $support->percent;
        }

        foreach ($targets as $target) {
            if ((isset($target->output->funct) && $target->output->funct->funct == 'Core Function') || (isset($target->suboutput->output->funct) && $target->suboutput->output->funct->funct == 'Core Function')) {
                $numberCore++;
                $totalCore += $target->rating->average;
            } elseif ((isset($target->output->funct) && $target->output->funct->funct == 'Strategic Function') || (isset($target->suboutput->output->funct) && $target->suboutput->output->funct->funct == 'Strategic Function')) {
                $numberStrategic++;
                $totalStrategic += $target->rating->average;
            } elseif (isset($target->output->subFunct) || isset($target->suboutput->output->subFunct)) {
                $numberSupp++;
                foreach ($percentage->supports as $support) {
                    if ((isset($target->output->subFunct) && $target->output->subFunct->sub_funct == $support->name) || (isset($target->suboutput->output->subFunct) && $target->suboutput->output->subFunct->sub_funct == $support->name)) {
                        $totalSub[$support->id] += $target->rating->average;
                        $number[$support->id]++;
                        $percent[$support->id] = $support->percent;
                    }
                }
            }
        }

        $total3 = 0;

        $total1 = ($totalCore/$numberCore) * ($percentage->core/100);
        $total2 = ($totalStrategic/$numberStrategic) * ($percentage->strategic/100);
        foreach ($percentage->supports as $support) {
            $total3 += (($totalSub[$support->id]/$number[$support->id])*($percent[$support->id]/100)*($percentage->support/100));
        }

        $total = $total1 + $total2 + $total3;

        dd($total);
    }
}
