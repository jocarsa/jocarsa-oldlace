<?php

include "config.php";

// Conexión a la base de datos
$conn = new mysqli($dbservidor, $dbusuario, $dbcontrasena, $dbbasededatos);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener páginas
$pages = $conn->query("SELECT Identificador FROM paginas");

// Obtener productos
$products = $conn->query("SELECT titulo FROM productos");

// Obtener categorías
$categories = $conn->query("SELECT Identificador FROM categorias");

// Obtener entradas de blog
$blogs = $conn->query("SELECT Identificador FROM blog");

// Generar el contenido del sitemap
$sitemap = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$sitemap .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

// Página principal
$sitemap .= "  <url>\n";
$sitemap .= "    <loc>https://jocarsa.com/</loc>\n";
$sitemap .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
$sitemap .= "    <changefreq>daily</changefreq>\n";
$sitemap .= "    <priority>1.0</priority>\n";
$sitemap .= "  </url>\n";

// Agregar páginas
while ($row = $pages->fetch_assoc()) {
    $sitemap .= "  <url>\n";
    $sitemap .= "    <loc>https://jocarsa.com/pagina.php?pagina=" . $row['Identificador'] . "</loc>\n";
    $sitemap .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
    $sitemap .= "    <changefreq>monthly</changefreq>\n";
    $sitemap .= "    <priority>0.6</priority>\n";
    $sitemap .= "  </url>\n";
}

// Agregar productos
while ($row = $products->fetch_assoc()) {
    $productName = urlencode($row['titulo']);
    $sitemap .= "  <url>\n";
    $sitemap .= "    <loc>https://jocarsa.com/producto.php?prod=$productName</loc>\n";
    $sitemap .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
    $sitemap .= "    <changefreq>weekly</changefreq>\n";
    $sitemap .= "    <priority>0.7</priority>\n";
    $sitemap .= "  </url>\n";
}

// Agregar categorías
while ($row = $categories->fetch_assoc()) {
    $sitemap .= "  <url>\n";
    $sitemap .= "    <loc>https://jocarsa.com/categoria.php?cat=" . $row['Identificador'] . "</loc>\n";
    $sitemap .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
    $sitemap .= "    <changefreq>weekly</changefreq>\n";
    $sitemap .= "    <priority>0.8</priority>\n";
    $sitemap .= "  </url>\n";
}

// Agregar entradas de blog
while ($row = $blogs->fetch_assoc()) {
    $sitemap .= "  <url>\n";
    $sitemap .= "    <loc>https://jocarsa.com/blog.php?blog=" . $row['Identificador'] . "</loc>\n";
    $sitemap .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
    $sitemap .= "    <changefreq>weekly</changefreq>\n";
    $sitemap .= "    <priority>0.5</priority>\n";
    $sitemap .= "  </url>\n";
}

$sitemap .= "</urlset>";

// Escribir el contenido en sitemap.xml
file_put_contents('sitemap.xml', $sitemap);

// Cerrar conexión
$conn->close();

echo "Sitemap generado correctamente.";
?>
