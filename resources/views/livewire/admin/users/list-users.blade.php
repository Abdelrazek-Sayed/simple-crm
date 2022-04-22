<div>
    {{-- header --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Users Page</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                <button class="btn btn-info" wire:click.prevent="ShowModal"><i class="fa fa-plus mr-1"></i> Add New User
                </button>
                <x-user-search wire:model="search" />
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Registration Date</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @forelse ($users as $user)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->created_at->toFormatDate()}}</td>

                                        <td>
                                        <select class="form-control" wire:change="changeRole({{$user}},$event.target.value)">
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : ''}}>Admin</option>    
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : ''}}>User</option>    
                                        </select>    
                                        </td>
                                        
                                        <td>

                                            <img src="{{ $user->image_url }}" class="img img-circle" height="70" width="70">
                                        </td>
                                        <td>
                                            <a href="" wire:click.prevent="edit({{$user->id}})"> <i class="fa fa-edit text-success mr-2"></i></a>
                                            <a href="" wire:click.prevent="confirmDelete({{$user->id}})"> <i class="fa fa-trash text-danger"></i></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="text-center text-danger">
                                        <td colspan="5">
                                            <img src="{{asset('images/not_found.svg')}}" height="150px" width="100px" alt="">
                                            <h3> No Result Found</h3>

                                        </td>
                                    </tr>
                                    @endforelse

                                </tbody>
                            </table>
                            <div class="card-footer d-flex justify-content-end">
                                {{ $users->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Modal -->
    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($showEditModal)
                    <h5 class="modal-title" id="exampleModalLabel">Edit user</h5>

                    @else
                    <h5 class="modal-title" id="exampleModalLabel">Add new user</h5>

                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> &times;</button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="{{ $showEditModal ? 'updateUser' : 'createUser' ;}}">
                        <div class="form-group">

                            <label for="name" lass="form-label">Name</label>
                            <input type="text" wire:model.defer="name" class="form-control" id="name">
                        </div>
                        @error('name')
                        <span class="text-danger">
                            {{ $message}}
                        </span>
                        @enderror
                        <div class="form-group">
                            <label for="" class="form-label">Email</label>
                            <input type="email" wire:model.defer="email" class="form-control" id="">
                            @error('email') <span class="text-danger"> {{ $message}} </span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" wire:model.defer="password" class="form-control" id="password">
                            @error('password')
                            <span class="text-danger">
                                {{ $message}}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Password Confirmation</label>
                            <input type="password" class="form-control" wire:model.defer="password_confirmation" id="password_confirmation">
                            @error('password_confirmation')
                            <span class="text-danger">
                                {{ $message}}
                            </span>
                            @enderror
                        </div>


                        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <!-- File Input -->

                            <div class="form-group">
                                <label for="file" class="form-label">Image</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" wire:model="image" id="file">
                                    <label class="custom-file-label" for="">
                                        @if ($image) {{ $image->getClientOriginalName() }} @else select image @endif</label>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div x-show.transition="isUploading" class="progress progress-sm rounded">
                                <div x-bind:style="`width:${progress}%`" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" ></div>
                            </div>

                            <div class="row">
                                @if ($user_image)
                                <div class="form-group">
                                    <div class="flex m-2 rounded-md">
                                        <span>
                                            <img src="{{ asset("storage/images/$this->user_image") }}" width="200" style="height: 100px" class="mt-4 mb-4 border rounded">
                                        </span>
                                    </div>
                                </div>
                                @endif

                                @if ($image)
                                <div class="form-group">
                                    <div class="rounded-md m-2 justify-content-center">
                                        <span>
                                            <img src="{{ $image->temporaryUrl() }}" width="200" style="height: 100px" class="mt-4 mb-4 border rounded ">
                                        </span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                       


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-2"></i> cancel
                            </button>
                            @if ($showEditModal)
                            <button type="submit" wire:click.prevent="updateUser" class="btn btn-warning"><i class="fa fa-edit mr-2"></i> Edit
                            </button>
                            @else
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i> Save
                            </button>
                            @endif
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>


    <!-- Delete Modal -->
    <div class="modal fade" id="cofirm_delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> &times;</button>
                </div>
                <div class="modal-body">
                    <h4>Are You Sure ? </h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-2"></i> cancel
                    </button>
                    <button type="button" wire:click.prevent="delete" class="btn btn-warning"><i class="fa fa-trash mr-2"></i> Delete
                    </button>
                </div>


            </div>
        </div>
    </div>

</div>
@push('js')
<script>
    window.addEventListener('user_updated', event => {
        const Toast = Swal.mixin({
            toast: true
            , position: 'top-end'
            , showConfirmButton: false
            , timer: 3000
            , timerProgressBar: true
            , didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'success'
            , title: event.detail.message
        })
    });

</script>
@endpush
