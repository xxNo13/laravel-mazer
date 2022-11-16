<?php

namespace App\Http\Livewire;

use App\Models\Target;
use Livewire\Component;
use App\Models\Approval;
use App\Models\Duration;
use App\Models\Training;
use Illuminate\Support\Facades\Auth;

class TrainingRecommendationLivewire extends Component
{
    public function render()
    {
        $trainings = [];
        $duration = Duration::orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->first();
        
        if (Auth::user()->account_types->contains(1) || Auth::user()->account_types->contains(6)) {
            if ($duration) {
                $assessF = Approval::orderBy('id', 'DESC')
                    ->where('name', 'assess')
                    ->where('superior1_status', 1)
                    ->where('superior2_status', 1)
                    ->where('user_id', Auth::user()->id)
                    ->where('type', 'ipcr')
                    ->where('duration_id', $duration->id)
                    ->where('user_type', 'faculty')
                    ->first();

                if (isset($assessF)) {
                    $faculty = true;
                }
            }
        } else {
            $faculty = true;
        }

        if (Auth::user()->account_types->contains(2)) {
            if ($duration) {
                $assessS = Approval::orderBy('id', 'DESC')
                    ->where('name', 'assess')
                    ->where('superior1_status', 1)
                    ->where('superior2_status', 1)
                    ->where('user_id', Auth::user()->id)
                    ->where('type', 'ipcr')
                    ->where('duration_id', $duration->id)
                    ->where('user_type', 'staff')
                    ->first();

                if (isset($assessS)) {
                    $staff = true;
                }
            }
        } else {
            $staff = true;
        }
        
        if (isset($faculty) && isset($staff)) {
            $targets = Target::where('user_id', Auth::user()->id)
                ->where('duration_id', $duration->id)
                ->where(function ($query) {
                    $query->whereHas('rating', function (\Illuminate\Database\Eloquent\Builder $query) {
                        return $query->where('average', '<=', 3);
                    });
                })->get();
                
            $trainings = Training::query();
            
            foreach ($targets as $target) {
                $results = preg_split('/\s+/', $target->target);
                foreach ($results as $result) {
                    $trainings->orWhere('training', 'LIKE', '%' . $result . '%')
                        ->orWhere('possible_target', 'LIKE', '%' . $result . '%');
                }
            }

            $trainings = $trainings->orderBy('id', 'DESC')->distinct()->paginate(25);
        }

        return view('livewire.training-recommendation-livewire', [
            'trainings' => $trainings
        ]);
    }
}
