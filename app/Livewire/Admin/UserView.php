<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Traits\LivewireToast;
use Livewire\Component;
use Livewire\Attributes\Layout;

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

    // Password change properties
    public $current_password;

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
        $this->metaTitle = $this->user->name . " Details";
        $this->loadUserData();
        $this->loadCountryList();
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
        $this->purchases_count = $this->user->purchasesCount();
    }


    public function setTab($tab)
    {
        $this->tab = $tab;
    }
    private function loadCountryList()
    {
        $countryJson = static_asset('countries.json');
        $this->countries = json_decode(file_get_contents($countryJson), true);
    }

    public function render()
    {
        return view('livewire.admin.user-view');
    }
}
