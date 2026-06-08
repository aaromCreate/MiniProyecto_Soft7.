<?php
// Asegurar que el espacio en sesión exista para almacenar los números
if (!isset($_SESSION['numerosTaller'])) {
    $_SESSION['numerosTaller'] = [];
}

$error = "";
$procesado = false;
$mensajeRegistro = "";
$media = 0;
$desviacion = 0;
$minimo = 0;
$maximo = 0;
$datosAnalizados = [];

// Si el usuario decide limpiar el progreso y empezar de nuevo
if (isset($_POST['btn_reiniciar'])) {
    $_SESSION['numerosTaller'] = [];
}

// Procesar cuando el usuario envía un número
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_enviar'])) {

    // Sanitizar la entrada 
    $entradaSucia = $_POST['numeroIngresado'] ?? '';
    $numeroSanitizado = Utilidades::sanitizarTexto($entradaSucia);

    // Validar que sea un número válido
    if (Utilidades::validarNumero($numeroSanitizado) !== false) {
        $numeroFloat = (float) $numeroSanitizado;

        if ($numeroFloat > 0) {

            // Si aún faltan números, lo guardamos en la sesión
            if (count($_SESSION['numerosTaller']) < 5) {
                $_SESSION['numerosTaller'][] = $numeroFloat;
                $mensajeRegistro = "Número " . $numeroFloat . " registrado.";
            }

        } else {
            $error = "El número introducido debe ser positivo (mayor que 0).";
        }
    } else {
        $error = "Por favor, introduzca un valor numérico válido.";
    }
}

//Verificar si ya se recolectaron los 5 números requeridos
$conteoActual = count($_SESSION['numerosTaller']);

if ($conteoActual === 5) {
    $analizador = new Numeros($_SESSION['numerosTaller']);

    $media = $analizador->calcularMedia();
    $desviacion = $analizador->calcularDesviacionEstandar();
    $minimo = $analizador->obtenerMinimo();
    $maximo = $analizador->obtenerMaximo();

    $procesado = true;

    // Guardamos una copia temporal para mostrar en el reporte antes de limpiar la sesión
    $datosAnalizados = $_SESSION['numerosTaller'];

    // Vaciar la sesión para que quede listo para un nuevo cálculo
    $_SESSION['numerosTaller'] = [];
}
?>

<section>
    <h2>Problema 1: Estadísticas de Números Positivos</h2>

    <?php if (!$procesado): ?>
        <p>Introduzca 5 números positivos uno a uno. El sistema calculará automáticamente las estadísticas al completar el
            quinto valor.</p>
        <p><strong>Progreso:</strong>
            <?php echo $conteoActual; ?> de 5 números guardados.
        </p>

        <?php if ($conteoActual > 0): ?>
            <p>Valores actuales en memoria: [
                <?php echo implode(', ', $_SESSION['numerosTaller']); ?>]
            </p>
        <?php endif; ?>

        <form action="index.php?problema=1" method="POST">
            <div>
                <label for="numeroIngresado">Número Positivo (#<?php echo ($conteoActual + 1); ?>):
                </label>
                <input type="number" step="0.0001" id="numeroIngresado" name="numeroIngresado" required autofocus>
            </div>
            <button type="submit" name="btn_enviar">Registrar</button>

            <?php if ($conteoActual > 0): ?>
                <button type="submit" name="btn_reiniciar" formnovalidate>Reiniciar</button>
            <?php endif; ?>
        </form>


    <?php endif; ?>

    <?php if ($mensajeRegistro !== "" && !$procesado): ?>
        <div>
            <p>✅<?php echo $mensajeRegistro; ?></p>
        </div>
    <?php endif; ?>

    <?php if ($error !== ""): ?>
        <div>
            <h3>⚠️ Alerta:</h3>
            <p>
                <?php echo $error; ?>
            </p>
        </div>
    <?php endif; ?>

    <?php if ($procesado): ?>
        <div>
            <h3>📊Resultados Estadísticos:</h3>
            <p><strong>Conjunto de datos analizado:</strong> [
                <?php echo implode(', ', $datosAnalizados); ?>]
            </p>

            <ul>
                <li><strong>Media (Promedio):</strong>
                    <?php echo number_format($media, 4); ?>
                </li>
                <li><strong>Desviación Estándar:</strong>
                    <?php echo number_format($desviacion, 4); ?>
                </li>
                <li><strong>Valor Mínimo:</strong>
                    <?php echo $minimo; ?>
                </li>
                <li><strong>Valor Máximo:</strong>
                    <?php echo $maximo; ?>
                </li>
            </ul>

            <br>
            <form action="index.php?problema=1" method="POST">
                <button type="submit">Calcular un nuevo grupo</button>
            </form>
        </div>
    <?php endif; ?>
</section>