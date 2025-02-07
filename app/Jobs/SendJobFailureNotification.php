<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Notifications\JobFailedNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendJobFailureNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $jobName;
    protected $jobId;
    protected $errorMessage;

    public function __construct($userId, $jobName, $jobId, $errorMessage)
    {
        $this->userId = $userId;
        $this->jobName = $jobName;
        $this->jobId = $jobId;
        $this->errorMessage = json_encode($errorMessage); // ✅ Prevent serialization issue
    }

    public function handle()
    {
        $user = User::find($this->userId);
        if (!$user) return;

        Log::info("📩 Sending Job Failure Notification to User ID: {$this->userId}");

        Notification::send($user, new JobFailedNotification($this->jobName, $this->jobId, json_decode($this->errorMessage)));
    }
}
