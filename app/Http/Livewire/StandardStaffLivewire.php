<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Funct;
use App\Models\Target;
use Livewire\Component;
use App\Models\Approval;
use App\Models\Duration;
use App\Models\Standard;
use App\Models\Percentage;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ApprovalNotification;

class StandardStaffLivewire extends Component
{   
    use WithPagination;

    public $eff_5;
    public $eff_4;
    public $eff_3;
    public $eff_2;
    public $eff_1;
    public $qua_5;
    public $qua_4;
    public $qua_3;
    public $qua_2;
    public $qua_1;
    public $time_5;
    public $time_4;
    public $time_3;
    public $time_2;
    public $time_1;
    public $dummy = 'dummy';
    public $target_id;
    public $standard_id;
    public $selected;
    public $superior1_id;
    public $superior2_id;
    public $users1;
    public $users2;
    public $approval;
    public $duration;
    public $targ;
    public $percentage;

    protected $rules = [
        'superior1_id' => ['required_if:selected,approval'],
        'superior2_id' => ['required_if:selected,approval'],
        'eff_5' => ['nullable', 'required_without_all:eff_4,eff_3,eff_2,eff_1,qua_5,qua_4,qua_3,qua_2,qua_1,time_5,time_4,time_3,time_2,time_1,dummy'],
        'eff_4' => ['nullable', 'required_without_all:eff_5,eff_3,eff_2,eff_1,qua_5,qua_4,qua_3,qua_2,qua_1,time_5,time_4,time_3,time_2,time_1,dummy'],
        'eff_3' => ['nullable', 'required_without_all:eff_5,eff_4,eff_2,eff_1,qua_5,qua_4,qua_3,qua_2,qua_1,time_5,time_4,time_3,time_2,time_1,dummy'],
        'eff_2' => ['nullable', 'required_without_all:eff_5,eff_4,eff_3,eff_1,qua_5,qua_4,qua_3,qua_2,qua_1,time_5,time_4,time_3,time_2,time_1,dummy'],
        'eff_1' => ['nullable', 'required_without_all:eff_5,eff_4,eff_3,eff_2,qua_5,qua_4,qua_3,qua_2,qua_1,time_5,time_4,time_3,time_2,time_1,dummy'],
        'qua_5' => ['nullable', 'required_without_all:qua_4,qua_3,qua_2,qua_1,eff_5,eff_4,eff_3,eff_2,eff_1,time_5,time_4,time_3,time_2,time_1,dummy'],
        'qua_4' => ['nullable', 'required_without_all:qua_5,qua_3,qua_2,qua_1,eff_5,eff_4,eff_3,eff_2,eff_1,time_5,time_4,time_3,time_2,time_1,dummy'],
        'qua_3' => ['nullable', 'required_without_all:qua_5,qua_4,qua_2,qua_1,eff_5,eff_4,eff_3,eff_2,eff_1,time_5,time_4,time_3,time_2,time_1,dummy'],
        'qua_2' => ['nullable', 'required_without_all:qua_5,qua_4,qua_3,qua_1,eff_5,eff_4,eff_3,eff_2,eff_1,time_5,time_4,time_3,time_2,time_1,dummy'],
        'qua_1' => ['nullable', 'required_without_all:qua_5,qua_4,qua_3,qua_2,eff_5,eff_4,eff_3,eff_2,eff_1,time_5,time_4,time_3,time_2,time_1,dummy'],
        'time_5' => ['nullable', 'required_without_all:time_4,time_3,time_2,time_1,eff_5,eff_4,eff_3,eff_2,eff_1,qua_5,qua_4,qua_3,qua_2,qua_1,dummy'],
        'time_4' => ['nullable', 'required_without_all:time_5,time_3,time_2,time_1,eff_5,eff_4,eff_3,eff_2,eff_1,qua_5,qua_4,qua_3,qua_2,qua_1,dummy'],
        'time_3' => ['nullable', 'required_without_all:time_5,time_4,time_2,time_1,eff_5,eff_4,eff_3,eff_2,eff_1,qua_5,qua_4,qua_3,qua_2,qua_1,dummy'],
        'time_2' => ['nullable', 'required_without_all:time_5,time_4,time_3,time_1,eff_5,eff_4,eff_3,eff_2,eff_1,qua_5,qua_4,qua_3,qua_2,qua_1,dummy'],
        'time_1' => ['nullable', 'required_without_all:time_5,time_4,time_3,time_2,eff_5,eff_4,eff_3,eff_2,eff_1,qua_5,qua_4,qua_3,qua_2,qua_1,dummy'],
    ];

    public function mount(){
        $this->users1 = User::whereHas('account_types', function(\Illuminate\Database\Eloquent\Builder $query) {
            return $query->where('account_type', 'like', "%head%");
        })->where('id', '!=', Auth::user()->id)->get();
        $this->users2 = User::whereHas('account_types', function(\Illuminate\Database\Eloquent\Builder $query) {
            return $query->where('account_type', 'like', "%head%");
        })->where('id', '!=', Auth::user()->id)->get();
        $this->duration = Duration::orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->first();
        
    }

