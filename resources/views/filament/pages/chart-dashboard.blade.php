<x-filament::page>
    <div class="space-y-6">
        <h1 class="text-2xl font-semibold">Charts & Tables Dashboard</h1>
        <div class="text-center mt-4">
            <button id="exportChartButton" class="px-4 py-2 bg-blue-500 text-red rounded hover:bg-blue-600">
                Export to PDF
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @livewire(App\Filament\Widgets\ChartLineApex::class, ['chartData' => $lineChartData])
            @livewire(App\Filament\Widgets\ChartBarApex::class, ['chartData' => $barChartData])
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            @livewire(App\Filament\Widgets\CustomerTableWidget::class)
            @livewire(App\Filament\Widgets\ProductTableWidget::class)
        </div>
    </div>
    <script src="{{ asset('js/export-chart.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</x-filament::page>
