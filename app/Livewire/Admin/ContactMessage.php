<?php

namespace App\Livewire\Admin;

use App\Models\ContactMessage as ModelsContactMessage;
use App\Traits\LivewireToast;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('admin.layouts.app')]
class ContactMessage extends Component
{
    use LivewireToast;

    public $searchTerm = '';

    public $perPage = 25;

    public $viewingContactMessage;

    // meta
    public string $metaTitle = 'Contact Messages';

    public function mount()
    {
        $this->deleteOldContacts();
    }

    public function deleteOldContacts()
    {
        $old = ModelsContactMessage::where('created_at', '<', now()->subDays(30))->delete();
        if ($old) {
            $this->toast('success', 'Old contacts deleted successfully');
        }
    }

    public function view($id)
    {
        $this->viewingContactMessage = ModelsContactMessage::findOrFail($id);

    }

    public function closeView()
    {
        $this->viewingContactMessage = null;
    }

    public function delete($id)
    {
        $contactmessage = ModelsContactMessage::findOrFail($id);
        $contactmessage->delete();
        $this->toast('success', 'Contact message deleted successfully');
    }

    public function render()
    {
        $contactmessages = ModelsContactMessage::query()->latest()
            ->when($this->searchTerm, function ($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            })
            ->paginate($this->perPage);

        return view('livewire.admin.contact-message', compact('contactmessages'));
    }
}
