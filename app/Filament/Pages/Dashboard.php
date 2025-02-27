<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\OrdersChart;
use App\Filament\Widgets\ChartDummyWidget;

class Dashboard extends BaseDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            OrdersChart::class, // ✅ Add the OrdersChart widget
            // ChartDummyWidget::class,
        ];
    }
}
