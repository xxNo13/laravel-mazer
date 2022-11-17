<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Training;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class TrainingLivewire extends Component
{
    use WithPagination;

    public $training;
    public $link;
    public $possible_target;
    public $training_id;
    public $search;
    public $targets;

    protected  $queryString = ['search'];

    protected $rules = [
        'training' => ['required'],
        'link' => ['required'],
        'possible_target' => ['required'],
    ];

    public function render()
    {
        $search = preg_split('/\s+/', $this->search);
        $trainings = Training::query();

        if ($search) {
            foreach ($search as $s) {
                $trainings->orWhere('training', 'LIKE', '%' . $s . '%')
                ->orWhere('possible_target', 'LIKE', '%' . $s . '%');
            }
        }
        
        $trainings = $trainings->orderBy('id', 'DESC')->distinct()->paginate(25);

        return view('livewire.training-livewire',[
            'trainings' => $trainings,
        ]);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function save() {
        $this->validate();

        Training::create([
            'training' => $this->training,
            'link' => $this->link,
            'possible_target' => $this->possible_target,
            'user_id' => Auth::user()->id
        ]);

        session()->flash('message', 'Added Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function update() {
        $this->validate();

        Training::where('id', $this->training_id)->update([
            'training' => $this->training,
            'link' => $this->link,
            'possible_target' => $this->possible_target,
            'user_id' => Auth::user()->id
        ]);

        session()->flash('message', 'Updated Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function delete() {
        Training::where('id', $this->training_id)->delete();

        session()->flash('message', 'Deleted Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function clicked($id, $category = null) {
        $this->training_id = $id;

        if($category) {
            $training = Training::find($id);

            $this->training = $training->training;
            $this->link = $training->link;
            $this->possible_target = $training->possible_target;
        }
    }

    public function resetInput()
    {
        $this->training = '';
        $this->link = '';
        $this->possible_target = '';
        $this->training_id = '';
        $this->search;
    }

    public function closeModal()
    {
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }
}
