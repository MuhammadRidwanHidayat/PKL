<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('../koneksi.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the query
    $query = "DELETE FROM pengumuman WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Send a success response
        echo "Success";
    } else {
        // Send an error response
        echo "Error";
    }
} else {
    echo "ID pengumuman tidak valid.";
}
