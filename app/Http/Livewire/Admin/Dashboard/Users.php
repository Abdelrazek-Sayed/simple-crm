<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\User;
use Livewire\Component;

class Users extends Component
{

    public $usersCount;

    public function mount()
    {
        $this->getUsersCount();
    }

    public function getUsersCount($option = 'today')
    {
        $this->usersCount  = User::query()->whereBetween('created_at',$this->getDateRang($option))->count();
    }

    public function getDateRang($option)
    {
        if($option == 'today'){
            return [now()->today(),now()];
        }

        if($option == 'MTD'){
            return [now()->firstOfMonth(),now()];
        }

        if($option == 'YTD'){
            return [now()->firstOfYear(),now()];
        }
        return [now()->subDays($option),now()];
    }

    public function render()
    {
        return view('livewire.admin.dashboard.users');
    }
}
