<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
// use Livewire\Component;
// use Livewire\WithPagination;
use App\Http\Livewire\Admin\AdminComponent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ListUsers extends AdminComponent
{

    public $name, $email, $password,  $password_confirmation, $user, $user_id, $search, $image, $user_image;
    public $showEditModal = false;

    public function ShowModal()
    {
        $this->showEditModal = false;
        $this->formReset();
        $this->dispatchBrowserEvent('show-form');
    }

    public function createUser()
    {
        $validatedDate = $this->validate([
            'name'         => 'required',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|confirmed',
            'image'        => 'nullable',
        ]);
        if ($this->image) {
            $validatedDate['image'] = $this->image->store('/users', 'images');
        }

        User::create($validatedDate);
        $this->dispatchBrowserEvent('hide-form');

        $this->formReset();
        session()->flash('msg', 'user created');
        return back();
    }



    public function edit(User $user)
    {
        $this->formReset();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
        $this->name  = $user->name;
        $this->email  = $user->email;
        $this->user  = $user;
        $this->user_image  = $user->image;
    }

    protected $append = ['image_url'];

    public function updateUser()
    {
        $validatedDate = $this->validate([
            'name'         => 'required',
            'email'        => 'required|email|unique:users,email,' . $this->user->id,
            'password'     => 'sometimes|confirmed',
            'image'        => 'nullable',
        ]);

        if ($this->image) {
            Storage::disk('images')->delete($this->user->image);
            $validatedDate['image'] = $this->image->store('/users', 'images');
        } else {
            $validatedDate['image'] = $this->user->image;
        }
        if ($validatedDate['password'] == null) {
            $validatedDate['password'] = $this->user->password;
        }
        $this->user->update($validatedDate);
        $this->dispatchBrowserEvent('hide-form');

        $this->formReset();
        // session()->flash('msg', 'user updated');
        $this->dispatchBrowserEvent('user_updated', ['message' => 'user updated Successfully']);
        $this->showEditModal = false;
        return back();
    }


    public function confirmDelete($user_id)
    {
        $this->dispatchBrowserEvent('show-delete-modal');
        $this->user_id = $user_id;
    }

    public function delete()
    {
        User::findOrFail($this->user_id)->delete();
        $this->dispatchBrowserEvent('hide-delete-modal');
        session()->flash('msg', 'user deleted');
    }


    public function formReset()
    {
        return [
            $this->name = null,
            $this->email = null,
            $this->password = null,
            $this->image = null,
            $this->user_image = null,
            $this->password_confirmation = null,
        ];
    }

    public function changeRole(User $user, $role)
    {
        Validator::make(['role' => $role], [
            'role' => [
                'required',
                Rule::in(User::ROLE_ADMIN, User::ROLE_USER),
            ],
            // 'role' => 'required|in:admin,user',
        ])->validate();
        $user->update(['role' => $role]);
        $this->dispatchBrowserEvent('user_updated', ['message' => "Role updated to  $role Successfully"]);
    }
    public function render()
    {

        if ($this->search) {
            sleep(1);
            $users = User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->latest()->paginate(20);
        } else {
            $users = User::latest()->paginate(5);
        }
        return view('livewire.admin.users.list-users', [
            'users' => $users,
        ]);
    }
}
