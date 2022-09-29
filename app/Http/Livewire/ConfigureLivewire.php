<?php

namespace App\Http\Livewire;

use App\Models\Office;
use Livewire\Component;
use Livewire\WithPagination;

class ConfigureLivewire extends Component
{
    use WithPagination;

    public $searchoffice = '';
    public $type;
    public $category;
    public $office_id;
    public $office;
    public $building;

    protected $rules = [
        'office' => ['required_if:type,office'],
        'building' =>  ['required_if:type,office']
    ];

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function render()
    {
        $query = Office::query();
        if ($this->searchoffice) {
            $query->where('office', 'like', "%{$this->searchoffice}%")
                ->orwhere('building', 'like', "%{$this->searchoffice}%");
        }

        return view('livewire.configure-livewire',[
            'offices' => $query->orderBy('office', 'ASC')->paginate(10)
        ]);
    }

    public function save(){
        $this->validate();

        if ($this->category == 'edit' && $this->type == 'office') {
            Office::where('id', $this->office_id)->update([
                'office' => $this->office, 
                'building' => $this->building
            ]);

            session()->flash('message', 'Updated Successfully!');
        } else {
            Office::create([
                'office' => $this->office, 
                'building' => $this->building
            ]);

            session()->flash('message', 'Added Successfully!');
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
        }
    }

    public function delete(){
        if($this->type == 'office') {
            Office::where('id', $this->office_id)->delete();
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
    }

    public function closeModal(){
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }
}
