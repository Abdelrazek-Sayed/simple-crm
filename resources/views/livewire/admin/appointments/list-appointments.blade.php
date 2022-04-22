<div>
    <x-loader />
    {{-- header --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Appointments Page</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Appointments</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    {{-- content --}}
    <div class="content">
        <div class="container-fluid">
            @if (session()->has('msg'))
            <div class="alert alert-success" role="alert">
                {{session('msg')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> &times;</button>
            </div>
            @endif
            <div class="d-flex justify-content-between mb-2">
                <a class="btn btn-info" href="{{ route('admin.appointments.create')}}"> <i class="fa fa-plus mr-1"></i>
                    Add Appointment</a>

                    @if ($selectedRows)
                    <div class="btn-group">
                        <button type="button" class="btn btn-default">Bulk Actions</button>
                        <button type="button" class="btn btn-default dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                            <div class="dropdown-menu" role="menu">
                                <a wire:click.prevent="deleteAllSelected" class="dropdown-item" href="#">Delete Selected</a>
                                <a wire:click.prevent="updateAllSelectedAsScheduled" class="dropdown-item" href="#">Mark As Scheduled</a>
                                <a wire:click.prevent="updateAllSelectedAsClosed" class="dropdown-item" href="#">Mark As Closed</a>
                            </div>
                        </button>
                    </div>
                    <span class="btn btn-info"> Selected <span class="badge badge-warning"> {{ count($selectedRows)}} </span>  {{ Str::plural('Appointment', $selectedRows) }} </span>                        
                    @endif

                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button wire:click="filterAppointmentByStatus" type="button" class="btn border {{ is_null($status) ? 'btn-secondary' : 'btn-default' }} ">All<span class="badge badge-success m-1">{{ $appointmentsCount}}</span></button>
                    <button wire:click="filterAppointmentByStatus('scheduled')" type="button" class="btn border {{ $status === 'scheduled' ? 'btn-secondary' : 'btn-default'   }}">Scheduled<span class="badge badge-info m-1">{{ $scheduledAppointmentsCount}}</span></button>
                    <button wire:click="filterAppointmentByStatus('closed')" type="button" class="btn border {{ $status === 'closed' ?  'btn-secondary' : 'btn-default' }}">closed<span class="badge badge-danger m-1">{{ $closedAppointmentsCount}}</span></button>
                </div>


            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <div class="icheck-primary d-inline ml-2">
                                                <input wire:model="selecteAllRows" type="checkbox" value="" name="todo2" id="todoCheck2">
                                                <label for="todoCheck2"></label>
                                            </div>

                                        </th>
                                        <th>#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointments as $appointment)

                                    <tr>
                                        <th scope="row">
                                            <div class="icheck-primary d-inline ml-2 mr-2" wire.ignore.self>
                                                <input wire:model="selectedRows" type="checkbox" value="{{$appointment->id}}" name="todo2" id="{{$appointment->id}}">
                                                <label for="{{$appointment->id}}"></label>
                                            </div>
                                        </th>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{$appointment->client->name}}</td>
                                        <td>{{$appointment->date}}</td>
                                        <td>{{$appointment->time}}</td>
                                        <td>
                                            <span class="badge badge-{{$appointment->status_badge}}"> {{$appointment->status}} </span>
                                        </td>
                                        <td>
                                            <a href="{{route('admin.appointments.edit',$appointment)  }}"> <i class="fa fa-edit text-success mr-2"></i></a>
                                            <a href="" wire:click.prevent="confirmDelete({{$appointment->id}})"> <i class="fa fa-trash text-danger"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- @dump($selectedRows) --}}
                            <div class="card-footer d-flex justify-content-end">
                                {{ $appointments->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


    <x-delete-confirmation />
</div>
