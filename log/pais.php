<?php
function damePais($ip){
	ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	// Function to convert an IP address to an integer
	function ipToInt($ip) {
		 return sprintf('%u', ip2long($ip));
	}

	// Open SQLite3 database connection
	$db = new SQLite3('log/geoloc.sqlite'); // Replace 'geoloc.db' with your database file path

	// Input IP address
	$inputIp = $ip; // Replace with the IP you want to check
	$inputIpInt = ipToInt($inputIp);

	// Query to fetch all rows from the table
	$query = "SELECT 
	range_start, range_end, registered_country_geoname_id,
	country_name 
	FROM ipv4
	LEFT JOIN paises
	ON ipv4.registered_country_geoname_id = paises.geoname_id";
	$results = $db->query($query);

	$countryCode = null;

	// Check each row to find a matching range
	while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
		 $rangeStartInt = ipToInt($row['range_start']);
		 $rangeEndInt = ipToInt($row['range_end']);

		 if ($inputIpInt >= $rangeStartInt && $inputIpInt <= $rangeEndInt) {
		     $countryCode = $row['country_name'];
		     break;
		 }
	}

	// Output the result
	if ($countryCode !== null) {
		 return $countryCode;
	} else {
		 return 0;
	}

	// Close the database connection
	$db->close();
}

?>

