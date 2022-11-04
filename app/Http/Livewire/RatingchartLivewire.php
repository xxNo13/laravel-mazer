<?php

namespace App\Http\Livewire;

use App\Models\Rating;
use App\Models\Target;
use Livewire\Component;
use App\Models\Duration;
use Illuminate\Support\Facades\Auth;

class RatingchartLivewire extends Component
{
    public $number = 0;
    public $targets = [];
    public $ratings = [];
    
    public function render()
    {
        $this->duration = Duration::orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->first();
        $this->targs = Target::orderBy('id', 'ASC')
            ->where('user_id', Auth::user()->id)
            ->where('type', 'ipcr')
            ->where('duration_id', $this->duration->id)
            ->get();
        foreach($this->targs as $targ){
            $this->targets[$this->number] = $targ->target;
            if ($targ->rating) {
                $rating = Rating::where('target_id', $targ->id)
                    ->where('type', 'ipcr')
                    ->where('duration_id', $this->duration->id)
                    ->first();
                $this->ratings[$this->number] = $rating->average;
            } else {
                $this->ratings[$this->number] = 0;
            }

            $this->number++;
        }
        
        return view('livewire.ratingchart-livewire');
    }
}
