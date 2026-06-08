<?php
// Inyección del motor de gráficos Chart.js mediante CDN en la vista
echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';

// Inicializar el espacio en la sesión para recolectar las edades
if (!isset($_SESSION['edades_taller'])) {
    $_SESSION['edades_taller'] = [];
}

$error = "";
$procesado = false;
$clasificaciones = [];
$estadisticas = ['Niños' => 0, 'Adolescentes' => 0, 'Adultos' => 0, 'Adultos Mayores' => 0];
$repetidas = [];

//Acción: AGREGAR EDAD
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
    $entrada_sucia = $_POST['edad'] ?? '';
    $edad_sanitizada = Utilidades::sanitizarTexto($entrada_sucia);

    if (Utilidades::validarNumero($edad_sanitizada) !== false) {
        $edad_int = (int) $edad_sanitizada;

        if ($edad_int >= 0 && $edad_int <= 125) {
            $_SESSION['edades_taller'][] = $edad_int;
        } else {
            $error = "Por favor, introduzca una edad coherente (entre 0 y 125 años).";
        }
    } else {
        $error = "La edad introducida debe ser un número entero válido.";
    }
}


// Acción: ELIMINAR ÚLTIMA
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    if (count($_SESSION['edades_taller']) > 0) {
        array_pop($_SESSION['edades_taller']);
    }
}

// Acción: REINICIAR TODO
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reiniciar'])) {
    $_SESSION['edades_taller'] = [];
    echo '<script>window.location.href="index.php?problema=5";</script>';
    exit;
}

// 4. Acción: PROCESAR ESTADÍSTICAS
if (isset($_POST['procesar']) && count($_SESSION['edades_taller']) > 0) {

    // Instanciamos modelo Personas 
    $clasificador = new Personas($_SESSION['edades_taller']);

    // Invocamos los métodos de procesamiento OO
    $clasificaciones = $clasificador->obtenerClasificaciones();
    $estadisticas = $clasificador->obtenerEstadisticas();
    $repetidas = $clasificador->obtenerRepetidas();

    $procesado = true;
}
?>

<section>
    <h1>Clasificación Dinámica de Edades</h1>
    <p>Agregue las edades correspondientes. Al finalizar la inserción, presione "Procesar" para generar las métricas y
        la gráfica estadística.</p>

    <form action="index.php?problema=5" method="POST">
        <div>
            <label for="edad">Edad de la persona:</label>
            <input type="number" id="edad" name="edad" min="0" placeholder="Ejenga una edad" required>
            <button type="submit" name="agregar">Agregar Edad</button>
        </div>
    </form>

    <div>
        <strong>Personas registradas actualmente: [ <?php echo count($_SESSION['edades_taller']); ?> ]</strong>
        <hr>
        <?php if (count($_SESSION['edades_taller']) > 0): ?>
            <ul>
                <?php foreach ($_SESSION['edades_taller'] as $i => $edad): ?>
                    <li>Persona <?php echo ($i + 1); ?>: <strong><?php echo $edad; ?></strong> años</li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay edades registradas en la memoria de sesión.</p>
        <?php endif; ?>
    </div>

    <div style="margin-top: 15px; display: flex; gap: 10px;">
        <form action="index.php?problema=5" method="POST">
            <button type="submit" name="procesar" <?php echo count($_SESSION['edades_taller']) === 0 ? 'disabled' : ''; ?>>Procesar Datos</button>
            <button type="submit" name="eliminar" <?php echo count($_SESSION['edades_taller']) === 0 ? 'disabled' : ''; ?>
                formnovalidate>Eliminar Última</button>
            <button type="submit" name="reiniciar" formnovalidate>Reiniciar Todo</button>
        </form>
    </div>

    <?php if ($error !== ""): ?>
        <div style="margin-top: 15px; color: red;">
            <p>⚠️ <?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <?php if ($procesado): ?>
        <hr style="margin-top: 25px;">
        <h2>📊 Reporte Demográfico Generado</h2>

        <h3>1. Clasificación por Individuo</h3>
        <table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th>Persona</th>
                    <th>Edad Registrada</th>
                    <th>Categoría Asignada</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['edades_taller'] as $i => $edad): ?>
                    <tr>
                        <td>Persona <?php echo $i + 1; ?></td>
                        <td><?php echo $edad; ?> años</td>
                        <td><strong><?php echo $clasificaciones[$i]; ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>2. Frecuencia de Edades Repetidas</h3>
        <div>
            <?php if (count($repetidas) > 0): ?>
                <ul>
                    <?php foreach ($repetidas as $edad => $cantidad): ?>
                        <li>La edad <strong><?php echo $edad; ?></strong> aparece <strong><?php echo $cantidad; ?></strong> veces.
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No existen edades repetidas.</p>
            <?php endif; ?>
        </div>

        <h3>3. Estadísticas Generales (Conteo)</h3>
        <div>
            Niños: <?php echo $estadisticas['Niños']; ?><br>
            Adolescentes: <?php echo $estadisticas['Adolescentes']; ?><br>
            Adultos: <?php echo $estadisticas['Adultos']; ?><br>
            Adultos Mayores: <?php echo $estadisticas['Adultos Mayores']; ?>
        </div>

        <h3>4. Visualización Gráfica</h3>
        <div style="max-width: 500px; margin: 0 auto;">
            <canvas id="grafica"></canvas>
        </div>

        <script>
            new Chart(
                document.getElementById('grafica'),
                {
                    type: 'bar',
                    data: {
                        labels: ['Niños', 'Adolescentes', 'Adultos', 'Adultos Mayores'],
                        datasets: [{
                            label: 'Cantidad de Personas',
                            data: [
                                <?php echo $estadisticas['Niños']; ?>,
                                <?php echo $estadisticas['Adolescentes']; ?>,
                                <?php echo $estadisticas['Adultos']; ?>,
                                <?php echo $estadisticas['Adultos Mayores']; ?>
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1 }
                            }
                        }
                    }
                }
            );
        </script>
    <?php endif; ?>
</section>