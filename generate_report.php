<?php
// Include the TCPDF library
require_once('tcpdf_include.php');

// Database connection parameters
$host = 'localhost'; // Your database host
$dbname = 'your_database'; // Your database name
$username = 'your_username'; // Your database username
$password = 'your_password'; // Your database password

try {
    // Establish a PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch data from expenses table
    $sql = "SELECT date, description, amount FROM expenses";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Fetch all data
    $expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Expense Report');
$pdf->SetSubject('Expense Details');
$pdf->SetKeywords('TCPDF, PDF, expense, report');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Expense Report', 'Generated using TCPDF');

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// Set font
$pdf->SetFont('helvetica', '', 12);

// Add a page
$pdf->AddPage();

// HTML content to be printed in the PDF
$html = '<h1>Expense Report</h1>';
$html .= '<table border="1" cellpadding="4">
<thead>
<tr>
<th>Date</th>
<th>Description</th>
<th>Amount</th>
</tr>
</thead>
<tbody>';

// Iterate through expenses and add them to the HTML table
foreach ($expenses as $expense) {
    $html .= '<tr>
    <td>' . htmlspecialchars($expense['date']) . '</td>
    <td>' . htmlspecialchars($expense['description']) . '</td>
    <td>' . htmlspecialchars($expense['amount']) . '</td>
    </tr>';
}

$html .= '</tbody></table>';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// Close and output PDF document
$pdf->Output('expense_report.pdf', 'I');

// Close database connection
$pdo = null;

?>
