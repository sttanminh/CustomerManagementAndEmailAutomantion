<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Filament\Pages\ChartDashboard;

class ChartBarApex extends Widget
{
    protected static string $view = 'filament.widgets.chart-bar-apex';

    public array $chartData = [];

    public function mount(array $chartData)
    {
        $this->chartData = $chartData;
    }

    public function getBarChartData(): array
    {
        return $this->chartData;
    }
}
