<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
        <div class="inner d-flex justify-content-between m-2">
            <h3>{{ $appointmentsCount }}</h3>
            <x-animations.ballet />
            <select wire:change="getAppointmentCount($event.target.value)" class="form-control-sm px-1 rounded btn btn-outline-light m-2">
                <option value="">All</option>
                <option value="scheduled">Scheduled</option>
                <option value="closed">Closed</option>
            </select>
        </div>
        {{-- <p class="p-2 m-2">Appointments</p> --}}
        <div class="icon">
            <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('admin.appointments')}}" class="small-box-footer">Appointments &nbsp; <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>