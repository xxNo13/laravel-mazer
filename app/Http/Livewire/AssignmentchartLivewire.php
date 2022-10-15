<?php

namespace App\Http\Livewire;

use App\Models\Ttma;
use Livewire\Component;
use App\Models\Duration;
use Illuminate\Support\Facades\Auth;

class AssignmentchartLivewire extends Component
{
    public $month;
    public $dateToday;
    public function mount(){
        $this->duration = Duration::orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->first();
        $this->dateToday = date('d');
        $this->month = date('Y-m-d');
        $this->days = collect(range($this->dateToday - 6, $this->dateToday))->map(function ($number) {
            if ($number < 1) {
                $maxDate = date("t", strtotime(date('M', strtotime($this->month. '- 1 months'))));

                return date('M', strtotime($this->month. '- 1 months')) . " " . $maxDate + $number;
            } else{
                return date('M', strtotime($this->month)) . " " . $number;
            }
        });
        $ttmas = Ttma::orderBy('updated_at', 'DESC')
                    ->where('user_id', Auth::user()->id)
                    ->where('duration_id', $this->duration->id)
                    ->get();
        $this->assignments = [0,0,0,0,0,0,0];
        foreach($ttmas as $ttma) {
            if(date('M-d-Y', strtotime($ttma->updated_at)) == date('M-d-Y')){
                ++$this->assignments[6];
            }elseif(date('M-d-Y', strtotime($ttma->updated_at)) == date('M-d-Y', strtotime(date('M-d-Y'). '- 1 days'))) {
                ++$this->assignments[5];
            }elseif(date('M-d-Y', strtotime($ttma->updated_at)) == date('M-d-Y', strtotime(date('M-d-Y'). '- 2 days'))) {
                ++$this->assignments[4];
            }elseif(date('M-d-Y', strtotime($ttma->updated_at)) == date('M-d-Y', strtotime(date('M-d-Y'). '- 3 days'))) {
                ++$this->assignments[3];
            }elseif(date('M-d-Y', strtotime($ttma->updated_at)) == date('M-d-Y', strtotime(date('M-d-Y'). '- 4 days'))) {
                ++$this->assignments[2];
            }elseif(date('M-d-Y', strtotime($ttma->updated_at)) == date('M-d-Y', strtotime(date('M-d-Y'). '- 5 days'))) {
                ++$this->assignments[1];
            }elseif(date('M-d-Y', strtotime($ttma->updated_at)) == date('M-d-Y', strtotime(date('M-d-Y'). '- 6 days'))) {
                ++$this->assignments[0];
            }
        }
    }
    
    public function render()
    {
        return view('livewire.assignmentchart-livewire');
    }
}
