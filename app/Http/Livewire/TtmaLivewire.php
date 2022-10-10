<?php

namespace App\Http\Livewire;

use App\Models\Ttma;
use App\Models\User;
use Livewire\Component;
use App\Models\Duration;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class TtmaLivewire extends Component
{
    use WithPagination;

    public $users;
    public $subject;
    public $user_id;
    public $output;
    public $ttma_id;
    public $search;
    public $duration;

    protected $rules = [
        'subject' => ['required', 'min:5'],
        'user_id' => ['required'],
        'output' => ['required', 'min:5'],
    ];
    
    protected  $queryString = ['search'];

    public function mount(){
        $this->users = User::where('id', '!=', Auth::user()->id)->get();
        $this->duration = Duration::orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->first();
    }

    public function render()
    {
        $search = $this->search;
        $ttmas = Ttma::query();

        if ($search) {
            $ttmas->whereHas('user', function(\Illuminate\Database\Eloquent\Builder $query) use ($search){
                return $query->where('name', 'LIKE','%'.$search.'%');
            })
            ->orWhere('subject','LIKE','%'.$search.'%')
            ->orWhere('output','LIKE','%'.$search.'%')
            ->where('duration_id', $this->duration->id)
            ->get();
        }
        
        return view('livewire.ttma-livewire', [
            'ttmas' => $ttmas->where('head_id', Auth::user()->id)->paginate(10)
        ]);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function save(){
        $this->validate();

        if ($this->ttma_id) {
            Ttma::where('id', $this->ttma_id)->update([
                'subject' => $this->subject,
                'user_id' => $this->user_id,
                'output' => $this->output,
            ]);
            
            session()->flash('message', 'Updated Successfully!');
        } else{
            Ttma::create([
                'subject' => $this->subject,
                'user_id' => $this->user_id,
                'output' => $this->output,
                'head_id' => Auth::user()->id,
                'duration_id' => $this->duration->id
            ]);
            
            session()->flash('message', 'Added Successfully!');
        }

        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }

    public function done(){
        Ttma::where('id', $this->ttma_id)->update([
            'remarks' => 'Done'
        ]);

        session()->flash('message', 'Mark the assignment as completed!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }

    public function select($ttma_id, $category = null){
        $this->ttma_id = $ttma_id;
        
        if  ($category == 'edit') {

            $data = Ttma::find($ttma_id);

            $this->subject = $data->subject;
            $this->user_id = $data->user_id;
            $this->output = $data->output;
        }
    }

    public function delete(){

        Ttma::where('id', $this->ttma_id)->delete();

        session()->flash('message', 'Deleted Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }

    public function resetInput(){
        $this->subject = '';
        $this->user_id = '';
        $this->output = '';
        $this->ttma_id = '';
    }

    public function closeModal(){
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }
}
