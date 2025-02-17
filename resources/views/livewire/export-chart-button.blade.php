<div class="mt-4 text-center">
    <button 
        onclick="exportChart()" 
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg"
    >
        Export Chart
    </button>
</div>

<!-- Load html2canvas -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    function exportChart() {
        console.log('Exporting chart...');

        const chartContainer = document.querySelector('google-chart');

        if (!chartContainer) {
            console.error('Chart container not found');
            return;
        }

        html2canvas(chartContainer, { scale: 2 }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'chart.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
            console.log('Chart exported successfully');
        }).catch(error => {
            console.error('Error exporting chart:', error);
        });
    }
</script>
