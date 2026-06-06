</main>
<footer>
    <?php
    $problema_actual = $_GET['problema'] ?? 'menu';
    if ($problema_actual !== 'menu') {
        echo '<p><a href="index.php?problema=menu" class="btn-volver">← Volver al Menú Principal</a></p><br>';
    }
    ?>
    <p>Fecha:
        <?php echo date('d/m/Y'); ?>
    </p>
    <p>© 2026 - Universidad Tecnológica de Panamá</p>
</footer>
</body>

</html>