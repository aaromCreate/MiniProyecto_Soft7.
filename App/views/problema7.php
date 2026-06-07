<?php

// Se carga el modelo encargado de realizar los cálculos estadísticos.
require_once __DIR__ . '/../models/Estadisticas.php';

// Variables para almacenar el resultado de los cálculos y posibles errores.
$resultado = null;
$error = '';

// Verifica que la petición sea de tipo POST y que existan notas enviadas.
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['nota'])
) {

    // Obtiene la cantidad de notas ingresadas.
    $cantidad = count($_POST['nota']);

    // Arreglo que almacenará las notas validadas.
    $notas = [];

    // Recorre cada nota enviada por el formulario.
    for ($i = 0; $i < $cantidad; $i++) {

        // Valida que la nota ingresada sea un número válido.
        $nota = Utilidades::validarNumero($_POST['nota'][$i]);

        // Si alguna nota no es válida, se genera un mensaje de error.
        if ($nota === false) {
            $error = "Todas las notas deben ser numéricas.";
            break;
        }

        // Agrega la nota validada al arreglo.
        $notas[] = $nota;
    }

    // Si no existen errores, realiza el cálculo estadístico.
    if (empty($error)) {
        $resultado = Estadisticas::calcular($notas);
    }
}
?>

<section>

<div class="formulario-estadisticas">

    <!-- Título principal del problema -->
    <h2>Problema 7 - Estadísticas</h2>

    <!-- Formulario inicial para indicar cuántas notas serán ingresadas -->
    <form method="POST">

        <label>Cantidad de notas:</label>

        <input
            type="number"
            name="cantidad"
            min="1"
            required
        >

        <button type="submit">
            Generar Campos
        </button>

    </form>

</div>

<?php

// Si se ha indicado la cantidad de notas y aún no se han enviado las notas,
// se generan dinámicamente los campos de entrada.
if (
    isset($_POST['cantidad'])
    && !isset($_POST['nota'])
)
{
    $cantidad = (int) $_POST['cantidad'];
?>

<div class="formulario-notas">

    <!-- Formulario para capturar las notas del estudiante -->
    <form method="POST">

        <!-- Conserva la cantidad de notas entre envíos -->
        <input
            type="hidden"
            name="cantidad"
            value="<?= $cantidad ?>"
        >

        <?php for($i = 0; $i < $cantidad; $i++): ?>

            <!-- Campo dinámico para cada nota -->
            <p>
                Nota <?= $i + 1 ?>

                <input
                    type="number"
                    step="0.01"
                    name="nota[]"
                    required
                >
            </p>

        <?php endfor; ?>

        <button type="submit" name="calcular">
            Calcular
        </button>

    </form>

</div>

<?php } ?>

<!-- Muestra mensajes de error si existen problemas de validación -->
<?php if($error): ?>

<p>
    <?= Utilidades::sanitizarTexto($error) ?>
</p>

<?php endif; ?>

<!-- Muestra los resultados estadísticos una vez realizados los cálculos -->
<?php if($resultado): ?>

<div class="estadisticas-container">

    <h3>Resultados Estadísticos</h3>

    <div class="estadisticas-grid">

        <!-- Tarjeta que muestra el promedio de las notas -->
        <div class="estadistica-card">
            <h4>Promedio</h4>
            <span><?= $resultado['promedio'] ?></span>
        </div>

        <!-- Tarjeta que muestra la desviación estándar -->
        <div class="estadistica-card">
            <h4>Desviación Estándar</h4>
            <span><?= $resultado['desviacion'] ?></span>
        </div>

        <!-- Tarjeta que muestra la nota mínima -->
        <div class="estadistica-card">
            <h4>Nota Mínima</h4>
            <span><?= $resultado['minimo'] ?></span>
        </div>

        <!-- Tarjeta que muestra la nota máxima -->
        <div class="estadistica-card">
            <h4>Nota Máxima</h4>
            <span><?= $resultado['maximo'] ?></span>
        </div>

    </div>

</div>

<?php endif; ?>

</section>