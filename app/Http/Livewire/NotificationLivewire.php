<?php

namespace App\Http\Livewire;

use App\Models\Ttma;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationLivewire extends Component
{
    public function render()
    {
        $assignments = Ttma::orderBy('created_at', 'DESC')
                ->where('user_id', Auth::user()->id)
                ->get();

        return view('livewire.notification-livewire', [
            'assignments' => $assignments
        ]);
    }
}
