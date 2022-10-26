<?php

namespace App\Http\Livewire;

use App\Models\Ttma;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationLivewire extends Component
{
    public function render()
    {
        if(str_replace(url('/'), '', url()->current()) == '/ttma'){
            Auth::user()->unreadNotifications->markAsRead();
        }
        return view('livewire.notification-livewire',[
            'unreads' => 0
        ]);
    }

    public function read($id) {
        foreach (Auth::user()->notifications as $notification)
        {
            if ($notification->id == $id)
            {
                $notification->markAsRead();

            }
        }
        return redirect('/ttma');
    }
}
