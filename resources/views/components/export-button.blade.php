<!-- ✅ Persistent Export Button (Fixed at Bottom 5px) -->
<button id="exportChartButton"
    class="bg-blue-500 text-white font-bold px-4 py-2 rounded-lg shadow-lg fixed bottom-[5px] right-10 z-[1000]">
    📸 Export Page
</button>

<!-- ✅ Directly Load JavaScript -->

<script src="{{ asset('js/export-chart.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>