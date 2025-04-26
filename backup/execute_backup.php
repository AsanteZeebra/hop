<?php
$username = "root";
$host = "localhost";
$password = "0249kwaku";
$database = "fremepxt_hop";

// Define the backup file path with a timestamp
$backupDir = __DIR__;
$timestamp = date('Y-m-d_H-i-s');
$backupFile = $backupDir . "/backup_$timestamp.sql";

// Path to mysqldump executable
$mysqldumpPath = 'C:\\wamp64\\bin\\mysql\\mysql9.1.0\\bin\\mysqldump'; // Replace with your actual path

// Command to execute mysqldump
$command = sprintf(
    '%s --user=%s --password=%s --host=%s %s > "%s"',
    escapeshellarg($mysqldumpPath),
    escapeshellarg($username),
    escapeshellarg($password),
    escapeshellarg($host),
    escapeshellarg($database),
    $backupFile
);

// Execute the command
exec($command . ' 2>&1', $output, $return_var);

// Log the command and output for debugging
error_log("Command executed: $command");
error_log("Output: " . implode("\n", $output));
error_log("Return code: $return_var");

if ($return_var === 0) {
    echo "✅ Backup successful! File saved at: $backupFile";
} else {
    echo "❌ Backup failed! Check the error log for details.";
}