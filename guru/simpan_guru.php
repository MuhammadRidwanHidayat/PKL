<?php
require_once('../koneksi.php'); // Sesuaikan dengan path yang benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];

    $foto = $_FILES['foto']['name']; // Mengambil nama file foto

    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_path = '../assets/img/guru&karyawan/' . $foto; // Ganti dengan path yang benar

    if (move_uploaded_file($foto_tmp, $foto_path)) {
        $query = "INSERT INTO guru (nama, deskripsi_pekerjaan, foto) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $nama);
        $stmt->bindParam(2, $deskripsi);
        $stmt->bindParam(3, $foto);

        if ($stmt->execute()) {
            // Penyimpanan berhasil, kembali ke halaman guru di admin
            header('Location: ../index.php?page=guru');
            exit();
        } else {
            echo "Gagal menyimpan data guru.";
        }
    } else {
        echo "Gagal mengupload foto guru.";
    }
}
