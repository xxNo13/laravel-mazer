<?php

namespace App\Http\Livewire;

use App\Models\Ttma;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationLivewire extends Component
{
    public function render()
    {
        foreach (Auth::user()->unreadNotifications as $notification) {
            if(str_replace(url('/'), '', url()->current()) == '/ttma' && $notification->data['ttma_id']){
                $notification->markAsRead();
            } elseif (str_replace(url('/'), '', url()->current()) == '/ipcr/staff' && isset($notification->data['type']) && ($notification->data['type'] == 'ipcr' && $notification->data['userType'] == 'staff')) {
                $notification->markAsRead();
            } elseif (str_replace(url('/'), '', url()->current()) == '/ipcr/faculty' && isset($notification->data['type']) && ($notification->data['type'] == 'ipcr' && $notification->data['userType'] == 'faculty')) {
                $notification->markAsRead();
            } elseif (str_replace(url('/'), '', url()->current()) == '/standard/staff' && isset($notification->data['type']) && ($notification->data['type'] == 'standard' && $notification->data['userType'] == 'staff')) {
                $notification->markAsRead();
            } elseif (str_replace(url('/'), '', url()->current()) == '/standard/faculty' && isset($notification->data['type']) && ($notification->data['type'] == 'standard' && $notification->data['userType'] == 'faculty')) {
                $notification->markAsRead();
            } elseif (str_replace(url('/'), '', url()->current()) == '/opcr' && isset($notification->data['type']) && ($notification->data['type'] == 'opcr' && $notification->data['userType'] == 'office')) {
                $notification->markAsRead();
            } elseif (str_replace(url('/'), '', url()->current()) == '/standard/opcr' && isset($notification->data['type']) && ($notification->data['type'] == 'standard' && $notification->data['userType'] == 'office')) {
                $notification->markAsRead();
            } elseif (str_replace(url('/'), '', url()->current()) == '/for-approval' && isset($notification->data['status']) && $notification->data['status'] == 'Submitting'){
                $notification->markAsRead();
            }
        }

        return view('livewire.notification-livewire',[
            'unreads' => 0
        ]);
    }

    public function read($id, $url) {
        foreach (Auth::user()->notifications as $notification)
        {
            if ($notification->id == $id)
            {
                $notification->markAsRead();

            }
        }
        
        return redirect($url);
    }
}
