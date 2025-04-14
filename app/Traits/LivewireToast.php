<?php

namespace App\Traits;

trait LivewireToast
{
    public function toast($type, $message, $title = '')
    {
        $this->dispatch('alert', [
            'type' => $type,
            'message' => $message,
            'title' => $title,
        ]);
    }

    public function successAlert($message, $title = 'Success')
    {
        $this->toast('success', $message, $title);
    }

    public function errorAlert($message, $title = 'Error')
    {
        $this->toast('error', $message, $title);
    }

    public function infoAlert($message, $title = 'Info')
    {
        $this->toast('info', $message, $title);
    }

    public function warningAlert($message, $title = 'Warning')
    {
        $this->toast('warning', $message, $title);
    }
}
