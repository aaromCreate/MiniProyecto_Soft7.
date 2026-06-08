<?php
$error = "";
$procesado = false;
$listaMultiplos = [];
$nValor = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitizar la entrada
    $entradaSucia = $_POST['cantidadN'] ?? '';
    $nValor = Utilidades::sanitizarTexto($entradaSucia);

    // Validar que la entrada sea un número entero válido
    if (Utilidades::validarNumero($nValor) !== false) {
        $nInt = (int) $nValor;

        if ($nInt >= 1) {

            // Control preventivo de usabilidad para evitar colgar el navegador al renderizar la lista
            if ($nInt <= 2000) {
                // 3. Instanciar el objeto de negocio (enviamos un array vacío ya que no usaremos los métodos del problema 1)
                $matematica = new Numeros([]);

                // 4. Invocar el método que genera los múltiplos
                $listaMultiplos = $matematica->generarMultiplosDeCuatro($nInt);
                $procesado = true;
            } else {
                $error = "Por cuestiones de rendimiento y para evitar un desbordamiento visual, introduzca un valor de N menor o igual a 2000";
            }

        } else {
            $error = "El valor de N debe ser un número entero estrictamente positivo (mayor o igual a 1)";
        }
    } else {
        $error = "Introduzca un número entero válido.";
    }
}
?>

<section>
    <h2>Problema 3: Múltiplos de 4 y Análisis de Desbordamiento</h2>
    <p>Desarrolle un script en PHP que imprima los N-primeros múltiplos de 4 (4*1, 4*2, 4*3...)
        basándose en el límite numérico introducido por teclado.</p>

    <form action="index.php?problema=3" method="POST">
        <div>
            <label for="cantidad_n">Cantidad de múltiplos a generar (N):</label>
            <input type="number" id="cantidadN" name="cantidadN" value="<?php echo $nValor; ?>" min="1" required>
        </div>

        <button type="submit">Generar Secuencia</button>
    </form>

    <?php if ($error !== ""): ?>
        <div>
            <h3>Alerta de Validación:</h3>
            <p>
                <?php echo $error; ?>
            </p>
        </div>
    <?php endif; ?>

    <?php if ($procesado): ?>
        <div>
            <h3>📊 Tabla de Multiplicación Generada (N =
                <?php echo $nInt; ?>):
            </h3>

            <ul>
                <?php foreach ($listaMultiplos as $multiplicador => $resultado): ?>
                    <li>4 ×
                        <?php echo $multiplicador; ?> = <strong>
                            <?php echo $resultado; ?>
                        </strong>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div>
                <h4>Concepto de Desbordamiento (Overflow) en la Aplicación:</h4>
                <p class="desbordamiento">
                    <strong>¿Desbordamiento?:
                        <br><br>
                    </strong> En entornos de ejecución PHP de 64 bits, el límite máximo para un
                    número entero está definido por la constante interna <code>PHP_INT_MAX</code>
                    ($9,223,372,036,854,775,807$).
                    Si la operación matemática multiplicadora excede dicho umbral, PHP mitiga el desbordamiento
                    transformando automáticamente el entero en un tipo de dato decimal de punto flotante (<em>Float</em>) o
                    retornando el valor especial <em>INF (Infinito)</em>.
                    En este código, dicha condición se inspecciona de manera segura dentro del objeto de negocio para
                    detener la iteración ante cualquier anomalía de bits.
                </p>
            </div>
        </div>
    <?php endif; ?>
</section>