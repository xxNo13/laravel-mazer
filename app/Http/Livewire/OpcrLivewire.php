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

class OpcrLivewire extends Component
{
    use WithPagination;

    public $selected = 'output';
    public $sub_funct;
    public $sub_funct_id;
    public $output;
    public $suboutput;
    public $subput;
    public $target;
    public $accomplishment;
    public $efficiency;
    public $quality;
    public $timeliness;
    public $average;
    public $remarks;
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
    public $type = "OPCR";
    public $alloted_budget;
    public $responsible;
    public $duration;
    public $targ;
    public $subFuncts;
    public $percentage;
    public $core;
    public $strategic;
    public $support;
    public $supp = [];

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
        'core' => ['required_if:selected,percentage'],
        'strategic' => ['required_if:selected,percentage'],
        'support' => ['required_if:selected,percentage'],
    ];

    public function mount()
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
                ->where('user_id', Auth::user()->id)
                ->where('type', 'opcr')
                ->where('duration_id', $this->duration->id)
                ->first();
            $this->targ = Target::where('user_id', Auth::user()->id)
                ->where('type', 'opcr')
                ->where('user_type', 'office')
                ->where('duration_id', $this->duration->id)
                ->first();
            $this->subFuncts = SubFunct::where('user_id', Auth::user()->id)
                ->where('type', 'opcr')
                ->where('user_type', 'office')
                ->where('duration_id', $this->duration->id)
                ->get();
            $this->percentage = Percentage::where('user_id', Auth::user()->id)
                ->where('type', 'opcr')
                ->where('userType', 'office')
                ->where('duration_id', $this->duration->id)
                ->first();
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
    public function select($selected, $id = null)
    {
        $this->selected = $selected;

        if ($id) {
            switch ($selected) {
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

        switch ($selected) {
            case 'sub_funct':
                SubFunct::create([
                    'sub_funct' => $this->sub_funct,
                    'funct_id' => 3,
                    'user_id' => Auth::user()->id,
                    'type' => 'opcr',
                    'user_type' => 'office',
                    'duration_id' => $this->duration->id
                ]);
                break;
            case 'output':
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
                if ($this->sub_funct_id) {
                    Output::create([
                        'code' => $this->code,
                        'output' => $this->output,
                        'sub_funct_id' => $this->sub_funct_id,
                        'user_id' => Auth::user()->id,
                        'type' => 'opcr',
                        'user_type' => 'office',
                        'duration_id' => $this->duration->id
                    ]);
                    break;
                }
                Output::create([
                    'code' => $this->code,
                    'output' => $this->output,
                    'funct_id' => $this->funct_id,
                    'user_id' => Auth::user()->id,
                    'type' => 'opcr',
                    'user_type' => 'office',
                    'duration_id' => $this->duration->id
                ]);
                break;
            case 'suboutput':
                Suboutput::create([
                    'suboutput' => $this->suboutput,
                    'output_id' => $this->output_id,
                    'user_id' => Auth::user()->id,
                    'type' => 'opcr',
                    'user_type' => 'office',
                    'duration_id' => $this->duration->id
                ]);
                break;
            case 'target':
                $subputArr = explode(',', $this->subput);

                if ($subputArr[0] == 'output') {
                    Target::create([
                        'target' => $this->target,
                        'output_id' =>  $subputArr[1],
                        'user_id' => Auth::user()->id,
                        'type' => 'opcr',
                        'user_type' => 'office',
                        'duration_id' => $this->duration->id
                    ]);
                } elseif ($subputArr[0] == 'suboutput') {
                    Target::create([
                        'target' => $this->target,
                        'suboutput_id' =>  $subputArr[1],
                        'user_id' => Auth::user()->id,
                        'type' => 'opcr',
                        'user_type' => 'office',
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

    public function update()
    {
        $this->validate();

        $selected = $this->selected;

        switch ($selected) {
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

    // CONFIGURING RATING START ----------->
    public function rating($target_id = null, $rating_id = null)
    {
        $this->selected = 'rating';
        $this->rating_id = $rating_id;
        $this->target_id = $target_id;
    }

    public function editRating($rating_id)
    {
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

    public function saveRating($category)
    {

        $this->validate();

        if ($category == 'add') {
            $divisor = 0;
            if (!$this->efficiency) {
                $divisor++;
            }
            if (!$this->quality) {
                $divisor++;
            }
            if (!$this->timeliness) {
                $divisor++;
            }
            $number = ($this->efficiency + $this->quality + $this->timeliness) / (3 - $divisor);
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
                'duration_id' => $this->duration->id,
                'type' => 'opcr'
            ]);

            session()->flash('message', 'Added Successfully!');
        } elseif ($category == 'edit') {
            $divisor = 0;
            if (!$this->efficiency) {
                $divisor++;
            }
            if (!$this->quality) {
                $divisor++;
            }
            if (!$this->timeliness) {
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

    // SUBMITING OF OPCR START ------------>
    public function submit()
    {
        $this->selected = 'submit';
    }

    public function changeUser()
    {
        if ($this->superior1_id != '') {
            $this->users2 = User::whereHas('account_types', function (\Illuminate\Database\Eloquent\Builder $query) {
                return $query->where('account_type', 'like', "%head%");
            })->where('id', '!=', $this->superior1_id)->where('id', '!=', Auth::user()->id)->get();
        } elseif ($this->superior2_id != '') {
            $this->users1 = User::whereHas('account_types', function (\Illuminate\Database\Eloquent\Builder $query) {
                return $query->where('account_type', 'like', "%head%");
            })->where('id', '!=', $this->superior2_id)->where('id', '!=', Auth::user()->id)->get();
        }
    }

    public function submitISO()
    {

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
    // <---------------- SUBMITING OF OPCR END
    // Configuring Percentage ------------------->
    public function savePercent()
    {
        $this->selected = 'percentage';
        $this->validate();

        $percentage = Percentage::create([
            'core' => $this->core,
            'strategic' => $this->strategic,
            'support' => $this->support,
            'type' => 'opcr',
            'userType' => 'office',
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
        return redirect(request()->header('Referer'));
    }

    public function updatePercent()
    {
        $this->selected = 'percentage';
        $this->validate();

        Percentage::where('id', $this->percentage->id)->update([
            'core' => $this->core,
            'strategic' => $this->strategic,
            'support' => $this->support,
        ]);

        $suppPercentage = SuppPercentage::where('percentage_id', $this->percentage->id)
            ->where('user_id', Auth::user()->id)
            ->where('duration_id', $this->duration->id)
            ->get();

        foreach ($this->subFuncts as $subFunct) {
            foreach ($suppPercentage as $supp) {
                if ($subFunct->sub_funct == $supp->name) {
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
        return redirect(request()->header('Referer'));
    }

    public function deletePercentage()
    {
        Percentage::where('id', $this->percentage->id)->delete();

        SuppPercentage::where('percentage_id', $this->percentage->id)->delete();

        session()->flash('message', 'Updated Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
        return redirect(request()->header('Referer'));
    }

    public function percent()
    {
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
    // <------------------- Percetage Configure End
    public function resetInput()
    {
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
        $this->rating_id = '';
        $this->superior1_id = '';
        $this->superior2_id = '';
        $this->alloted_budget = '';
        $this->responsible = '';
    }

    public function closeModal()
    {
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }
}
