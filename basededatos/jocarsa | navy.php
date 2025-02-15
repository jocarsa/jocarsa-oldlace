<?php

function markdownToHtml($markdown) {
    // -------------------------------------------------------------
    // 1) EXTRAER BLOQUES DE CÓDIGO (```...```) CON PLACEHOLDERS
    // -------------------------------------------------------------
    $codeBlocks = [];
    $markdown = preg_replace_callback(
        '/```([^\r\n]*)\r?\n([\s\S]*?)```/',
        function($matches) use (&$codeBlocks) {
            $lang    = trim($matches[1]);
            $content = $matches[2];

            if (in_array(strtolower($lang), ['mermaid', 'plantuml', 'graphviz'])) {
                // Soporte para diagramas especiales
                $htmlCode = '<div class="'.strtolower($lang).'">'.htmlspecialchars($content).'</div>';
            } else {
                // Bloque de código normal
                $classAttr = $lang ? ' class="language-'.strtolower($lang).'"' : '';
                $htmlCode  = '<pre><code'.$classAttr.'>'.htmlspecialchars($content).'</code></pre>';
            }

            // Generar un marcador único para reemplazar luego
            $placeholder = '___CODEBLOCK___'.count($codeBlocks).'___';
            $codeBlocks[$placeholder] = $htmlCode;
            return $placeholder;
        },
        $markdown
    );

    // -------------------------------------------------------------
    // 2) EXTRAER CÓDIGO INLINE (`...`) CON PLACEHOLDERS
    // -------------------------------------------------------------
    $inlineCodes = [];
    $markdown = preg_replace_callback(
        '/`([^`]+)`/',
        function ($matches) use (&$inlineCodes) {
            $placeholder = '___INLINECODE___'.count($inlineCodes).'___';
            $inlineCodes[$placeholder] = '<code>'.htmlspecialchars($matches[1]).'</code>';
            return $placeholder;
        },
        $markdown
    );

    // -------------------------------------------------------------
    // 3) ENCABEZADOS (#, ##, ###, etc.)
    // -------------------------------------------------------------
    $markdown = preg_replace('/^###### (.*)$/m', '<h6>$1</h6>', $markdown);
    $markdown = preg_replace('/^##### (.*)$/m',  '<h5>$1</h5>', $markdown);
    $markdown = preg_replace('/^#### (.*)$/m',   '<h4>$1</h4>', $markdown);
    $markdown = preg_replace('/^### (.*)$/m',    '<h3>$1</h3>', $markdown);
    $markdown = preg_replace('/^## (.*)$/m',     '<h2>$1</h2>', $markdown);
    $markdown = preg_replace('/^# (.*)$/m',      '<h1>$1</h1>', $markdown);

    // -------------------------------------------------------------
    // 4) NEGRITAS Y CURSIVAS
    // -------------------------------------------------------------
    // Negritas
    $markdown = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $markdown);
    $markdown = preg_replace('/__(.*?)__/s',     '<strong>$1</strong>', $markdown);

    // Cursivas
    $markdown = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $markdown);
    $markdown = preg_replace('/_(.*?)_/s',   '<em>$1</em>', $markdown);

    // -------------------------------------------------------------
    // 5) TEXTO TACHADO (~~texto~~)
    // -------------------------------------------------------------
    $markdown = preg_replace('/~~(.*?)~~/s', '<del>$1</del>', $markdown);

    // -------------------------------------------------------------
    // 6) IMÁGENES ![texto](url "título")
    // -------------------------------------------------------------
    $markdown = preg_replace(
        '/!\[([^\]]*)\]\(([^) ]+)(?: "([^"]+)")?\)/',
        '<img src="$2" alt="$1" title="$3" />',
        $markdown
    );

    // -------------------------------------------------------------
    // 7) ENLACES [texto](url "título")
    // -------------------------------------------------------------
    $markdown = preg_replace(
        '/\[([^\]]+)\]\(([^) ]+)(?: "([^"]+)")?\)/',
        '<a href="$2" title="$3">$1</a>',
        $markdown
    );

    // -------------------------------------------------------------
    // 8) CITAS (>)
    // -------------------------------------------------------------
    $markdown = preg_replace('/^> (.*)$/m', '<blockquote>$1</blockquote>', $markdown);

    // -------------------------------------------------------------
    // 9) LISTAS DE TAREAS ( - [ ] y - [x] )
    // -------------------------------------------------------------
    $markdown = preg_replace_callback(
        '/^(?:[\-\*]\s\[[x ]\].*\R)+/m',
        function ($matches) {
            $lines = preg_split('/\R/', trim($matches[0]));
            $html  = "<ul>\n";
            foreach ($lines as $line) {
                if (preg_match('/^[\-\*]\s\[([x ])\]\s(.*)$/', $line, $parts)) {
                    $checked = ($parts[1] === 'x') ? 'checked' : '';
                    $text    = $parts[2];
                    $html   .= "  <li><input type=\"checkbox\" $checked disabled /> $text</li>\n";
                }
            }
            $html .= "</ul>\n";
            return $html;
        },
        $markdown
    );

    // -------------------------------------------------------------
    // 10) LISTAS ORDENADAS (1. item)
    // -------------------------------------------------------------
    $markdown = preg_replace_callback(
        '/^(?:\d+\.\s.*\R)+/m',
        function ($matches) {
            $lines = preg_split('/\R/', trim($matches[0]));
            $html  = "<ol>\n";
            foreach ($lines as $line) {
                $item = preg_replace('/^\d+\.\s/', '', $line);
                $html .= "  <li>$item</li>\n";
            }
            $html .= "</ol>\n";
            return $html;
        },
        $markdown
    );

    // -------------------------------------------------------------
    // 11) LISTAS NO ORDENADAS ( - item ), excepto checkboxes ya manejados
    // -------------------------------------------------------------
    $markdown = preg_replace_callback(
        '/^(?:[\-\*]\s(?!\[).*\R)+/m',
        function ($matches) {
            $lines = preg_split('/\R/', trim($matches[0]));
            $html  = "<ul>\n";
            foreach ($lines as $line) {
                $item = preg_replace('/^[\-\*]\s/', '', $line);
                $html .= "  <li>$item</li>\n";
            }
            $html .= "</ul>\n";
            return $html;
        },
        $markdown
    );

    // -------------------------------------------------------------
    // 12) TABLAS BÁSICAS
    // -------------------------------------------------------------
    $markdown = preg_replace_callback(
        '/^(\|.+\|)\R(\|[ \-:\|]+)\R((?:\|.+\|\R?)+)/m',
        function ($matches) {
            $headerLine = trim($matches[1]);
            // $separator  = trim($matches[2]); // no se usa realmente
            $rowsText   = trim($matches[3]);

            // Cabecera
            $headerCells = explode('|', trim($headerLine, '| '));
            $thead = "<thead>\n  <tr>";
            foreach ($headerCells as $cell) {
                $thead .= "<th>".trim($cell)."</th>";
            }
            $thead .= "</tr>\n</thead>";

            // Filas
            $rowLines = preg_split('/\R/', $rowsText);
            $tbody = "<tbody>\n";
            foreach ($rowLines as $rowLine) {
                $rowLine = trim($rowLine);
                if (!$rowLine) continue;
                $cells = explode('|', trim($rowLine, '| '));
                $tbody .= "  <tr>";
                foreach ($cells as $cell) {
                    $tbody .= "<td>".trim($cell)."</td>";
                }
                $tbody .= "</tr>\n";
            }
            $tbody .= "</tbody>";

            return "<table>\n$thead\n$tbody\n</table>\n";
        },
        $markdown
    );

    // -------------------------------------------------------------
    // 13) SEPARADORES (hr) ->  --- o *** en línea sola
    // -------------------------------------------------------------
    $markdown = preg_replace('/^([-*]){3,}$/m', '<hr />', $markdown);

    // -------------------------------------------------------------
    // 14) PÁRRAFOS
    //    Separa por doble salto (\n\n) y envuelve en <p> si no detecta
    //    un tag de bloque principal al principio.
    // -------------------------------------------------------------
    $chunks = preg_split('/\n\s*\n/', trim($markdown));
    $markdown = '';
    foreach ($chunks as $chunk) {
        $trimmed = trim($chunk);
        // Si NO es un tag de bloque al inicio, lo envolvemos en <p>...</p>
        if (!preg_match('/^(<(h[1-6]|ul|ol|blockquote|pre|hr|table|div|thead|tbody|tr|th|td))/i', $trimmed)) {
            $markdown .= '<p>' . $trimmed . "</p>\n";
        } else {
            // Caso contrario, lo dejamos tal cual
            $markdown .= $trimmed . "\n";
        }
    }

    // -------------------------------------------------------------
    // 15) REEMPLAZAR PLACEHOLDERS DE CÓDIGO INLINE
    // -------------------------------------------------------------
    foreach ($inlineCodes as $placeholder => $htmlCode) {
        $markdown = str_replace($placeholder, $htmlCode, $markdown);
    }

    // -------------------------------------------------------------
    // 16) REEMPLAZAR PLACEHOLDERS DE BLOQUES DE CÓDIGO
    // -------------------------------------------------------------
    foreach ($codeBlocks as $placeholder => $htmlCode) {
        $markdown = str_replace($placeholder, $htmlCode, $markdown);
    }

    return $markdown;
}

// --------------------------------------------------------------------
// EJEMPLO DE USO DESDE CLI (php script.php):
// --------------------------------------------------------------------
if (PHP_SAPI === 'cli') {
    // Probemos con tu ejemplo:
    $ejemploMarkdown = <<<MD
## **Códigos y Comandos**

### Código Inline

\`print("Hola, mundo!")\`

### Bloque de Código

\`\`\`python
# Ejemplo de código Python
def saludar():
    print("Hola, mundo!")

saludar()
\`\`\`
MD;

    echo "\n--- MARKDOWN DE EJEMPLO ---\n";
    echo $ejemploMarkdown;

    $resultadoHtml = markdownToHtml($ejemploMarkdown);

    echo "\n\n--- HTML RESULTANTE ---\n";
    echo $resultadoHtml;
    echo "\n\n";
}

