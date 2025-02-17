<?php
namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

// class JobFailureNotifications extends Widget
// {
//     protected static string $view = 'filament.widgets.job-failure-notifications';

//     protected static bool $isLazy = false; // ✅ Ensures data loads immediately

//     public $notifications = []; // ✅ Livewire variable

//     public function mount()
//     {
//         $this->notifications = Auth::user()->notifications()->latest()->limit(5)->get();
//     }

//     protected function getViewData(): array
//     {
//         return ['notifications' => $this->notifications]; // ✅ Pass data to Blade
//     }
// }
