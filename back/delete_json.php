<?php
// Define the mail folder
$mailFolder = __DIR__ . '/mail';

// Get the file name from the query parameter
$fileName = isset($_GET['file']) ? $_GET['file'] : null;

if (!$fileName) {
    echo "Error: No file specified.";
    exit;
}

// Sanitize file name and construct the full path
$filePath = realpath($mailFolder . '/' . $fileName);

// Check if the file exists and is in the mail folder
if (!file_exists($filePath) || strpos($filePath, $mailFolder) !== 0) {
    echo "Error: File not found or access denied.";
    exit;
}

// Attempt to delete the file
if (unlink($filePath)) {
    echo "File successfully deleted.";
} else {
    echo "Error: Unable to delete file.";
}

// Redirect back to the control panel
header("Location: panel.php");
exit;