    public function render()
    {
        if ($this->duration) {
            $this->approval = Approval::orderBy('id', 'DESC')
                    ->where('name', 'approval')
                    ->where('user_id', Auth::user()->id)
                    ->where('type', 'standard')
                    ->where('duration_id', $this->duration->id)
                    ->where('user_type', 'staff')
                    ->first();
            $this->targ = Target::where('user_id', Auth::user()->id)
                    ->where('type', 'ipcr')
                    ->where('user_type', 'staff')
                    ->where('duration_id', $this->duration->id)
                    ->first();
            $this->percentage = Percentage::where('user_id', Auth::user()->id)
                ->where('type', 'ipcr')
                ->where('userType', 'staff')
                ->where('duration_id', $this->duration->id)
                ->first();
            if ($this->approval) {
                $this->appsuperior1 = User::where('id', $this->approval->superior1_id)->first();
                $this->appsuperior2 = User::where('id', $this->approval->superior2_id)->first();
            }
        }
        $functs = Funct::paginate(1);
        return view('livewire.standard-staff-livewire',[
            'functs' => $functs
        ]);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function save($category){
        $this->validate();

        if ($category == 'add'){
            Standard::create([
                'eff_5' => $this->eff_5,
                'eff_4' => $this->eff_4,
                'eff_3' => $this->eff_3,
                'eff_2' => $this->eff_2,
                'eff_1' => $this->eff_1,
                'qua_5' => $this->qua_5,
                'qua_4' => $this->qua_4,
                'qua_3' => $this->qua_3,
                'qua_2' => $this->qua_2,
                'qua_1' => $this->qua_1,
                'time_5' => $this->time_5,
                'time_4' => $this->time_4,
                'time_3' => $this->time_3,
                'time_2' => $this->time_2,
                'time_1' => $this->time_1,
                'target_id' => $this->target_id,
                'user_id' => Auth::user()->id,
                'duration_id' => $this->duration->id
            ]);
        } elseif ($category == 'edit'){
            Standard::where('id', $this->standard_id)->update([
            'eff_5' => $this->eff_5,
            'eff_4' => $this->eff_4,
            'eff_3' => $this->eff_3,
            'eff_2' => $this->eff_2,
            'eff_1' => $this->eff_1,
            'qua_5' => $this->qua_5,
            'qua_4' => $this->qua_4,
            'qua_3' => $this->qua_3,
            'qua_2' => $this->qua_2,
            'qua_1' => $this->qua_1,
            'time_5' => $this->time_5,
            'time_4' => $this->time_4,
            'time_3' => $this->time_3,
            'time_2' => $this->time_2,
            'time_1' => $this->time_1,
        ]);
        }
        
        session()->flash('message', 'Success added');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }

    public function delete(){
        Standard::find($this->standard_id)->delete();
        
        session()->flash('message', 'Success delete');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }

    public function clicked($category, $id){
        $this->dummy = '';
        // If add $id = $target_id else $id = $standard_id
        if ($category == 'add'){
            $this->target_id = $id;
        } elseif ($category == 'edit'){
            $this->standard_id = $id;
            $standard = Standard::find($id);
            $this->eff_5 = $standard->eff_5;
            $this->eff_4 = $standard->eff_4;
            $this->eff_3 = $standard->eff_3;
            $this->eff_2 = $standard->eff_2;
            $this->eff_1 = $standard->eff_1;
            $this->qua_5 = $standard->qua_5;
            $this->qua_4 = $standard->qua_4;
            $this->qua_3 = $standard->qua_3;
            $this->qua_2 = $standard->qua_2;
            $this->qua_1 = $standard->qua_1;
            $this->time_5 = $standard->time_5;
            $this->time_4 = $standard->time_4;
            $this->time_3 = $standard->time_3;
            $this->time_2 = $standard->time_2;
            $this->time_1 = $standard->time_1;
        } elseif ($category == 'delete'){
            $this->standard_id = $id;
        }
    }
    
    // SUBMITING OF IPCR START ------------>
    public function submit(){
        $this->selected = 'approval';

        if ($this->approval) {
            $this->superior1_id = $this->approval->superior1_id;
            $this->superior2_id = $this->approval->superior2_id;
        }
    }
    
    public function changeUser(){
        if($this->superior1_id != ''){
            $this->users2 = User::whereHas('account_types', function(\Illuminate\Database\Eloquent\Builder $query) {
                return $query->where('account_type', 'like', "%head%");
            })->where('id', '!=', $this->superior1_id)->where('id', '!=', Auth::user()->id)->get();
        } elseif ($this->superior2_id != ''){
            $this->users1 = User::whereHas('account_types', function(\Illuminate\Database\Eloquent\Builder $query) {
                return $query->where('account_type', 'like', "%head%");
            })->where('id', '!=', $this->superior2_id)->where('id', '!=', Auth::user()->id)->get();
        }
    }

    public function submitISO(){

        $this->validate();

        $approval = Approval::create([
            'name' => 'approval',
            'user_id' => Auth::user()->id,
            'superior1_id' => $this->superior1_id,
            'superior2_id' => $this->superior2_id,
            'type' => 'standard',
            'user_type' => 'staff',
            'duration_id' => $this->duration->id
        ]);

        $user1 = User::where('id', $this->superior1_id)->first();
        $user2 = User::where('id', $this->superior2_id)->first();

        $user1->notify(new ApprovalNotification($approval, Auth::user(), 'Submitting'));
        $user2->notify(new ApprovalNotification($approval, Auth::user(), 'Submitting'));

        session()->flash('message', 'Submitted Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }
    // <---------------- SUBMITING OF IPCR END

    public function resetInput(){
        $this->eff_5 = '';
        $this->eff_4 = '';
        $this->eff_3 = '';
        $this->eff_2 = '';
        $this->eff_1 = '';
        $this->qua_5 = '';
        $this->qua_4 = '';
        $this->qua_3 = '';
        $this->qua_2 = '';
        $this->qua_1 = '';
        $this->time_5 = '';
        $this->time_4 = '';
        $this->time_3 = '';
        $this->time_2 = '';
        $this->time_1 = '';
        $this->target_id = '';
        $this->standard_id = '';
        $this->selected = '';
        $this->superior1_id = '';
        $this->superior2_id = '';
        $this->dummy = 'dummy';
    }

    public function closeModal(){
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }
}
