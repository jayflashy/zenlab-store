<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Traits\LivewireToast;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Storage;

#[Layout('admin.layouts.app')]
class UserView extends Component
{
    use LivewireToast;

    public User $user;

    public $name;

    public $username;

    public $email;

    public $phone;

    public $country;

    // Profile image
    public $image;

    public $imageUrl;

    public $new_password;

    public $confirm_password;

    // Notification settings
    public $update_notify = false;

    public $trx_notify = false;

    public $tab = 'statistics';

    public $countries;

    public $purchases_count;

    // meta
    public string $metaTitle;

    public function mount($id)
    {
        $this->user = User::findOrFail($id);
        // set meta
        $this->metaTitle = $this->user->name . ' Details';
        $this->loadUserData();
        $this->loadCountryList();
    }

    public function loadUserData()
    {
        $this->name = $this->user->name;
        $this->username = generateUsername($this->user->username);
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->country = $this->user->country;
        $this->imageUrl = $this->user->image ? my_asset($this->user->image) : my_asset('users/default.jpg');

        // Load notification settings
        $this->update_notify = $this->user->update_notify ?? false;
        $this->trx_notify = $this->user->trx_notify ?? false;
        $this->purchases_count = $this->user->purchasesCount();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|alpha_dash|unique:users,username,' . $this->user->id,
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ];
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'nullable|image|max:2048', // max ~2MB
        ]);

        try {
            $imagePath = Storage::disk('uploads')->putFile('users', $this->image);

            if ($this->user->image && ! str_contains((string) $this->user->image, 'default.jpg')) {
                Storage::disk('uploads')->delete($this->user->image);
            }

            $this->user->image = $imagePath;
            $this->user->save();

            $this->imageUrl = $this->user->image ? my_asset($this->user->image) : my_asset('users/default.jpg');
            $this->image = null;

            $this->toast('success', 'Profile picture updated!');
        } catch (Exception $exception) {
            $this->toast('error', 'Image upload failed: ' . $exception->getMessage());
        }
    }

    public function updatePassword()
    {

        try {
            $this->validate([
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password',
            ]);

            // Update password
            $this->user->password = $this->new_password;
            $this->user->save();

            // Reset password fields
            $this->reset(['new_password', 'confirm_password']);
            $this->toast('success', 'Password updated successfully!');
        } catch (ValidationException $e) {
            foreach ($e->validator->errors()->all() as $error) {
                $this->toast('error', $error);
            }

            throw $e;
        } catch (\Exception $e) {
            $this->toast('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function updateProfile()
    {
        $this->validate();

        try {
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
        } catch (\Exception $exception) {
            $this->toast('error', 'An error occurred: ' . $exception->getMessage());
        }
    }

    public function updateNotifications()
    {
        try {
            $this->user->update_notify = $this->update_notify;
            $this->user->trx_notify = $this->trx_notify;
            $this->user->save();

            $this->toast('success', 'Notification settings updated!');
        } catch (Exception $exception) {
            $this->toast('error', 'An error occurred: ' . $exception->getMessage());
        }
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
    }

    private function loadCountryList()
    {
        $this->countries = cache()->remember('country_list', 86400, function () {
            $countryJson = static_asset('countries.json');

            if (! file_exists($countryJson)) {
                \Log::error('Countries JSON file not found: ' . $countryJson);

                return [];
            }

            $content = file_get_contents($countryJson);

            return json_decode($content, true) ?: [];
        });
    }

    public function render()
    {
        return view('livewire.admin.user-view');
    }
}
