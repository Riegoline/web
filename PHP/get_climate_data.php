<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webfresas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql_temp = "SELECT temperatura FROM temperatura ORDER BY id_temp DESC LIMIT 1";
$sql_hum = "SELECT hum_int, hum_amb FROM humedad ORDER BY id_humedad DESC LIMIT 1";

$result_temp = $conn->query($sql_temp);
$result_hum = $conn->query($sql_hum);

$data = array();

if ($result_temp->num_rows > 0 && $result_hum->num_rows > 0) {
    $row_temp = $result_temp->fetch_assoc();
    $row_hum = $result_hum->fetch_assoc();
    
    $data['temperature'] = floatval($row_temp['temperatura']);
    $data['humidity'] = floatval($row_hum['hum_int']);
    $data['ambiente'] = floatval($row_hum['hum_amb']);
} else {
    $data['temperature'] = null;
    $data['humidity'] = null;
    $data['ambiente'] = null;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>