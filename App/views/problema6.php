<?php
// Inyectar el CDN para renderizar el gráfico pastel en el navegador
echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';

$mostrar = false;
$error = "";

$total = 0;
$porGine = 0;
$porTrau = 0;
$porPedia = 0;

$gine_valor = "";
$trau_valor = "";
$pedia_valor = "";

// Procesar cuando el usuario envía el presupuesto por POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calcular'])) {

    //Sanitizar las entradas 
    $gine_sucio = $_POST['ginecologia'] ?? '';
    $trau_sucio = $_POST['traumatologia'] ?? '';
    $pedia_sucio = $_POST['pediatria'] ?? '';

    $gine_valor = Utilidades::sanitizarTexto($gine_sucio);
    $trau_valor = Utilidades::sanitizarTexto($trau_sucio);
    $pedia_valor = Utilidades::sanitizarTexto($pedia_sucio);

    // Validar que las entradas correspondan a expresiones numéricas
    if (
        Utilidades::validarNumero($gine_valor) !== false &&
        Utilidades::validarNumero($trau_valor) !== false &&
        Utilidades::validarNumero($pedia_valor) !== false
    ) {

        $gine_float = (float) $gine_valor;
        $trau_float = (float) $trau_valor;
        $pedia_float = (float) $pedia_valor;

        //No permitir presupuestos negativos
        if ($gine_float >= 0 && $trau_float >= 0 && $pedia_float >= 0) {

            // Evitar que la sumatoria total sea cero para que no ocurra división entre cero en el modelo
            if (($gine_float + $trau_float + $pedia_float) > 0) {

                //Instanciar tu modelo Hospital
                $hospital = new Hospital($gine_float, $trau_float, $pedia_float);

                $total = $hospital->obtenerTotal();
                $porGine = $hospital->porcentajeGinecologia();
                $porTrau = $hospital->porcentajeTraumatologia();
                $porPedia = $hospital->porcentajePediatria();

                $mostrar = true;
            } else {
                $error = "El presupuesto acumulado global debe ser superior a B/. 0.00.";
            }
        } else {
            $error = "Los montos asignados no pueden ser valores negativos.";
        }
    } else {
        $error = "Por favor, introduzca montos numéricos válidos en los tres campos.";
    }
}
?>

<section>
    <h1>Distribución Presupuestaria Hospitalaria</h1>
    <p>Introduzca el presupuesto anual asignado a cada división médica para calcular el balance totalizado y su
        ponderación porcentual.</p>

    <form action="index.php?problema=6" method="POST">
        <div>
            <label for="ginecologia">Presupuesto Ginecología (B/.):</label>
            <input type="number" step="0.01" id="ginecologia" name="ginecologia" placeholder="0.00"
                value="<?php echo $gine_valor; ?>" required>
        </div>

        <div>
            <label for="traumatologia">Presupuesto Traumatología (B/.):</label>
            <input type="number" step="0.01" id="traumatologia" name="traumatologia" placeholder="0.00"
                value="<?php echo $trau_valor; ?>" required>
        </div>

        <div>
            <label for="pediatria">Presupuesto Pediatría (B/.):</label>
            <input type="number" step="0.01" id="pediatria" name="pediatria" placeholder="0.00"
                value="<?php echo $pedia_valor; ?>" required>
        </div>

        <button type="submit" name="calcular">Calcular Distribución</button>
    </form>

    <?php if ($error !== ""): ?>
        <div style="margin-top: 15px; color: red;">
            <p>⚠️ <?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <?php if ($mostrar): ?>
        <hr style="margin-top: 25px;">
        <h2>📊 Reporte Financiero Consolidador</h2>

        <div>
            <h3>Presupuesto Total Evaluado:</h3>
            <h4>B/. <?php echo number_format($total, 2); ?></h4>
        </div>

        <table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th>Área Médica</th>
                    <th>Monto Asignado</th>
                    <th>Porcentaje Equivalente</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Ginecología</td>
                    <td>B/. <?php echo number_format($gine_float, 2); ?></td>
                    <td><strong><?php echo number_format($porGine, 2); ?>%</strong></td>
                </tr>
                <tr>
                    <td>Traumatología</td>
                    <td>B/. <?php echo number_format($trau_float, 2); ?></td>
                    <td><strong><?php echo number_format($porTrau, 2); ?>%</strong></td>
                </tr>
                <tr>
                    <td>Pediatría</td>
                    <td>B/. <?php echo number_format($pedia_float, 2); ?></td>
                    <td><strong><?php echo number_format($porPedia, 2); ?>%</strong></td>
                </tr>
            </tbody>
        </table>

        <h3>Distribución Porcentual Relativa</h3>
        <div style="max-width: 350px; margin: 0 auto;">
            <canvas id="graficaPresupuesto"></canvas>
        </div>

        <script>
            new Chart(
                document.getElementById('graficaPresupuesto'),
                {
                    type: 'pie',
                    data: {
                        labels: ['Ginecología', 'Traumatología', 'Pediatría'],
                        datasets: [{
                            data: [
                                <?php echo $gine_float; ?>,
                                <?php echo $trau_float; ?>,
                                <?php echo $pedia_float; ?>
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 236, 0.7)',
                                'rgba(255, 206, 86, 0.7)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 236, 1)',
                                'rgba(255, 206, 86, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                }
            );
        </script>
    <?php endif; ?>
</section>