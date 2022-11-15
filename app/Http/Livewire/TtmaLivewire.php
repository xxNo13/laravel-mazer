<?php

namespace App\Http\Livewire;

use App\Models\Ttma;
use App\Models\User;
use Livewire\Component;
use App\Models\Duration;
use App\Notifications\AssignmentNotification;
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
    public $message;
    public $selected;
    public $comment;

    protected $rules = [
        'subject' => ['nullable', 'required_if:selected,assign', 'min:5'],
        'user_id' => ['nullable', 'required_if:selected,assign'],
        'output' => ['nullable', 'required_if:selected,assign', 'min:5'],
        'message' => ['nullable', 'required_if:selected,message', 'min:5'],
        'comment' => ['nullable', 'required_if:selected,disapprove', 'min:5'],
    ];

    protected  $queryString = ['search'];

    public function render()
    {   
        $this->users = User::where('id', '!=', Auth::user()->id)->get();
        $this->duration = Duration::orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->first();
    
        $search = $this->search;
        $ttmas = Ttma::query();

        if ($search) {

            if($this->duration) {
                $ttmas->where(function ($query) use ($search) {
                    $query->whereHas('user', function (\Illuminate\Database\Eloquent\Builder $query) use ($search) {
                        return $query->where('name', 'LIKE', '%' . $search . '%');
                    })
                        ->orWhere('subject', 'LIKE', '%' . $search . '%')
                        ->orWhere('output', 'LIKE', '%' . $search . '%');
                })->where('duration_id', $this->duration->id)
                ->where('head_id', Auth::user()->id)
                ->get();;
            } else {
                $ttmas->where(function ($query) use ($search) {
                    $query->whereHas('user', function (\Illuminate\Database\Eloquent\Builder $query) use ($search) {
                        return $query->where('name', 'LIKE', '%' . $search . '%');
                    })
                        ->orWhere('subject', 'LIKE', '%' . $search . '%')
                        ->orWhere('output', 'LIKE', '%' . $search . '%');
                })->where('head_id', Auth::user()->id)
                    ->get();
            }
        }

        if($this->duration) {
            return view('livewire.ttma-livewire', [
                'ttmas' => $ttmas
                        ->where('duration_id', $this->duration->id)
                        ->where('head_id', Auth::user()->id)
                        ->paginate(10),
                'assignments' => Ttma::orderBy('created_at', 'DESC')
                                ->where('user_id', Auth::user()->id)
                                ->where('duration_id', $this->duration->id)
                                ->paginate(10),
            ]);
        }
        return view('livewire.ttma-livewire', [
            'ttmas' => $ttmas->where('head_id', Auth::user()->id)->paginate(10),
            'assignments' => Ttma::orderBy('created_at', 'DESC')->paginate(10),
        ]);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function save()
    {

        $this->validate();

        if ($this->ttma_id) {
            $ttma = Ttma::where('id', $this->ttma_id)->first();

            $userOld = User::where('id', $ttma->user_id)->first();

            foreach ($userOld->notifications as $notification) {
                if(isset($notification->data['ttma_id']) && $notification->data['ttma_id'] == $ttma->id){
                    $notification->delete();
                }
            }
        
            $user = User::where('id', $this->user_id)->first();

            $user->notify(new AssignmentNotification($ttma));

            Ttma::where('id', $this->ttma_id)->update([
                'subject' => $this->subject,
                'user_id' => $this->user_id,
                'output' => $this->output,
            ]);

            session()->flash('message', 'Updated Successfully!');
        } else {
            $ttma = Ttma::create([
                'subject' => $this->subject,
                'user_id' => $this->user_id,
                'output' => $this->output,
                'head_id' => Auth::user()->id,
                'duration_id' => $this->duration->id
            ]);

            $user = User::where('id', $this->user_id)->first();

            $user->notify(new AssignmentNotification($ttma));

            session()->flash('message', 'Added Successfully!');
        }

        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function disapproved() {
        $this->validate();

        $ttma = Ttma::where('id', $this->ttma_id)->first();
    
        $user = User::where('id', $ttma->user_id)->first();

        $user->notify(new AssignmentNotification($ttma, 'Disapproved'));

        Ttma::where('id', $this->ttma_id)->update([
            'message' => null,
            'comments' => $this->comment,
        ]);

        session()->flash('message', 'Sent Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function message() {

        $this->validate();

        $ttma = Ttma::where('id', $this->ttma_id)->first();
    
        $user = User::where('id', $ttma->head_id)->first();

        $user->notify(new AssignmentNotification($ttma, 'Done'));

        Ttma::where('id', $this->ttma_id)->update([
            'message' => $this->message,
            'comments' => null,
        ]);

        session()->flash('message', 'Sent Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function done()
    {
        $ttma = Ttma::where('id', $this->ttma_id)->first();
        
        $ttma->update([
            'remarks' => 'Done'
        ]);

        $user = User::where('id', $ttma->user_id)->first();

        $user->notify(new AssignmentNotification($ttma));

        session()->flash('message', 'Mark the assignment as completed!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function select($select, $ttma_id, $category = null)
    {
        $this->selected = $select;
        $this->ttma_id = $ttma_id;

        if ($category == 'edit') {

            $data = Ttma::find($ttma_id);

            $this->subject = $data->subject;
            $this->user_id = $data->user_id;
            $this->output = $data->output;
            $this->message = $data->message;
        }
    }

    public function delete()
    {
        $ttma = Ttma::where('id', $this->ttma_id)->first();

        $user = User::where('id', $ttma->user_id)->first();

        foreach ($user->notifications as $notification) {
            if(isset($notification->data['ttma_id']) && $notification->data['ttma_id'] == $ttma->id){
                $notification->delete();
            }
        }
        
        $ttma->delete();

        session()->flash('message', 'Deleted Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetInput()
    {
        $this->subject = '';
        $this->user_id = '';
        $this->output = '';
        $this->ttma_id = '';
        $this->search = '';
        $this->duration = '';
        $this->message = '';
        $this->selected = '';
        $this->comment = '';
    }

    public function closeModal()
    {
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }
}
