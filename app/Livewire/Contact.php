<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use App\Models\NotifyTemplate;
use App\Services\NotificationService;
use App\Traits\LivewireToast;
use Livewire\Component;
use Purify;

class Contact extends Component
{
    use LivewireToast;

    public $name;

    public $email;

    public $message;


    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $data = Purify::clean([
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ]);

        $contact = ContactMessage::create($data);

        // send email
        $this->sendEmail($contact);

        $this->reset(['name', 'email', 'message']);

        $this->successAlert('Message sent successfully');
    }

    function sendEmail(ContactMessage $contact)
    {
        $template = NotifyTemplate::whereType('ADMIN_CONTACT_FORM')->first();
        $ns = app(NotificationService::class);
        if ($template) {
            $data = [
                'subject' => $template->subject,
                'content' => $template->message,
            ];
            $shortcodes = [
                'sender_name' => $contact->name,
                'sender_email' => $contact->email,
                'message_subject' => $contact->subject,
                'message_content' => $contact->message,
            ];
            $ns->sendManualEmail(get_setting('admin_email'), $data, $shortcodes);
        }
    }

    public function render()
    {
        return view('livewire.contact');
    }
}
