<?php
// Conexión a la base de datos PostgreSQL usando PDO
$host = 'localhost';
$dbname = 'company_db'; // Nombre base de datos
$user = 'manager2'; // Usuario 
$pass = '123'; // Contraseña 

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa como $user<br>";

    // Intento de operación SELECT
    try {
        $stmt = $pdo->query("SELECT * FROM hr.employee_info");
        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Operación SELECT ejecutada correctamente:<br>";
        print_r($employees); // Mostrar resultados
    } catch (Exception $e) {
        echo "Error en SELECT: " . $e->getMessage() . "<br>";
    }

    // Intento de operación UPDATE
    try {
        // Intenta realizar una actualización
        $stmt = $pdo->prepare("UPDATE hr.employee_info SET nombre = :nombre WHERE id = :id");
        $stmt->execute([':nombre' => 'Franco', ':id' => 1]); // Cambia el ID según sea necesario
        echo "Operación UPDATE ejecutada correctamente.<br>";
    } catch (Exception $e) {
        echo "Error en UPDATE: " . $e->getMessage() . "<br>";
    }

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
