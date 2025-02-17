document.getElementById("exportChartButton").addEventListener("click", async function () {
    console.log("🚀 Exporting page to PDF with Bigger Charts & Scaled Table...");

    // Hide sidebar and export button before capturing
    const sidebar = document.querySelector(".fi-sidebar");
    const exportButton = document.getElementById("exportChartButton");

    if (sidebar) sidebar.style.display = "none";
    if (exportButton) exportButton.style.display = "none";

    try {
        // ✅ Apply Zoom: Increase chart & table size before capturing
        const charts = document.querySelectorAll(".chart-container");
        const tables = document.querySelectorAll(".table-container");

        charts.forEach(chart => {
            chart.style.width = "40vw"; // ✅ Set charts to 40% of viewport width
            chart.style.height = "auto"; // Keep aspect ratio
        });

        tables.forEach(table => {
            table.style.width = "85vw"; // ✅ Scale table width to fit the layout
        });

        // ✅ Capture the zoomed-in page
        const canvas = await html2canvas(document.body, {
            backgroundColor: null,
            useCORS: true,
            scale: 3, // 🔥 Increased scale for sharper zoomed-in output
            ignoreElements: (element) => {
                return element.classList.contains("fi-sidebar") || 
                       element.id === "exportChartButton"; 
            }
        });

        const imgData = canvas.toDataURL("image/jpeg", 1.0); // High-quality image
        const { jsPDF } = window.jspdf;

        // ✅ Create PDF in Landscape Mode
        let pdf = new jsPDF("landscape", "mm", "a4");

        // ✅ Set page dimensions
        const pageWidth = 297 - 20; // A4 landscape width (297mm minus 10mm left & right margins)
        const pageHeight = 210 - 20; // A4 landscape height (210mm minus 10mm margins)
        const imgWidth = pageWidth; // ✅ Fit image width to the full page width
        const imgHeight = (canvas.height * imgWidth) / canvas.width; // ✅ Maintain correct aspect ratio

        let yPosition = 0; // Start at the top
        let totalHeight = canvas.height;
        let sectionHeight = canvas.width * (pageHeight / imgWidth); // ✅ Maintain aspect ratio
        let pageCount = Math.ceil(totalHeight / sectionHeight); // Calculate needed pages

        // ✅ Loop through content and split across pages
        for (let i = 0; i < pageCount; i++) {
            const sectionCanvas = document.createElement("canvas");
            const sectionContext = sectionCanvas.getContext("2d");

            sectionCanvas.width = canvas.width;
            let remainingHeight = totalHeight - yPosition;

            // ✅ Adjust the last section height to avoid black areas
            if (remainingHeight < sectionHeight) {
                sectionCanvas.height = remainingHeight; // Crop last slice properly
            } else {
                sectionCanvas.height = sectionHeight;
            }

            // Copy the correct section of the original canvas
            sectionContext.drawImage(
                canvas,
                0, yPosition, // Source x, y
                canvas.width, sectionCanvas.height, // Source width, height
                0, 0, // Destination x, y
                sectionCanvas.width, sectionCanvas.height // Destination width, height
            );

            // Convert section to image
            const sectionImgData = sectionCanvas.toDataURL("image/jpeg", 1.0);

            // ✅ Add the image to the PDF with proper scaling
            pdf.addImage(sectionImgData, "JPEG", 10, 10, imgWidth, sectionCanvas.height * (imgWidth / canvas.width), undefined, "FAST");

            yPosition += sectionCanvas.height; // Move down for the next page

            if (i < pageCount - 1) {
                pdf.addPage(); // ✅ Add a new page if more content exists
            }
        }

        pdf.save("exported-page-zoomed-landscape.pdf");

        console.log("✅ PDF Exported Successfully with Bigger Charts & Scaled Table!");
    } catch (error) {
        console.error("❌ Error capturing the page:", error);
        alert("Failed to export page!");
    }

    // Restore original sizes after export
    charts.forEach(chart => {
        chart.style.width = ""; // Reset back to original size
        chart.style.height = "";
    });

    tables.forEach(table => {
        table.style.width = ""; // Reset table size
    });

    // Show sidebar and export button back after exporting
    if (sidebar) sidebar.style.display = "block";
    if (exportButton) exportButton.style.display = "block";
});
