<?php

namespace App\Livewire\Admin;

use App\Traits\LivewireToast;
use Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('admin.layouts.app')]
class Profile extends Component
{
    use LivewireToast;
    public $name;
    public $email;
    public $phone;
    public $password;

    // meta
    public string $metaTitle = "Admin Profile";

    function mount()
    {
        $admin = Auth::guard('admin')->user();

        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->phone = $admin->phone;
    }

    function save()
    {
        $admin = Auth::guard('admin')->user();
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'phone' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);
        $admin->name = $this->name;
        $admin->email = $this->email;
        $admin->phone = $this->phone;

        if ($this->password != null) {
            $admin->password = bcrypt($this->password);
        }
        /**
         * @var \App\Models\Admin $admin
         */
        $admin->save();
        $this->successAlert('Profile updated successfully');
    }
    public function render()
    {
        return view('livewire.admin.profile');
    }
}
