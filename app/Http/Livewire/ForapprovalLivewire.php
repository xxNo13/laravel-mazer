<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Funct;
use Livewire\Component;
use App\Models\Approval;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class ForapprovalLivewire extends Component
{
    use WithPagination;

    public $view = false;
    public $category = '';
    public $user_id = '';
    public $url = '';
    public $approval;
    public $search;

    protected  $queryString = ['search'];

    public function viewed($user_id, $category, $url){
        $this->user_id = $user_id;
        $this->category = $category;
        $this->url = $url;
        $this->view = true;
        $this->approval = Approval::orderBy('id', 'DESC')->where('user_id', $user_id)->where('type', $category)->first();
    }

    public function render()
    {
        if ($this->view && $this->category == 'ipcr'){
            $functs = Funct::all();
            $user = User::find($this->user_id);
            return view('components.individual-ipcr',[
                'functs' => $functs,
                'user' => $user,
                'url' => $this->url,
                'approval' => $this->approval,
            ]);
        } elseif ($this->view && $this->category == 'opcr'){
            $functs = Funct::all();
            $user = User::find($this->user_id);
            return view('components.individual-opcr',[
                'functs' => $functs,
                'user' => $user,
                'url' => $this->url,
                'approval' => $this->approval,
            ]);
        } elseif ($this->view && $this->category == 'standard'){
            $functs = Funct::all();
            $user = User::find($this->user_id);
            return view('components.individual-standard',[
                'functs' => $functs,
                'user' => $user,
                'url' => $this->url,
                'approval' => $this->approval,
            ]);
        } else {
            $search = $this->search;
            $approvals = Approval::query();

            if ($search) {
                $approvals->whereHas('user', function(\Illuminate\Database\Eloquent\Builder $query) use ($search){
                    return $query->whereHas('office', function(\Illuminate\Database\Eloquent\Builder $query) use ($search){
                        return $query->where('office', 'LIKE','%'.$search.'%')
                            ->orWhere('building','LIKE','%'.$search.'%');
                    })->where('name', 'LIKE','%'.$search.'%')
                        ->orWhere('email','LIKE','%'.$search.'%')
                        ->orWhere('account_types','LIKE','%'.$search.'%');
                })
                ->orWhere('type','LIKE','%'.$search.'%')
                ->get();
            }

            return view('livewire.forapproval-livewire', [
                'approvals' => $approvals->paginate(10),
            ]);
        }
    }

    public function updated($property)
    {
        if ($property == 'search') {
            $this->resetPage();
        }
    }

    public function approved($id){
        $approval = Approval::find($id);

        if ($approval->superior1_id == Auth::user()->id){
            Approval::where('id', $id)->update([
                'superior1_status' => 1,
            ]);
        } elseif ($approval->superior2_id == Auth::user()->id){
            Approval::where('id', $id)->update([
                'superior2_status' => 1,
            ]);
        }

        session()->flash('message', 'Approved Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
        return redirect(request()->header('Referer'));
    }

    public function disapproved($id){
        $approval = Approval::find($id);

        if ($approval->superior1_id == Auth::user()->id){
            Approval::where('id', $id)->update([
                'superior1_status' => 2,
            ]);
        } elseif ($approval->superior2_id == Auth::user()->id){
            Approval::where('id', $id)->update([
                'superior2_status' => 2,
            ]);
        }

        session()->flash('message', 'Disapproved Successfully!');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
        return redirect(request()->header('Referer'));
    }

    public function resetInput(){
        $this->view = false;
        $this->category = '';
        $this->user_id = '';
        $this->url = '';
        $this->approval = '';
    }

    public function closeModal(){
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal'); 
    }
}
