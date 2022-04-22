<div class="content">
    <div class="container-fluid">
        @if (session()->has('msg'))
            <div class="alert alert-success" role="alert">
                {{session('msg')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> &times;</button>
            </div>
        @endif
        <div class="col-md-12">
            <form wire:submit.prevent="createAppointment" autocomplete="off">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">New Appontment</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Client : </label>
                                    <select wire:model.defer="state.client_id" class="form-control select2"
                                            style="width: 100%;">
                                        <option selected="selected">Select Client</option>
                                        @foreach ($clients as $client)
                                            <option value="{{$client->id}}">{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('client_id')  <span class="text-danger"> {{ $message}} </span>  @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status : </label>
                                    <select wire:model.defer="state.status" class="form-control select2"
                                            style="width: 100%;">
                                        <option selected="selected">Select Status</option>
                                        <option value="scheduled">scheduled</option>
                                        <option value="closed">closed</option>
                                    </select>
                                </div>
                                @error('status')  <span class="text-danger"> {{ $message}} </span>  @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Date -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date:</label>
                                    <div wire:ignore class="input-group date" id="reservationdate"
                                         data-target-input="nearest" data-appointmentdate="@this">
                                        <input type="text" class="form-control datetimepicker-input"
                                               data-target="#reservationdate" id="appointment_input_id"/>
                                        <div class="input-group-append" data-target="#reservationdate"
                                             data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                @error('date')  <span class="text-danger"> {{ $message}} </span>  @enderror
                            </div>
                            <!-- /.form group -->


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Time </label>
                                    <div wire:ignore class="input-group date" id="timepicker"
                                         data-target-input="nearest" data-appointmenttime="@this">
                                        <input type="text" class="form-control datetimepicker-input"
                                               data-target="#timepicker" id="time_input_id"/>
                                        <div class="input-group-append" data-target="#timepicker"
                                             data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                        </div>
                                    </div>
                                </div>
                                @error('time')  <span class="text-danger"> {{ $message}} </span>  @enderror
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12  form-group">
                                <label>Note :</label>
                                <textarea id="note" data-note="@this" wire:model.defer="state.note"
                                          class="form-control select2"
                                          style="width: 100%;" placeholder="Place some text here"></textarea>
                            </div>
                            @error('note')  <span class="text-danger"> {{ $message}} </span>  @enderror
                        </div>

                        <div class="row">
                            <div class="d-flex justify-content-end m-3">
                                <button type="submit" id="submit" class="btn btn-success btn-sm"><i
                                            class="fas fa-save mr-2"></i>
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            $('#reservationdate').on('change.datetimepicker', function (e) {
                let date = $(this).data('appointmentdate');
                eval(date).set('state.date', $('#appointment_input_id').val());
            });

            $('#timepicker').datetimepicker({
                format: 'LT',
            });

            $('#timepicker').on('change.datetimepicker', function (e) {
                let time = $(this).data('appointmenttime');
                eval(time).set('state.time', $('#time_input_id').val());
            });
        });
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#note'))
            .then(editor => {
                    document.querySelector('#submit').addEventListener('click', () => {
                        let note = $('#note').data('note');
                        eval(note).set('state.note', editor.getData());
                    });
                }
            ).catch(error => {
            console.error(error);
        });
    </script>
@endpush

