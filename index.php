<?php

session_start();

require_once 'utils/Utilidades.php';
require_once 'App/models/Numeros.php';
require_once 'App/models/Personas.php';
require_once 'App/models/Hospital.php';
require_once 'App/models/Estadisticas.php';
require_once 'App/models/Potencias.php';
require_once 'App/models/EstacionAnio.php';
// 1. Capturamos el problema de la URL de forma segura (si no hay, por defecto es 'menu')
$problema = $_GET['problema'] ?? 'menu';

// 2. Definimos el título dinámico para la pestaña antes de cargar el header
if ($problema === 'menu') {
    $titulo_pagina = "Menú Principal";
} else {
    $titulo_pagina = "Problema #" . $problema;
}

// 3. Cargamos el encabezado común
include 'components/header.php';

// 4. El Switch que evalúa tus casos numéricos del 1 al 9
switch ($problema) {
    case '1':
        include 'App/views/problema1.php';
        break;
    case '2':
        include 'App/views/problema2.php';
        break;
    case '3':
        include 'App/views/problema3.php';
        break;
    case '4':
        include 'App/views/problema4.php';
        break;
    case '5':
        include 'App/views/problema5.php';
        break;
    case '6':
        include 'App/views/problema6.php';
        break;
    case '7':
        include 'App/views/problema7.php';
        break;
    case '8':
        include 'App/views/problema8.php';
        break;
    case '9':
        include 'App/views/problema9.php';
        break;
    case 'menu':
    default:
        include 'App/views/menu.php';
        break;
}

// 5. Cargamos el pie de página común
include 'components/footer.php';
?>