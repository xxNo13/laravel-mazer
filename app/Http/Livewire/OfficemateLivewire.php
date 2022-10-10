<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Funct;
use Livewire\Component;
use App\Models\Duration;
use Livewire\WithPagination;

class OfficemateLivewire extends Component
{
    use WithPagination;

    public $view = false;
    public $user_id = '';
    public $url = '';
    public $search = '';
    public $duration;
    
    protected  $queryString = ['search'];

    public function viewed($user_id, $url){
        $this->user_id = $user_id;
        $this->url = $url;
        $this->view = true;
    }

    public function mount(){
        $this->duration = Duration::orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->first();
    }

    public function updated($property)
    {
        if ($property == 'search') {
            $this->resetPage();
        }
    }

    public function render()
    {
        if ($this->view) {
            $functs = Funct::all();
            $user = User::find($this->user_id);
            return view('components.individual-ipcr',[
                'functs' => $functs,
                'user' => $user,
                'url' => $this->url,
                'duration' => $this->duration
            ]);
        } else {
            $query = User::query();
            if ($this->search) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orwhere('email', 'like', "%{$this->search}%")
                    ->orwhere('account_types', 'like', "%{$this->search}%");
            }
            // $users = User::where('name', 'like', '%'.$this->search.'%')->orderBy('name', 'ASC')->paginate(10);
            return view('livewire.officemate-livewire',[
                'users' => $query->orderBy('name', 'ASC')->paginate(10)
            ]);
        }
    }
}
