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

    public function success($message, $title = 'Success')
    {
        $this->toast('success', $message, $title);
    }

    public function error($message, $title = 'Error')
    {
        $this->toast('error', $message, $title);
    }

    public function info($message, $title = 'Info')
    {
        $this->toast('info', $message, $title);
    }

    public function warning($message, $title = 'Warning')
    {
        $this->toast('warning', $message, $title);
    }
}
