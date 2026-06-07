<?php
$resultado = false;
$error = "";

$sumaPares = 0;
$sumaImpares = 0;
$pares = [];
$impares = [];

// Valores iniciales recomendados por el enunciado del problema (1 a 200)
$inicio_valor = "1";
$fin_valor = "200";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calcular'])) {

    $inicio_sucio = $_POST['inicio'] ?? '';
    $fin_sucio = $_POST['fin'] ?? '';

    $inicio_valor = Utilidades::sanitizarTexto($inicio_sucio);
    $fin_valor = Utilidades::sanitizarTexto($fin_sucio);

    //Validar que las entradas sean números válidos
    if (Utilidades::validarNumero($inicio_valor) !== false && Utilidades::validarNumero($fin_valor) !== false) {

        $inicio_int = (int) $inicio_valor;
        $fin_int = (int) $fin_valor;

        if ($inicio_int >= $fin_int) {
            $error = "El número inicial debe ser menor que el número final.";
        } else {

            $numeros = new Numeros([]);

            $numeros->inicializarRango($inicio_int, $fin_int);

            $sumaPares = $numeros->sumarPares();
            $sumaImpares = $numeros->sumarImpares();
            $pares = $numeros->obtenerPares();
            $impares = $numeros->obtenerImpares();

            $resultado = true;
        }
    } else {
        $error = "Por favor, introduzca valores numéricos enteros válidos.";
    }
}
?>

<section>
    <h1>Suma de Números Pares e Impares</h1>
    <p>Ingrese un número inicial y un número final para calcular de forma independiente sus sumas y listados
        correspondientes.</p>

    <form action="index.php?problema=4" method="POST">
        <div>
            <label for="inicio">Número Inicial:</label>
            <input type="number" id="inicio" name="inicio" value="<?php echo $inicio_valor; ?>" required>
        </div>

        <div>
            <label for="fin">Número Final:</label>
            <input type="number" id="fin" name="fin" value="<?php echo $fin_valor; ?>" required>
        </div>

        <button type="submit" name="calcular">Calcular</button>
    </form>

    <?php if ($error != ""): ?>
        <div>
            <h3>⚠️ Alerta:</h3>
            <p><?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <?php if ($resultado): ?>
        <div>
            <h2>📊 Resultados del Rango [<?php echo $inicio_int; ?> - <?php echo $fin_int; ?>]:</h2>

            <div>
                <h3>Suma de Pares</h3>
                <div>
                    <strong>Total:</strong> <?php echo number_format($sumaPares); ?>
                </div>
            </div>

            <div>
                <h3>Suma de Impares</h3>
                <div>
                    <strong>Total:</strong> <?php echo number_format($sumaImpares); ?>
                </div>
            </div>

            <br>
            <div>
                <strong>Números pares encontrados:</strong>
                <p><?php echo count($pares) > 0 ? implode(", ", $pares) : "Ninguno"; ?></p>
            </div>

            <div>
                <strong>Números impares encontrados:</strong>
                <p><?php echo count($impares) > 0 ? implode(", ", $impares) : "Ninguno"; ?></p>
            </div>
        </div>
    <?php endif; ?>
</section>