<?php

namespace App\Http\Livewire\Admin\Appointments;


use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Appointment;

class ListAppointments extends AdminComponent
{
  protected $listeners = ['delete_appointment' => 'deleteAppointment'];
  public $appointment_id, $status, $selectedRows = [],
    $selecteAllRows = false;

  protected $queryString = ['status'];


  public function updatedSelecteAllRows($value)
  {
    if ($value) {
      $this->selectedRows = $this->appointments->pluck('id')->map(function ($id) {
        return (string) $id;
      });
    } else {
      $this->reset(['selectedRows','selecteAllRows']);
    }
  }
  public function getAppointmentsProperty()
  {
    return Appointment::when($this->status, function ($query, $status) {
      $query->where('status', $status);
    })->latest()->paginate(5);
  }

  public function deleteAllSelected()
  {
     Appointment::whereIn('id',$this->selectedRows)->delete();
     $this->dispatchBrowserEvent('appointment_deleted', ['message' => 'All selected Appointment deleted Successfully']);
  }


  public function updateAllSelectedAsScheduled()
  {
     Appointment::whereIn('id',$this->selectedRows)->update(['status'=> 'scheduled']);
     $this->dispatchBrowserEvent('appointment_deleted', ['message' => 'All selected Appointment updated Successfully']);
  }

  public function updateAllSelectedAsClosed()
  {
     Appointment::whereIn('id',$this->selectedRows)->update(['status'=> 'closed']);
     $this->dispatchBrowserEvent('appointment_deleted', ['message' => 'All selected Appointment updated Successfully']);
  }

  public function confirmDelete($appointment_id)
  {
    $this->appointment_id = $appointment_id;
    $this->dispatchBrowserEvent('appointment_delete_confirmation', ['message' => 'Confirm delete']);
  }


  public function deleteAppointment()
  {
    Appointment::findOrFail($this->appointment_id)->delete();
    $this->dispatchBrowserEvent('appointment_deleted', ['message' => 'Appointment deleted Successfully']);
  }

  

  public function filterAppointmentByStatus($status = null)
  {
    $this->status = $status;
  }


  public function render()
  {
    $appointments = $this->appointments;

    $appointmentsCount = Appointment::count();
    $scheduledAppointmentsCount = Appointment::where('status', 'scheduled')->count();
    $closedAppointmentsCount = Appointment::where('status', 'closed')->count();

    return view('livewire.admin.appointments.list-appointments', [
      'appointments' => $appointments,
      'appointmentsCount' => $appointmentsCount,
      'scheduledAppointmentsCount' => $scheduledAppointmentsCount,
      'closedAppointmentsCount' => $closedAppointmentsCount,
    ]);
  }
}
