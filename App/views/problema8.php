<?php

// Variables para almacenar la fecha ingresada y el resultado obtenido.
$fechaSeleccionada = '';
$resultado = null;

// Verifica que la solicitud haya sido enviada mediante POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtiene la fecha enviada desde el formulario.
    $fechaSeleccionada = $_POST['fecha'];

    // Comprueba que la fecha no esté vacía antes de procesarla.
    if (!empty($fechaSeleccionada)) {

        // Llama al modelo para determinar la estación correspondiente.
        $resultado = EstacionAnio::obtenerEstacion($fechaSeleccionada);
    }
}

?>

<section>

    <!-- Contenedor principal del formulario -->
    <div class="formulario-estacion">

        <h2>Problema 8 - Estación del Año</h2>

        <!-- Formulario para seleccionar una fecha -->
        <form method="POST">

            <label>Seleccione una fecha:</label>

            <!-- Agrupa el control de fecha y el botón -->
            <div class="controles-estacion">

                <input type="date" name="fecha" required>

                <button type="submit">
                    Consultar
                </button>

            </div>

        </form>

    </div>

    <!-- Muestra el resultado únicamente cuando existe una estación calculada -->
    <?php if ($resultado): ?>

        <div class="resultado-estacion">

            <!-- Tarjeta que contiene la información de la estación -->
            <div class="estacion-card">

                <h3>Resultado</h3>

                <!-- Muestra la fecha ingresada por el usuario -->
                <p>
                    <strong>Fecha ingresada:</strong>

                    <?= htmlspecialchars(
                        date('d/m/Y', strtotime($fechaSeleccionada))
                    ) ?>
                </p>

                <!-- Muestra el nombre de la estación obtenida -->
                <p>
                    <strong>Estación:</strong>

                    <?= htmlspecialchars($resultado['nombre']) ?>
                </p>

                <!-- Muestra una imagen representativa de la estación -->
                <img src="assets/<?= htmlspecialchars($resultado['imagen']) ?>"
                    alt="<?= htmlspecialchars($resultado['nombre']) ?>">

            </div>

        </div>

    <?php endif; ?>

</section>