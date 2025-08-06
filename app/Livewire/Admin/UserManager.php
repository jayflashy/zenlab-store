<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Traits\LivewireToast;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('admin.layouts.app')]
class UserManager extends Component
{
    use LivewireToast;
    use WithPagination;
    public $search = '';

    public $emailVerifiedFilter = '';
    public $statusFilter = '';
    public $sortField = 'created_at';

    public $sortDirection = 'desc';

    public $perPage = 50;

    // meta
    public string $metaTitle = "Manage Users";
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingCountryFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->emailVerifiedFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('username', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->emailVerifiedFilter !== '', function ($query) {
                if ($this->emailVerifiedFilter == '1') {
                    $query->whereNotNull('email_verify');
                } else {
                    $query->whereNull('email_verify');
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
            
        return view('livewire.admin.user-manager', compact('users'));
    }
}
