<?php
// Set content type to HTML
header("Content-Type: text/html");

// Define the mail folder
$mailFolder = __DIR__ . '/mail';

// Check if the folder exists
if (!is_dir($mailFolder)) {
    echo "<h1>No se encontró la carpeta 'mail'.</h1>";
    exit;
}

// Scan for JSON files and get their creation times
$jsonFiles = array_filter(scandir($mailFolder), function ($file) use ($mailFolder) {
    return pathinfo($file, PATHINFO_EXTENSION) === 'json';
});

// Create an array of files with their metadata
$fileData = [];
foreach ($jsonFiles as $file) {
    $filePath = $mailFolder . '/' . $file;
    $fileData[] = [
        'filename' => $file,
        'creation_date' => filectime($filePath),
        'path' => $filePath
    ];
}

// Sort files by creation date (most recent first)
usort($fileData, function ($a, $b) {
    return $b['creation_date'] - $a['creation_date'];
});
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Panel - JSON Files</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
            text-align: left;
            padding: 10px;
        }
        td {
            padding: 10px;
            text-align: left;
        }
        .btn {
            padding: 5px 10px;
            color: #fff;
            border: none;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-view {
            background-color: #007bff;
        }
        .btn-view:hover {
            background-color: #0056b3;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #a71d2a;
        }
        .no-data {
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <h1>Control Panel - JSON Files</h1>
    <table>
        <thead>
            <tr>
                <th>Creation Date</th>
                <th>Filename</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Asunto</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($fileData)): ?>
                <tr>
                    <td colspan="6" class="no-data">No JSON files found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($fileData as $file): ?>
                    <?php
                    // Attempt to extract data from the JSON file
                    $jsonContent = file_get_contents($file['path']);
                    $data = json_decode($jsonContent, true);
                    $nombre = $data['nombre'] ?? 'N/A';
                    $email = $data['email'] ?? 'N/A';
                    $asunto = $data['asunto'] ?? 'N/A';
                    $creationDate = date("Y-m-d H:i:s", $file['creation_date']);
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($creationDate); ?></td>
                        <td><?php echo htmlspecialchars($file['filename']); ?></td>
                        <td><?php echo htmlspecialchars($nombre); ?></td>
                        <td><?php echo htmlspecialchars($email); ?></td>
                        <td><?php echo htmlspecialchars($asunto); ?></td>
                        <td>
                            <a href="view_json.php?file=<?php echo urlencode($file['filename']); ?>" class="btn btn-view">View</a>
                            <a href="delete_json.php?file=<?php echo urlencode($file['filename']); ?>" class="btn btn-delete" onclick="return confirm('¿Estás seguro de que quieres eliminar este archivo?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

