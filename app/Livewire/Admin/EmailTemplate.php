<?php

namespace App\Livewire\Admin;

use App\Models\NotifyTemplate;
use App\Traits\LivewireToast;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.layouts.app')]
class EmailTemplate extends Component
{
    use LivewireToast;
    use WithPagination;

    public $view;

    public $perPage = 20;

    public $search = '';

    public $sortField = 'created_at';

    public $sortDirection = 'desc';

    public $templateId;

    public $title;

    public $email_status;

    public $content;

    public $subject;

    public $shortcodes = [];

    public $name;

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetForm(): void
    {
        $this->reset([
            'templateId',
            'title',
            'subject',
            'content',
            'email_status',
            'shortcodes',
            'name',
        ]);
        $this->resetErrorBag();
    }

    public function updated($property): void
    {
        if ($property === 'view' && $this->view === 'edit') {
            $this->dispatch('editorReinitialize');
        }
    }

    public function showEdit($id): void
    {
        $this->resetForm();

        $template = NotifyTemplate::findOrFail($id);
        $this->templateId = $template->id;
        $this->title = $template->title;
        $this->email_status = $template->email_status;
        $this->content = $template->content;
        $this->subject = $template->subject;
        $this->name = $template->name;
        $this->shortcodes = $template->shortcodes;
        $this->view = 'edit';
        $this->title = 'Edit Template';

        $this->dispatch('editorReinitialize');
    }

    public function save(): void
    {
        $this->validate([
            'subject' => 'required',
            'content' => 'required',
        ]);

        $template = NotifyTemplate::findOrFail($this->templateId);
        $template->update([
            'subject' => $this->subject,
            'email_status' => $this->email_status,
            'content' => $this->content,
        ]);

        $this->redirect(route('admin.email.templates'), navigate: true);
        $this->successAlert('Template updated successfully');
    }

    public function backToList(): void
    {
        $this->view = 'list';
        $this->resetForm();
    }

    public function mount($id = null): void
    {
        if ($id) {
            $this->view = 'edit';
            $this->showEdit($id);
        } else {
            $this->view = 'list';
        }
    }

    protected $listeners = [
        'editorContentChanged' => 'updateContent',
    ];

    public function updateContent($content): void
    {
        $this->content = $content;
    }

    public function render()
    {
        $templates = [];

        if ($this->view === 'list') {
            $this->title = 'Email Templates';
            $templates = NotifyTemplate::when($this->search, function ($query): void {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('type', 'like', '%' . $this->search . '%')
                    ->orWhere('subject', 'like', '%' . $this->search . '%');
            })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage);
        }

        return view('livewire.admin.email-template', [
            'templates' => $templates,
            'title' => $this->title,
        ]);
    }
}
