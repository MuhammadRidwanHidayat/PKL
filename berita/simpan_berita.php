<?php
require_once('../koneksi.php'); // Sesuaikan dengan path yang benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];

    $gambar = $_FILES['gambar']['name']; // Mengambil nama file gambar

    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_path = '../assets/img/' . $gambar; // Ganti dengan path yang benar

    if (move_uploaded_file($gambar_tmp, $gambar_path)) {
        $query = "INSERT INTO berita (judul, isi, gambar, tanggal_publikasi) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $judul);
        $stmt->bindParam(2, $isi);
        $stmt->bindParam(3, $gambar);

        if ($stmt->execute()) {
            // Penyimpanan berhasil, kembali ke halaman berita di admin
            header('Location: ../index.php?page=berita');
            exit();
        } else {
            echo "Gagal menyimpan berita.";
        }
    } else {
        echo "Gagal mengupload gambar.";
    }
}
