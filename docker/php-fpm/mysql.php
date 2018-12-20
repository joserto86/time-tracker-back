<?php

$mysqli = new \mysqli('mysql', 'root', 'example', 'example');
if ($mysqli->connect_errno !== 0) {
    echo 'Error: Fallo al conectarse a MySQL debido a:' . PHP_EOL;
    echo 'Errno: ' . $mysqli->connect_errno . PHP_EOL;
    echo 'Error: ' . $mysqli->connect_error . PHP_EOL;
    exit;
}

$sql = 'SELECT * FROM user';
$resultado = $mysqli->query($sql);

if ($resultado === false) {
    // ¡Oh, no! La consulta falló.
    echo 'Lo sentimos, este sitio web está experimentando problemas.' . PHP_EOL;

    // De nuevo, no hacer esto en un sitio público, aunque nosotros mostraremos
    // cómo obtener información del error
    echo 'Error: La ejecución de la consulta falló debido a:' . PHP_EOL;
    echo 'Query: ' . $sql . '\n';
    echo 'Errno: ' . $mysqli->errno . PHP_EOL;
    echo 'Error: ' . $mysqli->error . PHP_EOL;
    exit;
}

if ($resultado->num_rows === 0) {
    echo 'No hay resultados' . PHP_EOL;
    exit;
}

while ($user = $resultado->fetch_assoc()) {
    echo sprintf('[%s] %s', $user['id'], $user['username']) . PHP_EOL;
}

$resultado->free();
$mysqli->close();
