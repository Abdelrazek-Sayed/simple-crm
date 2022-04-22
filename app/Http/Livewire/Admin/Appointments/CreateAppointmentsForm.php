<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Models\Appointment;
use App\Models\Client;
use App\Http\Livewire\Admin\AdminComponent;
use Illuminate\Support\Facades\Validator;

class CreateAppointmentsForm extends AdminComponent {
	public $state = [];

	public function createAppointment() {
		Validator::make($this->state, [
			'client_id' => 'required|exists:clients,id',
			'time'      => 'required',
			'date'      => 'required',
			'note'      => 'nullable',
			'status'    => 'required|in:scheduled,closed',
		])->validate();
		Appointment::create($this->state);
		$this->formReset();
		session()->flash('msg', 'Appointment created');
	}

	public function formReset() {
		return $this->state = [];
	}

	public function render() {
		$clients = Client::paginate(5);

		return view('livewire.admin.appointments.create-appointments-form', [
			'clients' => $clients,
		]);
	}
}
