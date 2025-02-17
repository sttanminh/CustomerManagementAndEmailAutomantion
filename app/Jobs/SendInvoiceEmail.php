<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendPdfMail;
use App\Models\Order;
use App\Models\EmailLog;
use Carbon\Carbon;

class SendInvoiceEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function handle()
{
    $filePath = base_path('example.pdf');

    if (!file_exists($filePath)) {
        \Log::error("❌ PDF not found for Order ID {$this->orderId}");
        return;
    }

    $order = Order::find($this->orderId);

    if (!$order) {
        \Log::error("❌ Order ID {$this->orderId} not found.");
        return;
    }

    // ✅ Fetch recipient email
    $recipient = "tan.mojodojo@gmail.com"; // Hardcoded for testing

    if (empty($recipient) || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
        \Log::error("❌ Invalid email address for Order ID: {$this->orderId}");
        return;
    }

    $customerName = $order->customer_name ?? "Customer"; // ✅ Fallback
    $orderId = $order->id;

    \Log::info("📨 Sending invoice to: {$recipient} for Order ID: {$orderId}");

    try {
        Mail::to($recipient)->send(new SendPdfMail($filePath, $customerName, $orderId));

        EmailLog::create([
            'timestamp' => Carbon::now(),
            'recipient' => $recipient,
            'attachment' => $filePath,
            'email_content' => "Invoice sent for Order #{$orderId}.",
        ]);

        \Log::info("✅ Invoice email sent successfully to: {$recipient}");
    } catch (\Exception $e) {
        \Log::error("❌ Mail sending failed: " . $e->getMessage());
    }
}

}
