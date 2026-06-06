<?php
// Asegurar que el espacio en sesión exista para almacenar los números
if (!isset($_SESSION['numeros_taller'])) {
    $_SESSION['numeros_taller'] = [];
}

// Inicializar variables de la interfaz
$error = "";
$procesado = false;
$mensaje_registro = "";

$media = 0;
$desviacion = 0;
$minimo = 0;
$maximo = 0;
$datos_analizados = [];

// Si el usuario decide limpiar el progreso y empezar de nuevo
if (isset($_POST['btn_reiniciar'])) {
    $_SESSION['numeros_taller'] = [];
}

// Procesar cuando el usuario envía un número
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_enviar'])) {

    // 1. Sanitizar la entrada usando tu clase Utilidades (utils/Utilidades.php)
    $entrada_sucia = $_POST['numero_ingresado'] ?? '';
    $numero_sanitizado = Utilidades::sanitizarTexto($entrada_sucia);

    // 2. Validar que sea un número válido
    if (Utilidades::validarNumero($numero_sanitizado) !== false) {
        $numero_float = (float) $numero_sanitizado;

        // Regla del problema: Debe ser estrictamente positivo (mayor que 0)
        if ($numero_float > 0) {

            // Si aún faltan números, lo guardamos en la sesión
            if (count($_SESSION['numeros_taller']) < 5) {
                $_SESSION['numeros_taller'][] = $numero_float;
                $mensaje_registro = "Número " . $numero_float . " registrado.";
            }

        } else {
            $error = "El número introducido debe ser positivo (mayor que 0).";
        }
    } else {
        $error = "Por favor, introduzca un valor numérico válido.";
    }
}

// 3. Verificar si ya se recolectaron los 5 números requeridos
$conteo_actual = count($_SESSION['numeros_taller']);

if ($conteo_actual === 5) {
    // 4. Instanciar tu modelo modificado "Numeros" con los datos guardados
    $analizador = new Numeros($_SESSION['numeros_taller']);

    // Ejecutar los métodos del modelo
    $media = $analizador->calcularMedia();
    $desviacion = $analizador->calcularDesviacionEstandar();
    $minimo = $analizador->obtenerMinimo();
    $maximo = $analizador->obtenerMaximo();

    $procesado = true;

    // Guardamos una copia temporal para mostrar en el reporte antes de limpiar la sesión
    $datos_analizados = $_SESSION['numeros_taller'];

    // Vaciar la sesión para que quede listo para un nuevo cálculo
    $_SESSION['numeros_taller'] = [];
}
?>

<section>
    <h2>Problema 1: Estadísticas de Números Positivos</h2>

    <?php if (!$procesado): ?>
        <p>Introduzca 5 números positivos uno a uno. El sistema calculará automáticamente las estadísticas al completar el
            quinto valor.</p>
        <p><strong>Progreso:</strong>
            <?php echo $conteo_actual; ?> de 5 números guardados.
        </p>

        <?php if ($conteo_actual > 0): ?>
            <p>Valores actuales en memoria: [
                <?php echo implode(', ', $_SESSION['numeros_taller']); ?>]
            </p>
        <?php endif; ?>

        <form action="index.php?problema=1" method="POST">
            <div>
                <label for="numero_ingresado">Número Positivo (#
                    <?php echo ($conteo_actual + 1); ?>):
                </label>
                <input type="number" step="0.0001" id="numero_ingresado" name="numero_ingresado" required autofocus>
            </div>
            <button type="submit" name="btn_enviar">Registrar</button>

            <?php if ($conteo_actual > 0): ?>
                <button type="submit" name="btn_reiniciar" formnovalidate>Reiniciar</button>
            <?php endif; ?>
        </form>
    <?php endif; ?>

    <?php if ($mensaje_registro !== "" && !$procesado): ?>
        <div>
            <p>✅
                <?php echo $mensaje_registro; ?>
            </p>
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
            <h3>📊 Resultados Estadísticos:</h3>
            <p><strong>Conjunto de datos analizado:</strong> [
                <?php echo implode(', ', $datos_analizados); ?>]
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