<?php
$directory = '/path/to/your/pdf/folder';
$files = glob($directory . "*.pdf");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Informes PDF</title>
</head>
<body>
    <h1>Lista de Informes PDF</h1>
    <ul>
        <?php foreach ($files as $file): ?>
            <li>
                <a href="<?php echo $file; ?>" target="_blank">
                    <?php echo basename($file); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
