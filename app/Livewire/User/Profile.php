<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Traits\LivewireToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Storage;

#[Layout('user.layouts.app')]
class Profile extends Component
{
    use LivewireToast;
    use WithFileUploads;

    // User information properties
    public $user;
    public $name;
    public $username;
    public $email;
    public $phone;
    public $country;

    // Profile image
    public $image;
    public $imageUrl;

    // Password change properties
    public $current_password;
    public $new_password;
    public $confirm_password;

    // Notification settings
    public $update_notify = false;
    public $trx_notify = false;

    // Validation rules for profile update
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $this->user->id,
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2024', // 1MB Max
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadUserData();
    }

    public function loadUserData()
    {
        $this->name = $this->user->name;
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->country = $this->user->country;
        $this->imageUrl = $this->user->image ? my_asset($this->user->image) : my_asset('users/default.jpg');

        // Load notification settings
        $this->update_notify = $this->user->update_notify ?? false;
        $this->trx_notify = $this->user->trx_notify ?? false;
    }

    public function updateProfile()
    {
        $this->validate();

        try {
            // Process image upload if provided
            if ($this->image) {

                $imagePath = Storage::disk('uploads')->putFile('users', $this->image);

                if ($this->user->image && !str_contains($this->user->image, 'default.jpg')) {
                    Storage::disk('uploads')->delete($this->user->image);
                }
                $this->user->image = $imagePath;
            }

            // Update user details
            $this->user->name = $this->name;
            $this->user->username = $this->username;
            $this->user->email = $this->email;
            $this->user->phone = $this->phone;
            $this->user->country = $this->country;
            $this->user->save();

            $this->imageUrl = $this->user->image ? my_asset($this->user->image) : my_asset('users/default.jpg');
            $this->image = null;

            $this->toast('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            $this->toast('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|different:current_password',
            'confirm_password' => 'required|same:new_password',
        ]);

        try {
            // Check if current password is correct
            if (!Hash::check($this->current_password, $this->user->password)) {
                $this->toast('error', 'Current password is incorrect');
                return;
            }

            // Update password
            $this->user->password = Hash::make($this->new_password);
            $this->user->save();

            // Reset password fields
            $this->reset(['current_password', 'new_password', 'confirm_password']);

            $this->toast('success', 'Password updated successfully!');
        } catch (\Exception $e) {
            $this->toast('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function updateNotifications()
    {
        try {
            $this->user->update_notify = $this->update_notify;
            $this->user->trx_notify = $this->trx_notify;
            $this->user->save();

            $this->toast('success', 'Notification settings updated!');
        } catch (\Exception $e) {
            $this->toast('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.user.profile');
    }
}
