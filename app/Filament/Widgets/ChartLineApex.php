<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Filament\Pages\ChartDashboard;

class ChartLineApex extends Widget
{
    protected static string $view = 'filament.widgets.chart-line-apex';

    public array $chartData = [];

    public function mount(array $chartData)
    {
        $this->chartData = $chartData;
    }

    public function getLineChartData(): array
    {
        return $this->chartData;
    }

  
}
