<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AccountType;

class AccountTypeLivewire extends Component
{
    public function render()
    {
        $account_types = AccountType::all();
        return view('livewire.account-type-livewire',[
            'account_types' => $account_types
        ]);
    }
}
