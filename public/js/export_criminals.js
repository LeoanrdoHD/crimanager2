

function getVisibleColumns(table) {
    // Devuelve los índices de columnas visibles, excluyendo foto (5) y acciones (8)
    return table
        .columns(":visible")
        .indexes()
        .toArray()
        .filter((idx) => idx !== 5 && idx !== 8);
}

function getExportData(table) {
    const visibleCols = getVisibleColumns(table);
    const headers = visibleCols.map((idx) =>
        $(table.column(idx).header()).text().trim()
    );
    const data = table
        .rows({ filter: "applied" })
        .data()
        .toArray()
        .map((row) => {
            return visibleCols.map((idx) => {
                let cell = row[idx];
                // Si es HTML, extraer solo texto y limpiar saltos de línea excesivos
                let text = $("<div>").html(cell).text().trim();
                // Reemplazar saltos de línea múltiples por uno solo y quitar espacios extra
                text = text
                    .replace(/\n+/g, "\n")
                    .replace(/\s*\n\s*/g, "\n")
                    .replace(/\n$/, "");
                // Unir por ", " si hay varios datos separados por salto de línea
                if (text.includes("\n"))
                    text = text
                        .split("\n")
                        .map((s) => s.trim())
                        .filter(Boolean)
                        .join(", ");
                return text;
            });
        });
    return { headers, data };
}

function exportToExcel(table) {
    const { headers, data } = getExportData(table);
    const ws = XLSX.utils.aoa_to_sheet([headers, ...data]);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Criminales");
    XLSX.writeFile(
        wb,
        "criminales_" + new Date().toISOString().slice(0, 10) + ".xlsx"
    );
}

function exportToCSV(table) {
    const { headers, data } = getExportData(table);
    let csv = headers.join(",") + "\n";
    data.forEach((row) => {
        csv +=
            row.map((cell) => '"' + cell.replace(/"/g, '""') + '"').join(",") +
            "\n";
    });
    const blob = new Blob([csv], { type: "text/csv" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download =
        "criminales_" + new Date().toISOString().slice(0, 10) + ".csv";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function exportToPDF(table) {
    const { headers, data } = getExportData(table);
    const docDefinition = {
        pageOrientation: "landscape",
        pageSize: "A3",
        content: [
            {
                text: "LISTA DE CRIMINALES REGITRADOS EN EL SISTEMA - CRIMANAGER",
                style: "header",
                alignment: "center",
            },
            {
                text: "Fecha: " + new Date().toLocaleDateString(),
                alignment: "right",
                margin: [0, 0, 0, 10],
            },
            {
                table: {
                    headerRows: 1,
                    widths: Array(headers.length).fill("*"),
                    body: [headers, ...data],
                },
                layout: {
                    fillColor: function (rowIndex, node, columnIndex) {
                        return rowIndex === 0 ? "#187ADCFF" : null;
                    },
                    paddingTop: function () {
                        return 2;
                    },
                    paddingBottom: function () {
                        return 2;
                    },
                    paddingLeft: function () {
                        return 2;
                    },
                    paddingRight: function () {
                        return 2;
                    },
                },
            },
        ],
        styles: {
            header: { fontSize: 16, bold: true, margin: [0, 0, 0, 10] },
        },
        defaultStyle: {
            fontSize: 8,
        },
    };
    pdfMake
        .createPdf(docDefinition)
        .download(
            "criminales_" + new Date().toISOString().slice(0, 10) + ".pdf"
        );
}

function printTable(table) {
    const { headers, data } = getExportData(table);
    let html =
        "<html><head><title>Lista de Criminales</title>" +
        "<style>table{border-collapse:collapse;width:100%;}th,td{border:1px solid #ccc;padding:4px;}th{background:#eee;}</style>" +
        "</head><body>";
    html += '<h2 style="text-align:center;">LISTA DE CRIMINALES</h2>';
    html += "<p>Fecha: " + new Date().toLocaleDateString() + "</p>";
    html +=
        "<table><thead><tr>" +
        headers.map((h) => "<th>" + h + "</th>").join("") +
        "</tr></thead><tbody>";
    data.forEach((row) => {
        html +=
            "<tr>" +
            row.map((cell) => "<td>" + cell + "</td>").join("") +
            "</tr>";
    });
    html += "</tbody></table></body></html>";
    const win = window.open("", "", "width=1200,height=800");
    win.document.write(html);
    win.document.close();
    win.print();
}

// Exporta las funciones para uso en el blade
window.criminalsExport = {
    exportToExcel,
    exportToCSV,
    exportToPDF,
    printTable,
};
