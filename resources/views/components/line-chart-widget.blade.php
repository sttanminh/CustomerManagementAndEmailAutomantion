<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charts & Tables</title>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/export-chart.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    
    <style>
        /* ✅ Container for both charts (side by side) */
        #chartsContainer {
            display: flex;
            justify-content: center;
            gap: 30px; /* Space between charts */
            margin-bottom: 20px;
        }

        /* ✅ Chart styling */
        .chart-box {
            width: 40vw;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* ✅ Export Button styling */
        #exportChartButton {
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        #exportChartButton:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
        <div>
    <!-- ✅ Charts Container -->
    <div id="chartsContainer">
        <!-- ✅ Line Chart Box -->
        <div class="chart-box">
            <h2 class="text-lg font-semibold mb-4">Line Chart - Monthly Data</h2>
            <div id="lineChart"></div>
        </div>

        <!-- ✅ Bar Chart Box -->
        <div class="chart-box">
            <h2 class="text-lg font-semibold mb-4">Bar Chart - Product Sales</h2>
            <div id="barChart"></div>
        </div>
    </div>

    <!-- ✅ Export Button -->
    <div style="text-align: center;">
        <button id="exportChartButton">Export Charts to PDF</button>
    </div>

    <!-- ✅ Tables Section -->
    <div class="p-6 bg-white rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Customers Table</h2>
        @livewire(App\Filament\Widgets\CustomerTableWidget::class)
    </div>

    <div class="p-6 bg-white rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Products Table</h2>
        @livewire(App\Filament\Widgets\ProductTableWidget::class)
    </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let lineChartData = @json($this->lineChartData);
        let barChartData = @json($this->barChartData);

        new ApexCharts(document.querySelector("#lineChart"), {
            chart: { type: "line", height: 300 },
            series: lineChartData.series,
            xaxis: { categories: lineChartData.categories },
            stroke: { curve: "smooth", width: 2 },
            markers: { size: 5 },
            colors: ["#1E88E5", "#F44336"]
        }).render();

        new ApexCharts(document.querySelector("#barChart"), {
            chart: { type: "bar", height: 300 },
            series: barChartData.series,
            xaxis: { categories: barChartData.categories },
            colors: ["#ff9800", "#4caf50"]
        }).render();
    });
</script>


</body>
</html>
