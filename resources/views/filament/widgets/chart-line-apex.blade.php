<div>
    <h2 class="text-lg font-semibold mb-4">Line Chart</h2>
    <div id="lineChart"></div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const options = @json($this->getLineChartData());
            const chart = new ApexCharts(document.querySelector("#lineChart"), {
                chart: { type: "line", height: 300 },
                series: options.series,
                xaxis: { categories: options.categories },
            });
            chart.render();
        });
    </script>
</div>
