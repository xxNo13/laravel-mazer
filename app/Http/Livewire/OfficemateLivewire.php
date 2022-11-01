<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Funct;
use Livewire\Component;
use App\Models\Duration;
use App\Models\SubFunct;
use App\Models\Percentage;
use Livewire\WithPagination;

class OfficemateLivewire extends Component
{
    use WithPagination;

    public $view = false;
    public $user_id;
    public $url;
    public $search;
    public $duration;
    public $userType;
    public $perentage;

    protected  $queryString = ['search'];

    public function viewed($user_id, $url, $userType){
        $this->user_id = $user_id;
        $this->url = $url;
        $this->view = true;
        $this->userType = $userType;

        if ($this->duration) {
            $this->percentage = Percentage::where('user_id', $user_id)
                ->where('type', 'ipcr')
                ->where('userType', $userType)
                ->where('duration_id', $this->duration->id)
                ->first();
        }
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
                'duration' => $this->duration,
                'userType' => $this->userType,
                'percentage' => $this->percentage,
                'number' => 1
            ]);
        } else {
            $search = $this->search;
            $query = User::query();
            if ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orwhere('email', 'like', "%{$search}%")
                    ->orWhereHas('account_types', function(\Illuminate\Database\Eloquent\Builder $query) use ($search){
                        return $query->where('account_type', 'LIKE','%'.$search.'%');
                    });
            }
            // $users = User::where('name', 'like', '%'.$this->search.'%')->orderBy('name', 'ASC')->paginate(10);
            return view('livewire.officemate-livewire',[
                'users' => $query->orderBy('name', 'ASC')->paginate(10)
            ]);
        }
    }
}
