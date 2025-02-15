<!doctype html>
<html>
	<head>
		<title>JOCARSA</title>
		<style>
			@import url('https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap');
			*{
				padding:0px;
				margin:0px;
				margin-bottom:10px;
			}
			body{
				font-family:Ubuntu,sans-serif;
				color:indigo;
			}
			body,html{
				padding-top:50px;
			}
			li{
				padding-left:20px;
			}
			br{
				display:none;
			}
			body{
				padding:60px;
				padding-top:150px;
			}
			img{
				width:180px;
				
			}
			h2{
				text-align:center;
			}
			.corporativo{
			
				text-align:center;
			}
			header{
				position:fixed;
				background:indigo;
				color:white;
				top:0px;
				left:0px;
				width:100%;
				text-align:center;
				display: flex;
				flex-direction: row;
				flex-wrap: nowrap;
				justify-content: center;
				align-items: center;
				align-content: stretch;
			}
			header img{
				width:50px;
			}
			footer{
			padding:10px;
				position:fixed;
				background:indigo;
				color:white;
				bottom:0px;
				left:0px;
				width:100%;
				text-align:center;
				display: flex;
				flex-direction: row;
				flex-wrap: nowrap;
				justify-content: center;
				align-items: center;
				align-content: stretch;
			}
			article{
				padding-top:80px;
				
			}
			.pagina{
				page-break-before: always;
				text-align:justify;
			}
			.extracto{
			
display: flex;
	flex-direction: row;
	flex-wrap: nowrap;
	justify-content: space-between;
	align-items: center;
	align-content: stretch;
	padding-top:10px;
	gap:20px;
	text-align:justify;
			}
			.extracto .corporativo{
				flex: 0 0 200px;
			}
			.extracto h2{
				font-size:14px;
			}
			#portada{
				text-align:center;
				page-break-after: always;
				font-size:100px;
			}
			#portada img{
				width:80%;
			}
			main{
				page-break-after: always;
			}
			main h1{
				page-break-after: always;
				page-break-before: always;
				height:100%;
				line-height:100%;
				padding-top:50%;
				text-align:center;
				font-size:80px;
			}
			.extracto img{
				width:80px;
			}
		</style>
		
	</head>
	<body>
	<header>
	<img src="../static/logo/jocarsa | White.svg">
		<h1>jocarsa</h1>
	</header>
	<section id="portada">
	<img src="../static/logo/jocarsa | Indigo.svg">
		<h1>jocarsa</h1>
	</section>
	<main>
	<h1>Resumen de los productos</h1>
	<?php
	
			include "jocarsa | navy.php";
			// Specify the directory containing the .txt files
			$directory = 'descripciones';

			// Check if the directory exists
			if (!is_dir($directory)) {
				 die("The specified directory does not exist.");
			}

			// Get all .txt files in the directory
			$txtFiles = glob($directory . '/*.txt');

			// Check if there are any .txt files in the directory
			if (empty($txtFiles)) {
				 die("No .txt files found in the specified directory.");
			}

			// Loop through each .txt file and read its contents
			$allContents = '';
			foreach ($txtFiles as $file) {
				 // Get the file name
				 $fileName = basename($file);

				 // Read the file contents
				 $fileContents = "<article class='extracto'>";
				 $fileContents .= "<div class='corporativo'><img src='../static/logo/".strtolower(str_replace(".txt","",str_replace("jocarsa-","",$fileName))).".png'>";
				 $fileContents .= "<h2>".strtolower(str_replace(".txt","",str_replace("-"," | ",$fileName)))."</h2></div>";
				 $fileContents .= "<p>".explode("\n",file_get_contents($file))[2]."</p>";
				$fileContents .= "</article>";
				 // Append the file name and contents to the $allContents variable
				
				 $allContents .= $fileContents . "\n\n";
			}

			// Display all the contents on the screen
			echo nl2br($allContents);
			
		?>
		<h1>Detalle de producto</h1>
		<?php
	
			// Specify the directory containing the .txt files
			$directory = 'descripciones';

			// Check if the directory exists
			if (!is_dir($directory)) {
				 die("The specified directory does not exist.");
			}

			// Get all .txt files in the directory
			$txtFiles = glob($directory . '/*.txt');

			// Check if there are any .txt files in the directory
			if (empty($txtFiles)) {
				 die("No .txt files found in the specified directory.");
			}

			// Loop through each .txt file and read its contents
			$allContents = '';
			foreach ($txtFiles as $file) {
				 // Get the file name
				 $fileName = basename($file);

				 // Read the file contents
				 $fileContents = "<article class='pagina'>";
				 $fileContents .= "<div class='corporativo'><img src='../static/logo/".strtolower(str_replace(".txt","",str_replace("jocarsa-","",$fileName))).".png'>";
				 $fileContents .= "<h2>".strtolower(str_replace(".txt","",str_replace("-"," | ",$fileName)))."</h2></div>";
				 $fileContents .= markdownToHtml(file_get_contents($file));
				$fileContents .= "</article>";
				 // Append the file name and contents to the $allContents variable
				
				 $allContents .= $fileContents . "\n\n";
			}

			// Display all the contents on the screen
			echo nl2br($allContents);
		?>
		</main>
	<footer>
		https://jocarsa.com - info@jocarsa.com - +34 620 89 17 18
	</footer>
	
