<?php

namespace App\Http\Livewire;

use App\Models\Office;
use App\Models\ScoreEq;
use Livewire\Component;
use App\Models\Duration;
use App\Models\AccountType;
use Livewire\WithPagination;

class ConfigureLivewire extends Component
{
    use WithPagination;

    public $searchoffice = '';
    public $sortOffice = 'id';
    public $ascOffice = 'asc';
    public $pageOffice = 10;
    public $searchacctype = '';
    public $sortAccType = 'id';
    public $ascAccType = 'asc';
    public $pageAccType = 10;
    public $type;
    public $category;
    public $office_id;
    public $office;
    public $building;
    public $account_type_id;
    public $account_type;
    public $rank;
    public $duration_id;
    public $start_date;
    public $end_date;
    public $duration;
    public $scoreEq_id;
    public $out_from;
    public $out_to;
    public $verysat_from;
    public $verysat_to;
    public $sat_from;
    public $sat_to;
    public $unsat_from;
    public $unsat_to;
    public $poor_from;
    public $poor_to;

    protected $rules = [
        'office' => ['required_if:type,office'],
        'building' =>  ['required_if:type,office'],
        'account_type' => ['required_if:type,account_type'],
        'rank' => ['nullable', 'required_if:type,account_type', 'integer'],
        'out_from' => ['nullable', 'required_if:type,scoreEq', 'numeric', 'max:5', 'gte:verysat_to'],
        'out_to' => ['nullable', 'required_if:type,scoreEq', 'numeric', 'max:5', 'gt:out_from'],
        'verysat_from' => ['nullable', 'required_if:type,scoreEq', 'numeric', 'max:5', 'gte:sat_to'],
        'verysat_to' => ['nullable', 'required_if:type,scoreEq', 'numeric', 'max:5', 'gt:verysat_from'],
        'sat_from' => ['nullable', 'required_if:type,scoreEq', 'numeric', 'max:5', 'gte:unsat_to'],
        'sat_to' => ['nullable', 'required_if:type,scoreEq', 'numeric', 'max:5', 'gt:sat_from'],
        'unsat_from' => ['nullable', 'required_if:type,scoreEq', 'numeric', 'max:5', 'gte:poor_to'],
        'unsat_to' => ['nullable', 'required_if:type,scoreEq', 'numeric', 'max:5', 'gt:unsat_from'],
        'poor_from' => ['nullable', 'required_if:type,scoreEq', 'numeric', 'max:5', 'lt:poor_to'],
        'poor_to' => ['nullable', 'required_if:type,scoreEq', 'numeric', 'max:5', 'gt:poor_from'],
    ];

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function render()
    {
        $this->duration = Duration::orderBy('id', 'DESC')->first();
        $offices = Office::query();
        if ($this->searchoffice) {
            $offices->where('office', 'like', "%{$this->searchoffice}%")
                ->orwhere('building', 'like', "%{$this->searchoffice}%");
        }

        $account_types = AccountType::query();
        if ($this->searchacctype) {
            $account_types->where('account_type', 'like', "%{$this->searchacctype}%");
        }

        return view('livewire.configure-livewire',[
            'offices' => $offices->orderBy($this->sortOffice, $this->ascOffice)->paginate($this->pageOffice),
            'account_types' => $account_types->orderBy($this->sortAccType, $this->ascAccType)->paginate($this->pageAccType),
            'durations' => Duration::orderBy('id', 'desc')->paginate(10),
            'startDate' => $this->start_date,
            'scoreEq' => ScoreEq::first(),
        ]);
    }

    public function startChanged(){
        if($this->end_date <= $this->start_date){
            $this->end_date = $this->start_date;
        }
    }

