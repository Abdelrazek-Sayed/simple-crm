<?php

namespace App\Http\Livewire\Admin\Dashboard;

 

use App\Models\Appointment;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $appointmentsCount;

    public function mount()
    {
       $this->getAppointmentCount();
    }

    public function getAppointmentCount($status = null)
    {
        $this->appointmentsCount  = Appointment::query()->when($status,function($query,$status){
            $query->where('status',$status);
        })->count();
    }
   
    public function render()
    {
        return view('livewire.admin.dashboard.dashboard');
    }
}
