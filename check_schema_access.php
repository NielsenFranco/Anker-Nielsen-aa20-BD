<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$dbname = 'company_db';
$user = 'read_user'; // Cambia este usuario según lo que desees probar
$pass = '123'; // Cambia por la contraseña de read_user

try {
    // Crear conexión usando PDO
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa.<br>";

    // Intentar acceder a employee_info en el esquema hr
    try {
        $stmt = $pdo->query("SELECT * FROM hr.employee_info");
        echo "Acceso a employee_info en el esquema hr ejecutado correctamente.<br>";

        // Mostrar resultados (si hay)
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "ID: " . $row['id'] . " - Nombre: " . $row['nombre'] . " - Apellido: " . $row['apellido'] . " - Puesto: " . $row['puesto'] . "<br>";
        }
    } catch (Exception $e) {
        echo "Error en acceso a employee_info: " . $e->getMessage() . "<br>";
    }

    // Intentar acceder a sales_data en el esquema sales
    try {
        $stmt = $pdo->query("SELECT * FROM sales.sales_data");
        echo "Acceso a sales_data en el esquema sales ejecutado correctamente.<br>";

        // Mostrar resultados (si hay)
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "ID: " . $row['id'] . " - Producto: " . $row['producto'] . " - Cantidad: " . $row['cantidad'] . " - Precio: " . $row['precio'] . "<br>";
        }
    } catch (Exception $e) {
        echo "Error en acceso a sales_data: " . $e->getMessage() . "<br>";
    }

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>