<?php
require_once('../koneksi.php');

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id !== null) {
    $query = "SELECT * FROM berita WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $berita = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $gambar = null;

    if (empty($judul) || empty($isi)) {
        echo "<p class='text-danger'>Judul dan isi berita harus diisi.</p>";
    } else {
        if ($_FILES['gambar']['name']) {
            $gambar = $_FILES['gambar']['name'];
            $gambar_tmp = $_FILES['gambar']['tmp_name'];
            if (move_uploaded_file($gambar_tmp, '../assets/img/' . $gambar)) {
                // Upload berhasil
            } else {
                echo "<p class='text-danger'>Gagal mengunggah gambar.</p>";
            }
        }

        $query = "UPDATE berita SET judul = :judul, isi = :isi";
        if ($gambar) {
            $query .= ", gambar = :gambar";
        }
        $query .= ", tanggal_edit = NOW() WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':judul', $judul);
        $stmt->bindParam(':isi', $isi);
        if ($gambar) {
            $stmt->bindParam(':gambar', $gambar);
        }

        if ($stmt->execute()) {
            header("Location: ../index.php?page=berita");
            exit();
        } else {
            echo "<p class='text-danger'>Gagal memperbarui berita.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Berita - SRAMBI PAUD</title>
    <link href="../../assets/img/srambipaudlogo.png" rel="icon">
    <link href="../../assets/img/srambipaudlogo.png" rel="apple-touch-icon">
    <!-- ... (head section remains the same) ... -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <!-- ... (navbar and sidebar remain the same) ... -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Berita</h1>
                <div class="card">
                    <div class="card-body">
                        <!-- Display the form for editing -->
                        <form method='post' enctype='multipart/form-data'>
                            <input type='hidden' name='id' value='<?php echo $berita['id']; ?>'>
                            <div class='mb-3'>
                                <label for='judul' class='form-label'>Judul Berita</label>
                                <input type='text' class='form-control' id='judul' name='judul' value='<?php echo $berita['judul']; ?>' required>
                            </div>
                            <div class='mb-3'>
                                <label for='gambar' class='form-label'>Gambar Berita</label>
                                <input type='file' class='form-control' id='gambar' name='gambar' accept='image/*'>
                            </div>
                            <div class='mb-3'>
                                <label for='isi' class='form-label'>Isi Berita</label>
                                <textarea class='form-control' id='isi' name='isi' rows='6' required><?php echo $berita['isi']; ?></textarea>
                            </div>
                            <div class='text-end'>
                                <button type='submit' id='btnSimpan' class='btn btn-primary'>Simpan</button>
                                <a href='../index.php?page=berita' class='btn btn-secondary ms-2'>Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- ... (scripts remain the same) ... -->
</body>

</html>