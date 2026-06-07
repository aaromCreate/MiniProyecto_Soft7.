<?php

// Se carga el modelo encargado de generar las potencias
// del número ingresado por el usuario.
require_once __DIR__ . '/../models/Potencias.php';

// Variables para almacenar los resultados generados
// y posibles mensajes de error.
$resultados = [];
$error = '';

// Verifica que la solicitud haya sido enviada mediante POST.
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    // Valida que el valor ingresado sea un número válido.
    $numero = Utilidades::validarNumero($_POST['numero']);

    // Comprueba que el número se encuentre dentro del rango permitido.
    if($numero === false || $numero < 1 || $numero > 9)
    {
        $error = "Debe ingresar un número entre 1 y 9.";
    }
    else
    {
        // Genera las primeras 15 potencias del número ingresado.
        $resultados = Potencias::generar($numero);
    }
}
?>

<section>

    <!-- Contenedor principal del formulario -->
    <div class="formulario-estadisticas">

        <h2>Problema 9 - Potencias</h2>

        <!-- Formulario para solicitar el número base -->
        <form method="POST">

            <label>Número (1-9)</label>

            <input
                type="number"
                min="1"
                max="9"
                name="numero"
                required
            >

            <button type="submit">
                Generar
            </button>

        </form>

        <!-- Muestra un mensaje de error si la validación falla -->
        <?php if($error): ?>

        <p>
            <?= Utilidades::sanitizarTexto($error) ?>
        </p>

        <?php endif; ?>

        <!-- Muestra la tabla de resultados cuando existen potencias generadas -->
        <?php if(!empty($resultados)): ?>

        <table border="1">

            <!-- Encabezados de la tabla -->
            <tr>
                <th>Potencia</th>
                <th>Resultado</th>
            </tr>

            <!-- Recorre el arreglo de potencias para mostrarlas -->
            <?php foreach($resultados as $fila): ?>

            <tr>

                <!-- Muestra la operación realizada -->
                <td>
                    <?= $numero . '^' . $fila['exponente'] ?>
                </td>

                <!-- Muestra el resultado de la potencia -->
                <td>
                    <?= $fila['resultado'] ?>
                </td>

            </tr>

            <?php endforeach; ?>

        </table>

        <?php endif; ?>

    </div>

</section>