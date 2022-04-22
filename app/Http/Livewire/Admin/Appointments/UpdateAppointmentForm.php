<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Models\Appointment;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UpdateAppointmentForm extends Component {
	public $state = [];
	public $appointment;

	public function mount(Appointment $appointment) {
		$this->state = $appointment->toArray();
		$this->appointment = $appointment;
	}

	public function updateAppointment(Appointment $appointment) {
		Validator::make($this->state, [
			'client_id' => 'required|exists:clients,id',
			'time'      => 'required',
			'date'      => 'required',
			'note'      => 'nullable',
			'status'    => 'required|in:scheduled,closed',
		])->validate();
		$this->appointment->update($this->state);
		//		$this->formReset();
		session()->flash('msg', 'Appointment update');
		return redirect()->route('admin.appointments');
	}

	public function render() {
		$clients = Client::all();

		return view('livewire.admin.appointments.update-appointment-form', [
			'clients' => $clients,
		]);
	}
}
