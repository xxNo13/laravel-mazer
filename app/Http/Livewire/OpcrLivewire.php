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
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class OpcrLivewire extends Component
{
    use WithPagination;

    public string $funct = '';
    public string $selected = 'output';
    public string $ost = 'add';
    public string $output = '';
    public string $suboutput = '';
    public string $subput = '';
    public $subputArr = [];
    public string $target = '';
    public string $accomplishment = '';
    public $efficiency = '';
    public $quality = '';
    public $timeliness = '';
    public $average;
    public string $remarks = '';
    public string $code = '';
    public $funct_id;
    public $number = 1;
    public $output_id;
    public $suboutput_id;
    public $target_id;
    public $data;
    public $rating_id;
    public $superior1_id;
    public $superior2_id;
    public $users1;
    public $users2;
    public $approval;
    public $type = "OPCR";
    public $alloted_budget;
    public $responsible;
    public $duration;

    // protected $paginationTheme = 'bootstrap';
    protected $rules = [
        'output' => ['required_if:selected,output'],
        'suboutput' => ['required_if:selected,suboutput'],
        'target' => ['required_if:selected,target'],
        'alloted_budget' => ['required_if:selected,rating'],
        'responsible' => ['required_if:selected,rating'],
        'accomplishment' => ['required_if:selected,rating'],
        'superior1_id' => ['required_if:selected,submit'],
        'superior2_id' => ['required_if:selected,submit'],
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
            $this->approval = Approval::orderBy('id', 'DESC')->where('user_id', Auth::user()->id)->where('type', 'opcr')->where('duration_id', $this->duration->id)->first();
        }
    }

    public function render()
    {
        $functs = Funct::paginate(1);

        return view('livewire.opcr-livewire', [
            'functs' => $functs,
            'userType' => 'office'
        ]);
    }
    
    
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    // CONFIGURING OST START ------------>
    // Save / Update OST
    public function save(){

        $this->validate();

        if ($this->ost == 'add'){
            if ($this->selected == 'output'){
                switch (str_replace(url('/'), '', url()->previous())) {
                    case '/opcr':
                        $this->code = 'CF ';
                        $this->funct_id = 1;
                        break;
                    case '/opcr?page=2':
                        $this->code = 'STF ';
                        $this->funct_id = 2;
                        break;
                    case '/opcr?page=3':
                        $this->code = 'SF ';
                        $this->funct_id = 3;
                        break;
                    default:
                        $this->code = 'Code ';
                        $this->funct_id = 0;
                        break;
                };
                Output::create([
                    'code' => $this->code,
                    'output' => $this->output,
                    'funct_id' => $this->funct_id,
                    'user_id' => Auth::user()->id,
                    'type' => 'opcr',
                    'user_type' => 'office',
                    'duration_id' => $this->duration->id
                ]);
            } elseif ($this->selected == 'suboutput') {
                Suboutput::create([
                    'suboutput' => $this->suboutput,
                    'output_id' => $this->output_id,
                    'user_id' => Auth::user()->id,
                    'type' => 'opcr',
                    'user_type' => 'office',
                    'duration_id' => $this->duration->id
                ]);
            } elseif ($this->selected == 'target') {
                $subputArr = explode(',', $this->subput);
    
                if ($subputArr[0] == 'output'){
                    Target::create([
                        'target' => $this->target,
                        'output_id' =>  $subputArr[1],
                        'user_id' => Auth::user()->id,
                        'type' => 'opcr',
                        'user_type' => 'office',
                        'duration_id' => $this->duration->id
                    ]);
                } elseif ($subputArr[0] == 'suboutput'){
                    Target::create([
                        'target' => $this->target,
                        'suboutput_id' =>  $subputArr[1],
                        'user_id' => Auth::user()->id,
                        'type' => 'opcr',
                        'user_type' => 'office',
                        'duration_id' => $this->duration->id
                    ]);
                }
    
            }

            session()->flash('message', 'Added Successfully!');


        } elseif ($this->ost == 'edit'){
            if ($this->selected == 'output'){
                Output::where('id', $this->output_id)->update([
                    'output' => $this->output
                ]);
            } elseif ($this->selected == 'suboutput'){
                Suboutput::where('id', $this->suboutput_id)->update([
                    'suboutput' => $this->suboutput
                ]);
            } elseif ($this->selected == 'target'){
                Target::where('id', $this->target_id)->update([
                    'target' => $this->target
                ]);
            }
            
            session()->flash('message', 'Updated Successfully!');
        }

        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }

    // When selecting what to edit
    public function editChanged(){
        if ($this->selected == 'output'){
            $this->data = Output::find($this->output_id);
            $this->output = $this->data->output;
        } elseif ($this->selected == 'suboutput'){
            $this->data = Suboutput::find($this->suboutput_id);
            $this->suboutput = $this->data->suboutput;
        } elseif ($this->selected == 'target'){
            $this->data = Target::find($this->target_id);
            $this->target = $this->data->target;
        }
    }

    // When choosing add/edit/delete and output/suboutput/target(OST)
    public function changed(){
        $this->resetInput();
    }
    // <------------ CONFIGURING OST END!

    // CONFIGURING RATING START ----------->
    public function rating($target_id = null, $rating_id = null){
        $this->selected = 'rating';
        $this->rating_id = $rating_id;
        $this->target_id = $target_id;
    }

    public function editRating($rating_id){
        $this->selected = 'rating';
        $this->rating_id = $rating_id;

        $rating = Rating::find($rating_id);

        $this->alloted_budget = $rating->alloted_budget;
        $this->responsible = $rating->responsible;
        $this->accomplishment = $rating->accomplishment;
        $this->efficiency = $rating->efficiency;
        $this->quality = $rating->quality;
        $this->timeliness = $rating->timeliness;
    }

    public function saveRating($category){

        $this->validate();

        if ($category == 'add') {
            $number = ($this->efficiency + $this->quality + $this->timeliness) / 3;
            $average = number_format((float)$number, 2, '.', '');

            Rating::create([
                'alloted_budget' => $this->alloted_budget,
                'responsible' => $this->responsible,
                'accomplishment' => $this->accomplishment,
                'efficiency' => $this->efficiency,
                'quality' => $this->quality,
                'timeliness' => $this->timeliness,
                'average' => $average,
                'remarks' => 'Done',
                'target_id' => $this->target_id,
                'user_id' => Auth::user()->id,
                'type' => 'opcr'
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
                'alloted_budget' => $this->alloted_budget,
                'responsible' => $this->responsible,
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

        if ($this->selected == 'output'){
            Output::find($this->output_id)->delete();
        } elseif ($this->selected == 'suboutput'){
            Suboutput::find($this->suboutput_id)->delete();
        } elseif ($this->selected == 'target'){
            Target::find($this->target_id)->delete();
        } elseif ($this->selected == 'rating'){
            Rating::find($this->rating_id)->delete();
        }

        session()->flash('message', 'Deleted Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }

    // SUBMITING OF OPCR START ------------>
    public function submit(){
        $this->selected = 'submit';
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
            'type' => 'opcr',
            'user_type' => 'office',
            'duration_id' => $this->duration->id
        ]);

        session()->flash('message', 'Submitted Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
        return redirect(request()->header('Referer'));
    }
    // <---------------- SUBMITING OF oPCR END

    public function resetInput(){
        $this->funct = '';
        $this->output = '';
        $this->suboutput = '';
        $this->subput = '';
        $this->target = '';
        $this->accomplishment = '';
        $this->quality = '';
        $this->efficiency = '';
        $this->timeliness = '';
        $this->average;
        $this->remarks = '';
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
        $this->alloted_budget = '';
        $this->responsible = '';
    }

    public function closeModal(){
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }
}
