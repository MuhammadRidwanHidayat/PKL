<?php
require_once('../koneksi.php'); // Sesuaikan dengan path yang benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kategori = $_POST['kategori'];

    $gambar = $_FILES['gambar']['name']; // Mengambil nama file gambar

    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_path = '../assets/img/' . $gambar; // Ganti dengan path yang benar

    if (move_uploaded_file($gambar_tmp, $gambar_path)) {
        $query = "INSERT INTO galeri (gambar, kategori) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $gambar);
        $stmt->bindParam(2, $kategori);

        if ($stmt->execute()) {
            // Penyimpanan berhasil, kembali ke halaman galeri di admin
            echo "Success"; // Return a success message to the AJAX request
        } else {
            echo "Error";
        }
    } else {
        echo "Gagal mengupload gambar.";
    }
}
