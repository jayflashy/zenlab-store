<?php

namespace App\Services;

use App\Mail\SendMail;
use App\Models\Admin;
use App\Models\NotifyTemplate;
use App\Models\User;
use Cache;
use InvalidArgumentException;
use Mail;

class NotificationService
{
    private $templates;

    public function __construct()
    {
        $this->templates = Cache::remember('NotifyTemplates', 60 * 60, function () {
            return NotifyTemplate::all();
        });
    }

    /**
     * Send notification based on type
     */
    public function send(string $type, User $user, array $shortcodes = [], $customData = [])
    {
        try {
            $template = $this->getTemplate($type);

            if (! $template) {
                throw new InvalidArgumentException("Template {$type} not found");
            }

            // Send Email Notification
            if ($template->email_status == 1) {
                $this->sendEmail($user, $template, $shortcodes, $customData);
            }

            // other channels

            return true;
        } catch (\Exception $e) {
            \Log::error('Notification failed', [
                'type' => $type,
                'user' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Send custom notification to a user
     *
     * @param  array  $customData
     * @return bool
     */
    public function sendCustom(User $user, array $data, array $channels = [], $customData = [])
    {
        try {
            $shortcodes = [
                'name' => $user->name,
                'first_name' => $user->first_name,
                'email' => $user->email,
            ];
            $template = $data;

            // Send Email Notification
            if (in_array('email', $channels)) {
                $this->sendEmail($user, $template, $shortcodes);
            }

            return true;
        } catch (\Exception $e) {
            \Log::error('Notification failed', [
                'type' => 'custom',
                'user' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Send bulk notifications
     */
    public function sendBulk(string $type, $users, array $shortcodes = []): array
    {
        $results = [];
        foreach ($users as $user) {
            $results[$user->id] = $this->send($type, $user, $shortcodes);
        }

        return $results;
    }

    /**
     * Get template and validate
     */
    private function getTemplate(string $type): ?NotifyTemplate
    {
        return collect($this->templates)
            ->firstWhere('type', $type);
    }

    /**
     * Replace shortcodes in template
     */
    private function replaceShortcodes($template, array $shortcodes): array
    {
        $replacements = array_merge($this->defaultShortcodes(), $shortcodes);  // combine shortcodes

        return [
            'subject' => $this->replaceText($template['subject'] ?? '', $replacements),
            'content' => $this->replaceText($template['content'] ?? '', $replacements),
            'name' => $shortcodes['name'] ?? '',
            'title' => $this->replaceText($template['title'] ?? '', $replacements),
            'message' => $this->replaceText($template['message'] ?? '', $replacements),
        ];
    }

    /**
     * Replace text with data
     */
    private function replaceText(string $text, array $replacements): string
    {
        // return preg_replace_callback(
        //     '/{{([^}]+)}}/',
        //     fn($match) => $replacements[$match[1]] ?? $match[0],
        //     $text
        // );
        $text = preg_replace_callback(
            '/\{\{\s*(\w+)\s*\}\}/',
            function ($match) use ($replacements) {
                $key = $match[1];

                return $replacements[$key] ?? $match[0];
            },
            $text
        );

        // Then replace {key} pattern
        $text = preg_replace_callback(
            '/\{\s*(\w+)\s*\}/',
            function ($match) use ($replacements) {
                $key = $match[1];

                return $replacements[$key] ?? $match[0];
            },
            $text
        );

        return $text;
    }

    /**
     * Default system shortcodes.
     *
     * @return array
     */
    private function userShortcodes($user = null)
    {
        return [
            'username' => $user->username ?? '',
            'email' => $user->email ?? '',
            'phone' => $user->phone ?? '',
            'name' => $user->name ?? '',
            'role' => $user->role ?? '',
        ];
    }

    /**
     * Default system shortcodes.
     *
     * @return array
     */
    private function defaultShortcodes()
    {
        $settings = get_setting();

        return [
            'site_name' => $settings->name,
            'site_email' => $settings->email,
            'site_phone' => $settings->phone,
            'support_email' => $settings->email,
            'currency' => $settings->currency,
            'site_address' => $settings->address,
            'date' => date('Y-m-d'),
            'datetime' => date('Y-m-d H:i:s'),
            'time' => date('H:i:s'),
        ];
    }

    /**
     * Send email notification.
     *
     * @param  User|array|int  $users
     * @param  NotificationTemplate  $template
     * @param  array  $shortcodes
     */
    private function sendEmail($user, $template, $shortcodes, $customData = [])
    {
        $shortcodes = array_merge($this->defaultShortcodes(), $shortcodes);  // combine shortcodes
        $subject = $this->replaceText($template['subject'], $shortcodes);
        $content = $this->replaceText($template['content'], $shortcodes);

        if (! $user->email) {
            return;
        }
        $data['subject'] = $subject;
        $data['message'] = $content;
        $data = array_merge($data, $customData);
        try {
            Mail::to($user->email)->queue(new SendMail($data));
        } catch (\Exception $e) {
            \Log::error($e);
        }
    }

    /**
     * Send notification based on type
     */
    public function sendAdmin(string $type, array $shortcodes = [], $customData = [])
    {
        try {
            $template = $this->getTemplate($type);

            if (! $template) {
                throw new InvalidArgumentException("Template {$type} not found");
            }
            $admins = Admin::all();
            // Send Email Notification
            if ($template->email_status == 1) {
                foreach ($admins as $admin) {
                    $this->sendEmail($admin, $template, $shortcodes, $customData);
                }
            }

            // other channels

            return true;
        } catch (\Exception $e) {
            \Log::error('Notification failed', [
                'type' => $type,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Schedule a notification
     */
    public function schedule(string $type, User $user, array $data, \DateTime $sendAt): void
    {
        dispatch(function () use ($type, $user, $data) {
            $this->send($type, $user, $data);
        })->delay($sendAt);
    }
}
