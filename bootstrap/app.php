<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use App\Models\Order;
use App\Jobs\SendInvoiceEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->call(function () {
            $today = Carbon::today()->timezone(config('app.timezone'));

            $orders = Order::where('schedule_interval', '!=', 'none')->get();

            foreach ($orders as $order) {
                $sendTime = $order->time ? $today->setTimeFromTimeString($order->time)->format('H:i') : null;
                if ($order->schedule_interval === 'no_repeat' && $today->isSameDay($order->start_day)  && $sendTime == now()->format('H:i')) {
                    dispatch(new SendInvoiceEmail($order->id));
                } elseif ($order->schedule_interval === 'daily' && $sendTime === now()->format('H:i')) {
                    dispatch(new SendInvoiceEmail($order->id));
                } elseif ($order->schedule_interval === 'weekly' && $today->diffInDays($order->start_day) % 7 === 0 && $sendTime === now()->format('H:i')) {
                    dispatch(new SendInvoiceEmail($order->id));
                } elseif ($order->schedule_interval === 'monthly' && $today->gte($order->start_day) && $sendTime === now()->format('H:i')) {
                    $lastDay = $today->endOfMonth()->day;
                    $sendDay = min($order->date_of_month, $lastDay);
                    if ($today->day === $sendDay) {
                        dispatch(new SendInvoiceEmail($order->id));
                    }
                }
            }
        })->everyMinute();
    })
    ->create();
