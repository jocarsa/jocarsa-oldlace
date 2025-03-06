<?php
// Connect to SQLite database
$db = new SQLite3('../logs.sqlite');

// SQL query
$query = "SELECT 
            CONCAT(year,'-',month,'-',day) AS label, 
            COUNT(epoch) AS value 
          FROM logs 
          GROUP BY day;";

$result = $db->query($query);

// Fetch results and format as JSON
$data = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $data[] = [
        "label" => $row['label'],
        "value" => (int) $row['value']
    ];
}

// Output JSON
header('Content-Type: application/json');
echo json_encode(["data" => $data], JSON_PRETTY_PRINT);
?>

