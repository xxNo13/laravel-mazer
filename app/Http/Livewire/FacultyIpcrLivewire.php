<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Funct;
use App\Models\Output;
use App\Models\Rating;
use App\Models\Target;
use Livewire\Component;
use App\Models\Approval;
use App\Models\Duration;
use App\Models\SubFunct;
use App\Models\Suboutput;
use App\Models\Percentage;
use Livewire\WithPagination;
use App\Models\SuppPercentage;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ApprovalNotification;

class FacultyIpcrLivewire extends Component
{
    use WithPagination;

    public $configure = false;
    public $selected;
    public $number = 1;
    public $duration;
    public $approval;
    public $targets = [];
    public $output;
    public $users1;
    public $users2;
    public $superior1_id;
    public $superior2_id;
    public $target_id;
    public $rating_id;
    public $accomplishment;
    public $efficiency;
    public $quality;
    public $timeliness;
    public $type = 'IPCR';
    public $approveFaculty;
    public $subFuncts;
    public $percentage;
    public $core;
    public $strategic;
    public $support;
    public $supp = [];
    public $dummy = 'dummy';


    protected $rules = [
        'accomplishment' => ['required_if:selected,rating'],
        'efficiency' => ['nullable', 'required_without_all:quality,timeliness,dummy', 'integer', 'min:1', 'max:5'],
        'quality' => ['nullable', 'required_without_all:efficiency,timeliness,dummy', 'integer', 'min:1', 'max:5'],
        'timeliness' => ['nullable', 'required_without_all:quality,efficiency,dummy', 'integer', 'min:1', 'max:5'],
        'superior1_id' => ['required_if:selected,approval'],
        'superior2_id' => ['required_if:selected,approval'],
        'core' => ['nullable', 'required_if:selected,percentage', 'integer'],
        'strategic' => ['nullable', 'required_if:selected,percentage', 'integer'],
        'support' => ['nullable', 'required_if:selected,percentage', 'integer'],
    ];

