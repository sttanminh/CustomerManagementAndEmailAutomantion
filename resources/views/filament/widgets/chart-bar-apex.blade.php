<div>
    <h2 class="text-lg font-semibold mb-4">Bar Chart</h2>
    <div id="barChart"></div> <!-- ✅ Correct ID for the bar chart -->

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const options = @json($this->getBarChartData());
            const chart = new ApexCharts(document.querySelector("#barChart"), { // ✅ Corrected selector
                chart: { type: "bar", height: 300 }, // ✅ Changed chart type to 'bar'
                series: options.series,
                xaxis: { categories: options.categories },
            });
            chart.render();
        });
    </script>
</div>
