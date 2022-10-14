<?php

namespace App\Http\Livewire;

use App\Models\Ttma;
use App\Models\Rating;
use App\Models\Target;
use Livewire\Component;
use App\Models\Approval;
use App\Models\Duration;
use App\Models\Standard;
use Illuminate\Support\Facades\Auth;

class DashboardLivewire extends Component
{

    public function mount(){
        $this->duration = Duration::orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->first();
        if ($this->duration) {
            $this->approvalIPCR = Approval::orderBy('id', 'DESC')
                    ->where('user_id', Auth::user()->id)
                    ->where('type', 'ipcr')
                    ->where('duration_id', $this->duration->id)
                    ->first();
            
            $this->approvalStandard = Approval::orderBy('id', 'DESC')
                    ->where('user_id', Auth::user()->id)
                    ->where('type', 'standard')
                    ->where('duration_id', $this->duration->id)
                    ->first();
            $this->targets = Target::where('user_id', Auth::user()->id)
                            ->where('type', 'ipcr')
                            ->where('duration_id', $this->duration->id)
                            ->get();
            $this->ratings = Rating::where('user_id', Auth::user()->id)
                            ->where('type', 'ipcr')
                            ->where('duration_id', $this->duration->id)
                            ->get();
            $this->standards = Standard::where('user_id', Auth::user()->id)
                            ->where('duration_id', $this->duration->id)
                            ->get();
            $this->assignemnts = Ttma::where('user_id', Auth::user()->id)
                            ->where('duration_id', $this->duration->id)
                            ->get();
            $this->finished = Ttma::where('user_id', Auth::user()->id)
                            ->where('duration_id', $this->duration->id)
                            ->where('remarks', 'Done')
                            ->get();
            $this->recentTargets = Target::orderBy('id', 'desc')
                            ->where('user_id', Auth::user()->id)
                            ->where('type', 'ipcr')
                            ->where('duration_id', $this->duration->id)
                            ->take(7)
                            ->get();
            $this->recentAssignments = Ttma::orderBy('id', 'desc')
                            ->where('user_id', Auth::user()->id)
                            ->where('duration_id', $this->duration->id)
                            ->take(7)
                            ->get();
        }
    }
    public function render()
    {
        return view('livewire.dashboard-livewire');
    }
}
