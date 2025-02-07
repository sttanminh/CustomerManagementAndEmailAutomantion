<?php
namespace App\Listeners;

use App\Models\User;
use App\Jobs\SendJobFailureNotification;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Log;

class JobFailureListener
{
    public function handle(JobFailed $event)
{
    Log::info("🚨 JobFailureListener Triggered for Job: {$event->job->resolveName()}");

    // ✅ Get all users instead of just one
    $users = User::all();

    if ($users->isEmpty()) {
        Log::warning("⚠️ No users found! Job failure notification will not be sent.");
        return;
    }

    // Extract job details
    $jobName = method_exists($event->job, 'resolveName') ? $event->job->resolveName() : 'Unknown';
    $jobId = method_exists($event->job, 'getJobId') ? $event->job->getJobId() : 'Unknown';
    $errorMessage = $event->exception->getMessage();

    // Dispatch notifications for all users
    foreach ($users as $user) {
        Log::info("📌 Dispatching SendJobFailureNotification for User ID: {$user->id}");
        SendJobFailureNotification::dispatch($user->id, $jobName, $jobId, $errorMessage);
    }
}

}