    public function save(){
        $this->validate();

        if ($this->category == 'edit' && $this->type == 'office') {
            Office::where('id', $this->office_id)->update([
                'office' => $this->office, 
                'building' => $this->building
            ]);

            session()->flash('message', 'Updated Successfully!');
        } elseif ($this->type == 'office') {
            Office::create([
                'office' => $this->office, 
                'building' => $this->building
            ]);

            session()->flash('message', 'Added Successfully!');
        } elseif ($this->category == 'edit' && $this->type == 'account_type') {
            AccountType::where('id', $this->account_type_id)->update([
                'account_type' => $this->account_type,
                'rank' => $this->rank,
            ]);

            session()->flash('message', 'Updated Successfully!');
        } elseif ($this->type == 'account_type') {
            AccountType::create([
                'account_type' => $this->account_type,
                'rank' => $this->rank,
            ]);

            session()->flash('message', 'Added Successfully!');
        } elseif ($this->category == 'edit' && $this->type == 'duration') {
            Duration::where('id', $this->duration_id)->update([
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]);

            session()->flash('message', 'Updated Successfully!');
        } elseif ($this->type == 'duration') {
            Duration::create([
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]);

            session()->flash('message', 'Added Successfully!');
            return redirect(request()->header('Referer'));
        } elseif ($this->type == 'scoreEq' && $this->category == 'edit') {
            ScoreEq::where('id', $this->scoreEq_id)->update([
                'out_from' => $this->out_from,
                'out_to' => $this->out_to,
                'verysat_from' => $this->verysat_from,
                'verysat_to' => $this->verysat_to,
                'sat_from' => $this->sat_from,
                'sat_to' => $this->sat_to,
                'unsat_from' => $this->unsat_from,
                'unsat_to' => $this->unsat_to,
                'poor_from' => $this->poor_from,
                'poor_to' => $this->poor_to,
            ]);

            session()->flash('message', 'Updated Successfully!');
        }

        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }

    public function select($type, $id = null, $category = null){
        $this->type = $type;

        if ($type == 'office') {
            $this->office_id = $id;
            if ($category == 'edit') {
                $this->category = $category;

                $data = Office::find($this->office_id);

                $this->office = $data->office;
                $this->building = $data->building;
            }
        } elseif ($type == 'account_type') {
            $this->account_type_id = $id;
            if ($category == 'edit') {
                $this->category = $category;

                $data = AccountType::find($this->account_type_id);

                $this->account_type = $data->account_type;
                $this->rank = $data->rank;
            }
        } elseif ($type == 'duration') {
            $this->duration_id = $id;
            if ($category == 'edit') {
                $this->category = $category;

                $data = Duration::find($this->duration_id);

                $this->start_date = $data->start_date;
                $this->end_date = $data->end_date;
            }
        } elseif ($type == 'scoreEq') {
            $this->scoreEq_id = $id;
            $this->category = $category;

            $data = ScoreEq::find($this->scoreEq_id);

            $this->out_from = $data->out_from;
            $this->out_to = $data->out_to;
            $this->verysat_from = $data->verysat_from;
            $this->verysat_to = $data->verysat_to;
            $this->sat_from = $data->sat_from;
            $this->sat_to = $data->sat_to;
            $this->unsat_from = $data->unsat_from;
            $this->unsat_to = $data->unsat_to;
            $this->poor_from = $data->poor_from;
            $this->poor_to = $data->poor_to;
        }
    }

    public function delete(){
        if($this->type == 'office') {
            Office::where('id', $this->office_id)->delete();
        } elseif ($this->type == 'account_type') {
            AccountType::where('id', $this->account_type_id)->delete();
        } elseif ($this->type == 'duration') {
            Duration::where('id', $this->duration_id)->delete();
        }

        session()->flash('message', 'Deleted Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }
    
    public function resetInput(){
        $this->office_id = '';
        $this->office = '';
        $this->building = '';
        $this->type = '';
        $this->category = '';
        $this->account_type_id = '';
        $this->account_type = '';
        $this->sortOffice = 'id';
        $this->ascOffice = 'asc';
        $this->pageOffice = 10;
        $this->sortAccType = 'id';
        $this->ascAccType = 'asc';
        $this->pageAccType = 10;
        $this->duration_id = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->out_from = '';
        $this->out_to = '';
        $this->verysat_from = '';
        $this->verysat_to = '';
        $this->sat_from = '';
        $this->sat_to = '';
        $this->unsat_from = '';
        $this->unsat_to = '';
        $this->poor_from = '';
        $this->poor_to = '';
    }

    public function closeModal(){
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }
}
