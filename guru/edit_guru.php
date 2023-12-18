<?php
require_once('../koneksi.php');

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id !== null) {
    $query = "SELECT * FROM guru WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $guru = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi_pekerjaan = $_POST['deskripsi_pekerjaan'];
    $foto = null;

    if (empty($nama) || empty($deskripsi_pekerjaan)) {
        echo "<p class='text-danger'>Nama dan deskripsi pekerjaan harus diisi.</p>";
    } else {
        if ($_FILES['foto']['name']) {
            $foto = $_FILES['foto']['name'];
            $foto_tmp = $_FILES['foto']['tmp_name'];
            if (move_uploaded_file($foto_tmp, '../assets/img/' . $foto)) {
                // Upload berhasil
            } else {
                echo "<p class='text-danger'>Gagal mengunggah foto.</p>";
            }
        }

        $query = "UPDATE guru SET nama = :nama, deskripsi_pekerjaan = :deskripsi_pekerjaan";
        if ($foto) {
            $query .= ", foto = :foto";
        }
        $query .= " WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':deskripsi_pekerjaan', $deskripsi_pekerjaan);
        if ($foto) {
            $stmt->bindParam(':foto', $foto);
        }

        if ($stmt->execute()) {
            header("Location: ../index.php?page=guru");
            exit();
        } else {
            echo "<p class='text-danger'>Gagal memperbarui data guru.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="../../assets/img/srambipaudlogo.png" rel="icon">
    <link href="../../assets/img/srambipaudlogo.png" rel="apple-touch-icon">
    <!-- ... (head section remains the same) ... -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
    <title>Guru - SRAMBI PAUD</title>
</head>

<body class="sb-nav-fixed">
    <!-- ... (navbar and sidebar remain the same) ... -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Data Guru</h1>
                <div class="card">
                    <div class="card-body">
                        <!-- Display the form for editing -->
                        <form method='post' enctype='multipart/form-data'>
                            <input type='hidden' name='id' value='<?php echo $guru['id']; ?>'>
                            <div class='mb-3'>
                                <label for='nama' class='form-label'>Nama Guru</label>
                                <input type='text' class='form-control' id='nama' name='nama' value='<?php echo $guru['nama']; ?>' required>
                            </div>
                            <div class='mb-3'>
                                <label for='foto' class='form-label'>Foto Guru</label>
                                <input type='file' class='form-control' id='foto' name='foto' accept='image/*'>
                            </div>
                            <div class='mb-3'>
                                <label for='deskripsi_pekerjaan' class='form-label'>Deskripsi Pekerjaan</label>
                                <textarea class='form-control' id='deskripsi_pekerjaan' name='deskripsi_pekerjaan' rows='6' required><?php echo $guru['deskripsi_pekerjaan']; ?></textarea>
                            </div>
                            <div class='text-end'>
                                <button type='submit' id='btnSimpan' class='btn btn-primary'>Simpan</button>
                                <a href='../index.php?page=guru' class='btn btn-secondary ms-2'>Batal</a>
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