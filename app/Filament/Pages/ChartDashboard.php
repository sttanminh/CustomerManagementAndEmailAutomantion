<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\CustomerTableWidget;
use App\Filament\Widgets\ProductTableWidget;

class ChartDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $title = 'Charts & Tables';
    protected static string $view = 'components.line-chart-widget';

    public array $lineChartData = [];
    public array $barChartData = [];

    public function mount()
    {
        $this->lineChartData = $this->getLineChartData();
        $this->barChartData = $this->getBarChartData();
    }

    protected function getLineChartData(): array
    {
        // ✅ Example data from your database (replace with your query)
        return [
            'series' => [
                ['name' => 'Sales', 'data' => [1200, 1500, 1700, 1400, 1800, 2000, 2500, 2200, 1900, 2300, 2600, 2800]],
                ['name' => 'Expenses', 'data' => [800, 900, 1000, 950, 1200, 1300, 1600, 1500, 1400, 1600, 1700, 1900]],
            ],
            'categories' => ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        ];
    }

    protected function getBarChartData(): array
    {
        // ✅ Example data from your database (replace with your query)
        return [
            'series' => [
                ['name' => 'Product A', 'data' => [20, 30, 50, 60, 40, 70, 80, 60, 50, 40, 30, 20]],
                ['name' => 'Product B', 'data' => [15, 25, 35, 45, 55, 65, 75, 85, 55, 45, 35, 25]],
            ],
            'categories' => ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        ];
    }

    protected function getWidgets(): array
    {
        return [
            CustomerTableWidget::class,
            ProductTableWidget::class,
        ];
    }
}
