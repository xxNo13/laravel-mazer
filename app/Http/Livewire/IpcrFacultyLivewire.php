<?php

namespace App\Http\Livewire;

use PDF;
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
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class IpcrFacultyLivewire extends Component
{
    use WithPagination;

    public $selected = 'output';
    public $output;
    public $suboutput;
    public $subput;
    public $target;
    public $code;
    public $funct_id;
    public $number = 1;
    public $output_id;
    public $suboutput_id;
    public $target_id;
    public $rating_id;
    public $superior1_id;
    public $superior2_id;
    public $users1;
    public $users2;
    public $approval;
    public $type = 'IPCR';
    public $duration;
    public $outputs;
    public $suboutputs;
    public $targets;
    public $sub_funct;
    public $sub_funct_id;
    public $subFuncts;
    public $targ;

    // protected $paginationTheme = 'bootstrap';
    protected $rules = [
        'output' => ['required_if:selected,output'],
        'suboutput' => ['required_if:selected,suboutput'],
        'target' => ['required_if:selected,target'],
        'superior1_id' => ['required_if:selected,submit'],
        'superior2_id' => ['required_if:selected,submit'],
    ];

    public function render()
    {
        $this->users1 = User::whereHas('account_types', function (\Illuminate\Database\Eloquent\Builder $query) {
            return $query->where('account_type', 'like', "%head%");
        })->where('id', '!=', Auth::user()->id)->get();
        $this->users2 = User::whereHas('account_types', function (\Illuminate\Database\Eloquent\Builder $query) {
            return $query->where('account_type', 'like', "%head%");
        })->where('id', '!=', Auth::user()->id)->get();
        $this->duration = Duration::orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->first();
        if ($this->duration) {
            $this->approval = Approval::orderBy('id', 'DESC')
                ->where('name', 'approval')
                ->where('added_id', Auth::user()->id)
                ->where('type', 'ipcr')
                ->where('duration_id', $this->duration->id)
                ->where('user_type', 'faculty')
                ->first();
            $this->targ = Target::where('user_id', null)
                ->where('type', 'ipcr')
                ->where('user_type', 'faculty')
                ->where('duration_id', $this->duration->id)
                ->first();
        }
        
        $functs = Funct::paginate(1);
        if ($this->duration){
            $this->outputs = Output::where('user_id', null)
                ->where('duration_id', $this->duration->id)
                ->get();
            $this->suboutputs = Suboutput::where('user_id', null)
                ->where('duration_id', $this->duration->id)
                ->get();
            $this->targets = Target::where('user_id', null)
                ->where('duration_id', $this->duration->id)
                ->get();
            $this->subFuncts = SubFunct::where('user_id', null)
                ->where('duration_id', $this->duration->id)
                ->get();
        }

        return view('livewire.ipcr-faculty-livewire', [
            'functs' => $functs,
            'userType' => 'faculty',
            'outputs' => $this->outputs,
            'suboutputs' => $this->suboutputs,
            'targets' => $this->targets,
            'subFuncts' => $this->subFuncts,
        ]);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    // CONFIGURING OST START ------------>
    public function select($selected, $id = null){
        $this->selected = $selected;

        if($id) {
            switch($selected){
                case 'sub_funct':
                    $this->sub_funct_id = $id;
                    $sub_funct = SubFunct::where('id', $this->sub_funct_id)->first();
                    $this->sub_funct = $sub_funct->sub_funct;
                    break;
                case 'output':
                    $this->output_id = $id;
                    $output = Output::where('id', $this->output_id)->first();
                    $this->output = $output->output;
                    break;
                case 'suboutput':
                    $this->suboutput_id = $id;
                    $suboutput = Suboutput::where('id', $this->suboutput_id)->first();
                    $this->suboutput = $suboutput->suboutput;
                    break;
                case 'target':
                    $this->target_id = $id;
                    $target = Target::where('id', $this->target_id)->first();
                    $this->target = $target->target;
                    break;

                default:
                    dd($selected);
                    break;
            }
        }
    }
    // Save / Update OST
    public function save()
    {
        $this->validate();
        $selected = $this->selected;

        switch($selected){
            case 'sub_funct':
                switch (str_replace(url('/'), '', url()->previous())) {
                    case '/ipcr/add/faculty':
                        $this->funct_id = 1;
                        break;
                    case '/ipcr/add/faculty?page=2':
                        $this->funct_id = 2;
                        break;
                    case '/ipcr/add/faculty?page=3':
                        $this->funct_id = 3;
                        break;
                    default:
                        $this->funct_id = 0;
                        break;
                };
                SubFunct::create([
                    'sub_funct' => $this->sub_funct,
                    'funct_id' => $this->funct_id,
                    'type' => 'ipcr',
                    'user_type' => 'faculty',
                    'duration_id' => $this->duration->id
                ]);
                break;
            case 'output':
                switch (str_replace(url('/'), '', url()->previous())) {
                    case '/ipcr/add/faculty':
                        $this->code = 'CF ';
                        $this->funct_id = 1;
                        break;
                    case '/ipcr/add/faculty?page=2':
                        $this->code = 'STF ';
                        $this->funct_id = 2;
                        break;
                    case '/ipcr/add/faculty?page=3':
                        $this->code = 'SF ';
                        $this->funct_id = 3;
                        break;
                    default:
                        $this->code = 'Code ';
                        $this->funct_id = 0;
                        break;
                };
                if($this->sub_funct_id){
                    Output::create([
                        'code' => $this->code,
                        'output' => $this->output,
                        'sub_funct_id' => $this->sub_funct_id,
                        'type' => 'ipcr',
                        'user_type' => 'faculty',
                        'duration_id' => $this->duration->id
                    ]);
                    break;
                }
                Output::create([
                    'code' => $this->code,
                    'output' => $this->output,
                    'funct_id' => $this->funct_id,
                    'type' => 'ipcr',
                    'user_type' => 'faculty',
                    'duration_id' => $this->duration->id
                ]);
                break;
            case 'suboutput':
                Suboutput::create([
                    'suboutput' => $this->suboutput,
                    'output_id' => $this->output_id,
                    'type' => 'ipcr',
                    'user_type' => 'faculty',
                    'duration_id' => $this->duration->id
                ]);
                break;
            case 'target':
                $subputArr = explode(',', $this->subput);
    
                if ($subputArr[0] == 'output'){
                    Target::create([
                        'target' => $this->target,
                        'output_id' =>  $subputArr[1],
                        'type' => 'ipcr',
                        'user_type' => 'faculty',
                        'duration_id' => $this->duration->id
                    ]);
                } elseif ($subputArr[0] == 'suboutput'){
                    Target::create([
                        'target' => $this->target,
                        'suboutput_id' =>  $subputArr[1],
                        'type' => 'ipcr',
                        'user_type' => 'faculty',
                        'duration_id' => $this->duration->id
                    ]);
                }
                break;

            default:
                dd($selected);
                break;
        }

        session()->flash('message', 'Added Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }

    public function update(){
        $this->validate();

        $selected = $this->selected;

        switch($selected){
            case 'sub_funct':
                SubFunct::where('id', $this->sub_funct_id)->update([
                    'sub_funct' => $this->sub_funct
                ]);
                break;
            case 'output':
                Output::where('id', $this->output_id)->update([
                    'output' => $this->output,
                ]);
                break;
            case 'suboutput':
                Suboutput::where('id', $this->suboutput_id)->update([
                    'suboutput' => $this->suboutput,
                ]);
                break;
            case 'target':
                Target::where('id', $this->target_id)->update([
                    'target' => $this->target,
                ]);
                break;

            default:
                dd($selected);
                break;
        }

        session()->flash('message', 'Updated Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }

    // When choosing add/edit/delete and output/suboutput/target(OST)
    public function changed()
    {
        $this->resetInput();
    }
    // <------------ CONFIGURING OST END!

    // Delete OST-R
    public function delete(){

        $selected = $this->selected;

        switch($selected){
            case 'sub_funct':
                SubFunct::find($this->sub_funct_id)->delete();
                break;
            case 'output':
                Output::find($this->output_id)->delete();
                break;
            case 'suboutput':
                Suboutput::find($this->suboutput_id)->delete();
                break;
            case 'target':
                Target::find($this->target_id)->delete();
                break;
            case 'rating':
                Rating::find($this->rating_id)->delete();
                break;
            default:
                dd($selected);
                break;

        }

        session()->flash('message', 'Deleted Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }

    // SUBMITING OF IPCR START ------------>
    public function saveIPCR()
    {
        Approval::create([
            'name' => 'approval',
            'added_id' => Auth::user()->id,
            'superior1_status' => 1,
            'superior2_status' => 1,
            'type' => 'ipcr',
            'user_type' => 'faculty',
            'duration_id' => $this->duration->id
        ]);

        session()->flash('message', 'Saved Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }
    // <---------------- SUBMITING OF IPCR END

    public function resetInput()
    {
        $this->output = '';
        $this->suboutput = '';
        $this->subput = '';
        $this->target = '';
        $this->code = '';
        $this->funct_id = '';
        $this->number = 1;
        $this->output_id = '';
        $this->suboutput_id = '';
        $this->target_id = '';
        $this->data = '';
        $this->rating_id = '';
        $this->superior1_id = '';
        $this->superior2_id = '';
        $this->sub_funct = '';
        $this->sub_funct_id = '';
    }

    public function closeModal()
    {
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }
}
