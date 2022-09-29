<?php

namespace App\Http\Livewire;

use App\Models\Office;
use Livewire\Component;

class OfficeLivewire extends Component
{   
    public function render()
    {
        $offices = Office::all();
        return view('livewire.office-livewire', [
            'offices' => $offices
        ]);
    }
}
