<?php

namespace App\Traits;

trait LivewireToast
{
    public function toast($type, $message, $title = ''): void
    {
        $this->dispatch('alert', [
            'type' => $type,
            'message' => $message,
            'title' => $title,
        ]);
    }

    public function successAlert($message, $title = 'Success'): void
    {
        $this->toast('success', $message, $title);
    }

    public function errorAlert($message, $title = 'Error'): void
    {
        $this->toast('error', $message, $title);
    }

    public function infoAlert($message, $title = 'Info'): void
    {
        $this->toast('info', $message, $title);
    }

    public function warningAlert($message, $title = 'Warning'): void
    {
        $this->toast('warning', $message, $title);
    }
}
