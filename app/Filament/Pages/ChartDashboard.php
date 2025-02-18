<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class ChartDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $title = 'Charts & Tables';
    protected static string $view = 'filament.pages.chart-dashboard';

    public array $lineChartData = [];
    public array $barChartData = [];

    public function mount()
    {
        $this->lineChartData = $this->getLineChartData();
        $this->barChartData = $this->getBarChartData();
    }

    protected function getLineChartData(): array
    {
        return [
            'series' => [
                ['name' => 'Sales', 'data' => [1200, 1500, 1700, 1400, 1800, 2000]],
                ['name' => 'Expenses', 'data' => [800, 900, 1000, 950, 1200, 1300]],
            ],
            'categories' => ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
        ];
    }

    protected function getBarChartData(): array
    {
        return [
            'series' => [
                ['name' => 'Product A', 'data' => [10, 20, 30, 40, 50, 60]],
                ['name' => 'Product B', 'data' => [15, 25, 35, 45, 55, 65]],
            ],
            'categories' => ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
        ];
    }
}