    public function mount() {
        $this->users1 = User::whereHas('account_types', function(\Illuminate\Database\Eloquent\Builder $query) {
            return $query->where('account_type', 'like', "%head%");
        })->where('id', '!=', Auth::user()->id)->get();
        $this->users2 = User::whereHas('account_types', function(\Illuminate\Database\Eloquent\Builder $query) {
            return $query->where('account_type', 'like', "%head%");
        })->where('id', '!=', Auth::user()->id)->get();
        $this->duration = Duration::orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->first();
        
        if ($this->duration) {
            $this->approveFaculty = Approval::orderBy('id', 'DESC')
                ->where('name', 'approval')
                ->where('user_id', null)
                ->where('type', 'ipcr')
                ->where('duration_id', $this->duration->id)
                ->where('user_type', 'faculty')
                ->where('added_id', '!=', null)
                ->first();
            $this->subFuncts = SubFunct::where('user_id', Auth::user()->id)
                ->where('type', 'ipcr')
                ->where('user_type', 'faculty')
                ->where('duration_id', $this->duration->id)
                ->get();
        }
    }
    public function render()
    {
        if ($this->duration) {
            $this->output = Output::where('user_id', Auth::user()->id)
                    ->where('type', 'ipcr')
                    ->where('user_type', 'faculty')
                    ->where('duration_id', $this->duration->id)
                    ->first();
            $this->approval = Approval::orderBy('id', 'DESC')
                    ->where('name', 'approval')
                    ->where('user_id', Auth::user()->id)
                    ->where('type', 'ipcr')
                    ->where('duration_id', $this->duration->id)
                    ->where('user_type', 'faculty')
                    ->first();
            $this->assess = Approval::orderBy('id', 'DESC')
                    ->where('name', 'assess')
                    ->where('user_id', Auth::user()->id)
                    ->where('type', 'ipcr')
                    ->where('duration_id', $this->duration->id)
                    ->where('user_type', 'faculty')
                    ->first();
            $this->percentage = Percentage::where('user_id', Auth::user()->id)
                ->where('type', 'ipcr')
                ->where('userType', 'faculty')
                ->where('duration_id', $this->duration->id)
                ->first();
            if ($this->approval) {
                $this->appsuperior1 = User::where('id', $this->approval->superior1_id)->first();
                $this->appsuperior2 = User::where('id', $this->approval->superior2_id)->first();
            }
            if ($this->assess) {
                $this->asssuperior1 = User::where('id', $this->assess->superior1_id)->first();
                $this->asssuperior2 = User::where('id', $this->assess->superior2_id)->first();
            }
        }
        
        if ($this->configure){
            return view('components.ipcr-faculty', [
                'functs' => Funct::all(),
                'user_type' => 'faculty',
            ]);
        } else {
            return view('livewire.faculty-ipcr-livewire', [
                'functs' => Funct::paginate(1),
                'userType' => 'faculty'
            ]);
        }
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function configure(){
        $this->configure = true;
    }

    public function saveIPCR(){
        $sub_funct = '';
        $sub_funct_id = 0;
        $storesub_funct_id = 0;
        $output = '';
        $output_id = 0;
        $storeOutput_id = 0;
        $suboutput = '';
        $suboutput_id = 0;
        $storeSuboutput_id = 0;
        $target = '';

        foreach($this->targets as $targ){
            $target = Target::find($targ);
            if ($target->output_id && $output_id == $target->output_id) {
                Target::create([
                    'target' => $target->target,
                    'type' => $target->type,
                    'user_type' => $target->user_type,
                    'output_id' => $storeOutput_id,
                    'user_id' => Auth::user()->id,
                    'duration_id' => $this->duration->id
                ]);
            } elseif ($target->suboutput_id && $suboutput_id == $target->suboutput_id) {
                Target::create([
                    'target' => $target->target,
                    'type' => $target->type,
                    'user_type' => $target->user_type,
                    'suboutput_id' => $storeSuboutput_id,
                    'user_id' => Auth::user()->id,
                    'duration_id' => $this->duration->id
                ]);
            } else {
                if($target->output_id) {
                    $output = Output::find($target->output_id);
                    $output_id = $output->id;

                    if($output->sub_funct_id && $sub_funct_id == $output->sub_funct_id) {
                        $storeOutput = Output::create([
                            'code' => $output->code,
                            'output' => $output->output,
                            'type' => $output->type,
                            'user_type' => $output->user_type,
                            'sub_funct_id' => $storesub_funct_id,
                            'user_id' => Auth::user()->id,
                            'duration_id' => $this->duration->id
                        ]);
                        $storeOutput_id = $storeOutput->id;
    
                        Target::create([
                            'target' => $target->target,
                            'type' => $target->type,
                            'user_type' => $target->user_type,
                            'output_id' => $storeOutput->id,
                            'user_id' => Auth::user()->id,
                            'duration_id' => $this->duration->id
                        ]);
                    } else {
                        if ($output->sub_funct_id) {
                            $sub_funct = SubFunct::find($output->sub_funct_id);
                            $sub_funct_id = $sub_funct->id;

                            $storesub_funct = SubFunct::create([
                                'sub_funct' => $sub_funct->sub_funct,
                                'funct_id' => $sub_funct->funct_id,
                                'user_id' => Auth::user()->id,
                                'type' => $sub_funct->type,
                                'user_type' => $sub_funct->user_type,
                                'duration_id' => $this->duration->id
                            ]);
                            $storesub_funct_id = $storesub_funct->id;

                            $storeOutput = Output::create([
                                'code' => $output->code,
                                'output' => $output->output,
                                'type' => $output->type,
                                'user_type' => $output->user_type,
                                'sub_funct_id' => $storesub_funct_id,
                                'user_id' => Auth::user()->id,
                                'duration_id' => $this->duration->id
                            ]);
                            $storeOutput_id = $storeOutput->id;
        
                            Target::create([
                                'target' => $target->target,
                                'type' => $target->type,
                                'user_type' => $target->user_type,
                                'output_id' => $storeOutput->id,
                                'user_id' => Auth::user()->id,
                                'duration_id' => $this->duration->id
                            ]);
                        } else {
                            $storeOutput = Output::create([
                                'code' => $output->code,
                                'output' => $output->output,
                                'type' => $output->type,
                                'user_type' => $output->user_type,
                                'funct_id' => $output->funct_id,
                                'user_id' => Auth::user()->id,
                                'duration_id' => $this->duration->id
                            ]);
                            $storeOutput_id = $storeOutput->id;
        
                            Target::create([
                                'target' => $target->target,
                                'type' => $target->type,
                                'user_type' => $target->user_type,
                                'output_id' => $storeOutput->id,
                                'user_id' => Auth::user()->id,
                                'duration_id' => $this->duration->id
                            ]);
                        }
                    }
                    
                }elseif ($target->suboutput_id) {
                    $suboutput = Suboutput::find($target->suboutput_id);
                    $suboutput_id = $suboutput->id;
                    $output = Output::find($suboutput->output_id);

                    if($output->sub_funct_id && $sub_funct_id == $output->sub_funct_id) {
                        $storeOutput = Output::create([
                            'code' => $output->code,
                            'output' => $output->output,
                            'type' => $output->type,
                            'user_type' => $output->user_type,
                            'sub_funct_id' => $storesub_funct_id,
                            'user_id' => Auth::user()->id,
                            'duration_id' => $this->duration->id
                        ]);
                        $storeOutput_id = $storeOutput->id;
    
                        $storeSuboutput = Suboutput::create([
                            'suboutput' => $suboutput->suboutput,
                            'type' => $suboutput->type,
                            'user_type' => $suboutput->user_type,
                            'output_id' => $storeOutput->id,
                            'user_id' => Auth::user()->id,
                            'duration_id' => $this->duration->id
                        ]);
                        $storeSuboutput_id = $storeSuboutput->id;
    
                        Target::create([
                            'target' => $target->target,
                            'type' => $target->type,
                            'user_type' => $target->user_type,
                            'suboutput_id' => $storeSuboutput->id,
                            'user_id' => Auth::user()->id,
                            'duration_id' => $this->duration->id
                        ]);
                    } else {
                        if ($output->sub_funct_id) {
                            $sub_funct = SubFunct::find($output->sub_funct_id);
                            $sub_funct_id = $sub_funct->id;

                            $storesub_funct = SubFunct::create([
                                'sub_funct' => $sub_funct->sub_funct,
                                'funct_id' => $sub_funct->funct_id,
                                'user_id' => Auth::user()->id,
                                'type' => $sub_funct->type,
                                'user_type' => $sub_funct->user_type,
                                'duration_id' => $this->duration->id
                            ]);
                            $storesub_funct_id = $storesub_funct->id;

                            $storeOutput = Output::create([
                                'code' => $output->code,
                                'output' => $output->output,
                                'type' => $output->type,
                                'user_type' => $output->user_type,
                                'sub_funct_id' => $storesub_funct_id,
                                'user_id' => Auth::user()->id,
                                'duration_id' => $this->duration->id
                            ]);
                            $storeOutput_id = $storeOutput->id;
        
                            $storeSuboutput = Suboutput::create([
                                'suboutput' => $suboutput->suboutput,
                                'type' => $suboutput->type,
                                'user_type' => $suboutput->user_type,
                                'output_id' => $storeOutput->id,
                                'user_id' => Auth::user()->id,
                                'duration_id' => $this->duration->id
                            ]);
                            $storeSuboutput_id = $storeSuboutput->id;
        
                            Target::create([
                                'target' => $target->target,
                                'type' => $target->type,
                                'user_type' => $target->user_type,
                                'suboutput_id' => $storeSuboutput->id,
                                'user_id' => Auth::user()->id,
                                'duration_id' => $this->duration->id
                            ]);
                        } else {
                            $storeOutput = Output::create([
                                'code' => $output->code,
                                'output' => $output->output,
                                'type' => $output->type,
                                'user_type' => $output->user_type,
                                'funct_id' => $output->funct_id,
                                'user_id' => Auth::user()->id,
                                'duration_id' => $this->duration->id
                            ]);
                            $storeOutput_id = $storeOutput->id;
        
                            $storeSuboutput = Suboutput::create([
                                'suboutput' => $suboutput->suboutput,
                                'type' => $suboutput->type,
                                'user_type' => $suboutput->user_type,
                                'output_id' => $storeOutput->id,
                                'user_id' => Auth::user()->id,
                                'duration_id' => $this->duration->id
                            ]);
                            $storeSuboutput_id = $storeSuboutput->id;
        
                            Target::create([
                                'target' => $target->target,
                                'type' => $target->type,
                                'user_type' => $target->user_type,
                                'suboutput_id' => $storeSuboutput->id,
                                'user_id' => Auth::user()->id,
                                'duration_id' => $this->duration->id
                            ]);
                        }
                    }
                }
            }
        }

        session()->flash('message', 'Added Successfully!');
        $this->configure = false;
    }

    public function resetIPCR(){
        foreach(Auth::user()->targets as $target) {
            Target::where('id', $target->id)
                ->where('type', 'ipcr')
                ->where('user_type', 'faculty')
                ->delete();
        }
        foreach(Auth::user()->outputs as $output) {
            Output::where('id', $output->id)
                ->where('type', 'ipcr')
                ->where('user_type', 'faculty')
                ->delete();
        }
        foreach(Auth::user()->suboutputs as $suboutput) {
            Suboutput::where('id', $suboutput->id)
                ->where('type', 'ipcr')
                ->where('user_type', 'faculty')
                ->delete();
        }
        foreach(Auth::user()->subFuncts as $sub_funct) {
            SubFunct::where('id', $sub_funct->id)
                ->where('type', 'ipcr')
                ->where('user_type', 'faculty')
                ->delete();
        }
        
        session()->flash('message', 'Reset Successfully!');
        $this->closeModal();
    }
    

    // CONFIGURING RATING START ----------->
    public function rating($target_id = null, $rating_id = null){
        $this->selected = 'rating';
        $this->rating_id = $rating_id;
        $this->target_id = $target_id;
        
        $this->dummy = '';
    }

    public function editRating($rating_id){
        $this->selected = 'rating';
        $this->rating_id = $rating_id;

        $rating = Rating::find($rating_id);

        $this->accomplishment = $rating->accomplishment;
        $this->efficiency = $rating->efficiency;
        $this->quality = $rating->quality;
        $this->timeliness = $rating->timeliness;
    }

    public function saveRating($category){

        $this->validate();

        if ($category == 'add') {
            $divisor= 0;
            if(!$this->efficiency){
                $divisor++;
            }
            if(!$this->quality){
                $divisor++;
            }
            if(!$this->timeliness){
                $divisor++;
            }
            $number = ((int)$this->efficiency + (int)$this->quality + (int)$this->timeliness) / (3 - $divisor);
            $average = number_format((float)$number, 2, '.', '');

            Rating::create([
                'accomplishment' => $this->accomplishment,
                'efficiency' => $this->efficiency,
                'quality' => $this->quality,
                'timeliness' => $this->timeliness,
                'average' => $average,
                'remarks' => 'Done',
                'type' => 'ipcr',
                'target_id' => $this->target_id,
                'duration_id' => $this->duration->id,
                'user_id' => Auth::user()->id
            ]);

            session()->flash('message', 'Added Successfully!');
        } elseif ($category == 'edit') {
            $divisor= 0;
            if(!$this->efficiency){
                $divisor++;
            }
            if(!$this->quality){
                $divisor++;
            }
            if(!$this->timeliness){
                $divisor++;
            }
            $number = ((int)$this->efficiency + (int)$this->quality + (int)$this->timeliness) / (3 - $divisor);
            $average = number_format((float)$number, 2, '.', '');

            Rating::where('id', $this->rating_id)->update([
                'accomplishment' => $this->accomplishment,
                'efficiency' => $this->efficiency,
                'quality' => $this->quality,
                'timeliness' => $this->timeliness,
                'average' => $average,
            ]);

            session()->flash('message', 'Updated Successfully!');
        }
        
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }
    // <------------- CONFIGURING RATING END

    // Delete OST-R
    public function delete(){
        Rating::find($this->rating_id)->delete();

        session()->flash('message', 'Deleted Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }

    // SUBMITING OF IPCR START ------------>
    public function submit() {
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
            'type' => 'ipcr',
            'user_type' => 'faculty',
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

    public function assessISO(){

        $this->validate();

        $approval = Approval::create([
            'name' => 'assess',
            'user_id' => Auth::user()->id,
            'superior1_id' => $this->superior1_id,
            'superior2_id' => $this->superior2_id,
            'type' => 'ipcr',
            'user_type' => 'faculty',
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

    // Configuring Percentage ------------------->
    public function savePercent(){

        $this->validate();

        if (($this->core + $this->strategic + $this->support) != 100) {
            session()->flash('message', 'Percentage is not equal to 100!');
            $this->resetInput();
            $this->dispatchBrowserEvent('close-modal');
            return;
        }

        $percentage = Percentage::create([
            'core' => $this->core,
            'strategic' => $this->strategic,
            'support' => $this->support,
            'type' => 'ipcr',
            'userType' => 'faculty',
            'user_id' => Auth::user()->id,
            'duration_id' => $this->duration->id
        ]);

        foreach ($this->subFuncts as $subFunct) {
            SuppPercentage::create([
                'name' => $subFunct->sub_funct,
                'percent' => $this->supp[$subFunct->id],
                'percentage_id' => $percentage->id,
                'user_id' => Auth::user()->id,
                'duration_id' => $this->duration->id
            ]);
        }

        session()->flash('message', 'Added Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }

    public function updatePercent(){
        $this->validate();

        if (($this->core + $this->strategic + $this->support) != 100) {
            session()->flash('message', 'Percentage is not equal to 100!');
            $this->resetInput();
            $this->dispatchBrowserEvent('close-modal');
            return;
        }

        Percentage::where('id', $this->percentage->id)->update([
            'core' => $this->core,
            'strategic' => $this->strategic,
            'support' => $this->support,
        ]);

        $suppPercentage = SuppPercentage::where('percentage_id', $this->percentage->id)
            ->where('user_id', Auth::user()->id)
            ->where('duration_id', $this->duration->id)
            ->get();
            
        foreach($this->subFuncts as $subFunct) {
            foreach($suppPercentage as $supp) {
                if($subFunct->sub_funct == $supp->name) {
                    SuppPercentage::where('id', $supp->id)->update([
                        'percent' => $this->supp[$subFunct->id],
                    ]);
                    break;
                }
            }
        }

        session()->flash('message', 'Updated Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }

    public function deletePercentage() {
        Percentage::where('id', $this->percentage->id)->delete();

        SuppPercentage::where('percentage_id', $this->percentage->id)->delete();

        session()->flash('message', 'Updated Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }

    public function percent($category = null)
    {
        $this->selected = 'percentage';

        if ($category) {
            $this->core = $this->percentage->core;
            $this->strategic = $this->percentage->strategic;
            $this->support = $this->percentage->support;
    
            $suppPercentage = SuppPercentage::where('percentage_id', $this->percentage->id)
                ->where('user_id', Auth::user()->id)
                ->where('duration_id', $this->duration->id)
                ->get();
    
            foreach ($this->subFuncts as $subFunct) {
                foreach ($suppPercentage as $supp) {
                    if ($subFunct->sub_funct == $supp->name) {
                        $this->supp[$subFunct->id] = $supp->percent;
                        break;
                    }
                }
            }
        }
    }
    // <------------------- Percetage Configure End
    public function resetInput(){
        $this->superior1_id = '';
        $this->superior2_id = '';
        $this->target_id = '';
        $this->rating_id = '';
        $this->accomplishment = '';
        $this->efficiency = '';
        $this->quality = '';
        $this->timeliness = '';
        $this->selected = '';
        $this->core = '';
        $this->strategic = '';
        $this->support = '';
        $this->supp = [];
        $this->dummy = 'dummy';
    }

    public function closeModal(){
        $this->dispatchBrowserEvent('close-modal'); 
    }
}
