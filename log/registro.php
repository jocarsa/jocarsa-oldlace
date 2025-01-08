<?php

include "pais.php";

// Database and table creation
$dbFile = 'logs.sqlite';
$db = new SQLite3($dbFile);

// Create the table if it doesn't exist
$tableCreationQuery = "CREATE TABLE IF NOT EXISTS logs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    epoch INTEGER,
    year INTEGER,
    month INTEGER,
    day INTEGER,
    hour INTEGER,
    minute INTEGER,
    second INTEGER,
    ip TEXT,
    user_agent TEXT,
    screenx INTEGER,
    screeny INTEGER,
    domain_visited TEXT,
    page_visited TEXT,
    browser_language TEXT,
    country TEXT
);";

$db->exec($tableCreationQuery);

// Capture log data
$epoch = time();
$date = getdate($epoch);
$ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$screenX = isset($_POST['screenx']) ? intval($_POST['screenx']) : 0;
$screenY = isset($_POST['screeny']) ? intval($_POST['screeny']) : 0;
$domainVisited = $_SERVER['HTTP_HOST'] ?? 'Unknown';
$pageVisited = $_SERVER['REQUEST_URI'] ?? 'Unknown';
$browserLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'Unknown';
$country = damePais($ip); // Use a GeoIP library to determine the country, if available.

// Insert data into the table
$insertQuery = "INSERT 
INTO logs (

    epoch, 
    year, 
    month, 
    day, 
    hour, 
    minute, 
    second, 
    ip, 
    user_agent, 
    screenx, 
    screeny, 
    domain_visited, 
    page_visited, 
    browser_language, 
    country
) VALUES (
    $epoch, 
    {$date['year']}, 
    {$date['mon']}, 
    {$date['mday']}, 
    {$date['hours']}, 
    {$date['minutes']}, 
    {$date['seconds']}, 
    '$ip', 
    '$userAgent', 
    $screenX, 
    $screenY, 
    '$domainVisited', 
    '$pageVisited', 
    '$browserLanguage', 
    '$country'
);";
//echo $insertQuery;
$db->exec($insertQuery);

// Confirmation
//echo "Log saved successfully.";

