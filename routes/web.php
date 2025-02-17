<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PdfDownloadController;
use App\Http\Controllers\ProcessOrderController;
use App\Filament\Widgets\LineChartWidget;
// use App\Http\Controllers\ChartController;

// Route::get('/chart', [ChartController::class, 'show']);

Route::get('/notifications', function () {
    return view('notifications');
})->middleware('auth'); // Ensure only logged-in users can see notifications

 
Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
    ->name('socialite.redirect');

Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])
    ->name('socialite.callback');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/customer',[CustomerController::class,'getAll']);


Route::post('/customer',[CustomerController::class,'addCustomer']);


Route::get('/send-pdf',[EmailController::class ,'sendEmails']);



Route::get('/queue-downloads', [PdfDownloadController::class, 'processPdfs']);


Route::get('/process-order',[ProcessOrderController::class,'processOrder']);

Route::get('/linkedin/auth', [LinkedInController::class, 'redirectToLinkedIn']);
Route::get('/linkedin/callback', [LinkedInController::class, 'handleLinkedInCallback']);
Route::get('/linkedin/ad-accounts', [LinkedInController::class, 'getAdAccounts']);

Route::get('/test-chart', function () {
    return view('filament.widgets.line-chart-widget', ['widget' => new LineChartWidget()]);
});