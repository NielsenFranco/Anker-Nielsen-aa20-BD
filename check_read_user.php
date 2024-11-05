<?php
// Conexión a la base de datos PostgreSQL usando PDO
$host = 'localhost';
$dbname = 'company_db';
$user = 'read_user'; // Usuario con permisos limitados
$pass = '123'; 

try {
    // Crear conexión usando PDO
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa.<br>";

    // Intento de operación SELECT
    try {
        $stmt = $pdo->query("SELECT * FROM employees");
        echo "Operación SELECT ejecutada correctamente.<br>";

        // Mostrar resultados (si hay)
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "ID: " . $row['id'] . " - Nombre: " . $row['nombre'] . " - Apellido: " . $row['apellido'] . " - Departamento: " . $row['departamento'] . "<br>";
        }
    } catch (Exception $e) {
        echo "Error en SELECT: " . $e->getMessage() . "<br>";
    }

    // Intento de operación INSERT
    try {
        $stmt = $pdo->prepare("INSERT INTO employees (nombre, apellido, departamento) VALUES (:nombre, :apellido, :departamento)");
        $stmt->execute([':nombre' => 'Maria', ':apellido' => 'Gonzalez', ':departamento' => 'Recursos Humanos']);
        echo "Operación INSERT ejecutada correctamente.<br>";
    } catch (Exception $e) {
        echo "Error en INSERT: " . $e->getMessage() . "<br>";
    }

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
