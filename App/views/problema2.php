<?php
$procesado = false;
$resultado_suma = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_calcular'])) {

    // Pasamos un array vacío [] al constructor ya que los métodos del problema 1 no se usarán aqui
    $matematica = new Numeros([]);

    $resultado_suma = $matematica->calcularSumaHastaMil();

    $procesado = true;
}
?>

<section>
    <h2>Problema 2: Estructuras Repetitivas (Sumatoria del 1 al 1,000)</h2>
    <p>Desarrolle un script en PHP que calcule y muestre la suma acumulada de todos los números enteros comprendidos
        entre el 1 y el 1,000 utilizando un bucle controlado.</p>

    <form action="index.php?problema=2" method="POST">
        <p>Presione el siguiente botón para iniciar el ciclo de conteo iterativo en el servidor:</p>
        <button type="submit" name="btn_calcular">Calcular Sumatoria</button>
    </form>

    <?php if ($procesado): ?>
        <div>
            <h3>📊 Resultado del Cálculo:</h3>
            <p>La sumatoria acumulada de los números del <strong>1 al 1,000</strong> es:</p>
            <p><strong>Resultado:</strong>
                <?php echo number_format($resultado_suma); ?>
            </p>

            <div>
                <p><em>Nota conceptual: El proceso se ejecutó mediante un bucle iterativo de tipo <code>for</code> que
                        recorrió secuencialmente cada unidad incrementando el acumulador del objeto.</em></p>
            </div>
        </div>
    <?php endif; ?>
</section>