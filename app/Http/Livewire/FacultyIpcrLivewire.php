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
use App\Models\Suboutput;
use Illuminate\Support\Facades\Auth;

class FacultyIpcrLivewire extends Component
{
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


    protected $rules = [
        'accomplishment' => ['required_if:selected,rating'],
        'superior1_id' => ['required_if:selected,approval'],
        'superior2_id' => ['required_if:selected,approval'],
    ];

    public function mount(){
        $this->users1 = User::whereHas('account_types', function(\Illuminate\Database\Eloquent\Builder $query) {
            return $query->where('account_type', 'like', "%head%");
        })->where('id', '!=', Auth::user()->id)->get();
        $this->users2 = User::whereHas('account_types', function(\Illuminate\Database\Eloquent\Builder $query) {
            return $query->where('account_type', 'like', "%head%");
        })->where('id', '!=', Auth::user()->id)->get();
        $this->duration = Duration::orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->first();
        if ($this->duration) {
            $this->output = Output::where('user_id', Auth::user()->id)
                    ->where('type', 'ipcr')
                    ->where('user_type', 'faculty')
                    ->where('duration_id', $this->duration->id)
                    ->first();
            $this->approval = Approval::orderBy('id', 'DESC')
                    ->where('user_id', Auth::user()->id)
                    ->where('type', 'ipcr')
                    ->where('duration_id', $this->duration->id)
                    ->where('user_type', 'faculty')
                    ->first();
        }
    }

    public function render()
    {
        if ($this->configure){
            return view('components.ipcr-faculty', [
                'functs' => Funct::all(),
                'user_type' => 'faculty',
            ]);
        } else {
            $functs = Funct::paginate(1);
            return view('livewire.faculty-ipcr-livewire', [
                'functs' => $functs
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
        $output = '';
        $output_id = 0;
        $storeOutput_id = 0;
        $suboutput = '';
        $suboutput_id = 0;
        $storeSuboutput_id = 0;
        $target = '';

        asort($this->targets);
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
                }elseif ($target->suboutput_id) {
                    $suboutput = Suboutput::find($target->suboutput_id);
                    $suboutput_id = $suboutput->id;
                    $output = Output::find($suboutput->output_id);

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

        session()->flash('message', 'Added Successfully!');
        $this->configure = false;
        return redirect(request()->header('Referer'));
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
        
        session()->flash('message', 'Reset Successfully!');
        $this->closeModal();
        return redirect(request()->header('Referer'));
    }
    

    // CONFIGURING RATING START ----------->
    public function rating($target_id = null, $rating_id = null){
        $this->seleced = 'rating';
        $this->rating_id = $rating_id;
        $this->target_id = $target_id;
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
            $number = ($this->efficiency + $this->quality + $this->timeliness) / (3 - $divisor);
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
            $number = ($this->efficiency + $this->quality + $this->timeliness) / (3 - $divisor);
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

        Approval::create([
            'user_id' => Auth::user()->id,
            'superior1_id' => $this->superior1_id,
            'superior2_id' => $this->superior2_id,
            'type' => 'ipcr',
            'user_type' => 'faculty',
            'duration_id' => $this->duration->id
        ]);

        session()->flash('message', 'Submitted Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
        return redirect(request()->header('Referer'));
    }
    // <---------------- SUBMITING OF IPCR END

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
    }

    public function closeModal(){
        $this->dispatchBrowserEvent('close-modal'); 
    }
}
