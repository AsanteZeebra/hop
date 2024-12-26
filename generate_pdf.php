
<?php
require_once('vendor/autoload.php');
require_once('tcpdf/tcpdf.php');



if (isset($_POST['data'])) {
    $jsonData = json_decode($_GET['data'], true);

    // Create a new PDF document
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);

    // Prepare the PDF content
    $html = '<h1>Data Report</h1><table border="1" cellpadding="5">';
    $html .= '<thead><tr>';
    $columns = array_keys($jsonData[0]);

    foreach ($columns as $col) {
        $html .= '<th>' . ucfirst($col) . '</th>';
    }
    $html .= '</tr></thead><tbody>';

    foreach ($jsonData as $row) {
        $html .= '<tr>';
        foreach ($row as $data) {
            $html .= '<td>' . htmlspecialchars($data) . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';

    // Output the PDF
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('data_report.pdf', 'I');
}
?>
