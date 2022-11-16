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
    public function render()
    {
        $this->duration = Duration::orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->first();
        
        if ($this->duration) {
            $this->approvalIPCRS = Approval::orderBy('id', 'DESC')
                    ->where('name', 'approval')
                    ->where('user_id', Auth::user()->id)
                    ->where('user_type', 'staff')
                    ->where('type', 'ipcr')
                    ->where('duration_id', $this->duration->id)
                    ->first();
            
            $this->approvalStandardS = Approval::orderBy('id', 'DESC')
                    ->where('name', 'approval')
                    ->where('user_id', Auth::user()->id)
                    ->where('user_type', 'staff')
                    ->where('type', 'standard')
                    ->where('duration_id', $this->duration->id)
                    ->first();

            $this->approvalIPCRF = Approval::orderBy('id', 'DESC')
                    ->where('name', 'approval')
                    ->where('user_id', Auth::user()->id)
                    ->where('user_type', 'faculty')
                    ->where('type', 'ipcr')
                    ->where('duration_id', $this->duration->id)
                    ->first();
            
            $this->approvalStandardF = Approval::orderBy('id', 'DESC')
                    ->where('name', 'approval')
                    ->where('user_id', Auth::user()->id)
                    ->where('user_type', 'faculty')
                    ->where('type', 'standard')
                    ->where('duration_id', $this->duration->id)
                    ->first();

            $this->targetsF = Target::where('user_id', Auth::user()->id)
                        ->where('user_type', 'faculty')
                        ->where('type', 'ipcr')
                        ->where('duration_id', $this->duration->id)
                        ->get();
                        
            $this->targetsS = Target::where('user_id', Auth::user()->id)
                        ->where('user_type', 'staff')
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
            $this->assignments = Ttma::where('user_id', Auth::user()->id)
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
        
        return view('livewire.dashboard-livewire');
    }
}
