<?php
$titulo_pestana = isset($titulo_pagina) ? htmlspecialchars($titulo_pagina) : "Mini Proyecto #2";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $titulo_pestana; ?> | UTP FISC
    </title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <header>
        <div class="header-sistema">
            <h1>Estructuras de Control y Clases en PHP</h1>
            <p>Mini Proyecto #1 - Desarrollo Web VII</p>
        </div>
    </header>

    <main class="container">