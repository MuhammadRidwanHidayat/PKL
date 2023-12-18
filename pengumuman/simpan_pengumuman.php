<?php
require_once('../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        // Upload PDF file
        $filePdfPath = ''; // Initialize file path variable

        if (isset($_FILES['file_pdf']) && $_FILES['file_pdf']['error'] === 0) {
            $targetDirectory = '../assets/pengumuman/'; // Specify the directory to upload files
            $filePdfName = $_FILES['file_pdf']['name'];
            $filePdfPath = $targetDirectory . $filePdfName;

            if (move_uploaded_file($_FILES['file_pdf']['tmp_name'], $filePdfPath)) {
                // File uploaded successfully
            } else {
                echo "Error uploading file.";
                exit();
            }
        } else {
            echo "Error uploading file.";
            exit();
        }

        // Insert new announcement
        $judul = $_POST['judul'];
        $tanggal = date('Y-m-d'); // Get current date

        // Prepare and execute the INSERT query
        $query = "INSERT INTO pengumuman (judul, file_pdf, tanggal) VALUES (:judul, :file_pdf, :tanggal)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':judul', $judul, PDO::PARAM_STR);
        $stmt->bindParam(':file_pdf', $filePdfName, PDO::PARAM_STR);
        $stmt->bindParam(':tanggal', $tanggal, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Success"; // Return a success message to the AJAX request
        } else {
            echo "Error";
        }
    } elseif ($action === 'edit') {
        // Update existing announcement
        $id = $_POST['id'];
        $judul = $_POST['judul'];

        // Prepare and execute the UPDATE query
        $query = "UPDATE pengumuman SET judul = :judul WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':judul', $judul, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Success"; // Return a success message to the AJAX request
        } else {
            echo "Error";
        }
    } else {
        echo "Invalid action.";
    }

    // Close the database connection
    $conn = null;

    // Redirect back to pengumuman.php
    header("Location: ../index.php?page=pengumuman");
    exit(); // Make sure to exit after redirection
}
