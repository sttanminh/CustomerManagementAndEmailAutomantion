<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class JobFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $jobName;
    protected $jobId;
    protected $errorMessage;

    public function __construct($jobName, $jobId, $errorMessage)
    {
        $this->jobName = $jobName;
        $this->jobId = $jobId;
        $this->errorMessage = json_encode($errorMessage); // ✅ Convert to string to avoid serialization issues
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => '⚠️ Job Failed!',
            'message' => "**Job Name:** {$this->jobName} \n**Job ID:** {$this->jobId} \n**Error:** " . json_decode($this->errorMessage),
            'type' => 'danger',
        ];
    }
}
