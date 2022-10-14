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
    public function mount()
    {
        $this->duration = Duration::orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->first();
        $this->targs = Target::orderBy('id', 'ASC')
            ->where('user_id', Auth::user()->id)
            ->where('type', 'ipcr')
            ->where('duration_id', $this->duration->id)
            ->get();
        foreach($this->targs as $target){
            $this->targets[$this->number] = $target->target;
            if ($target->rating) {
                $this->ratings[$this->number] = Rating::where('target_id', $target->id)
                ->where('type', 'ipcr')
                ->where('duration_id', $this->duration->id)
                ->pluck('average');
            } elseif(!$target->rating) {
                $this->ratings[$this->number] = 0;
            }

            $this->number++;
        }
    }
    public function render()
    {
        return view('livewire.ratingchart-livewire');
    }
}
