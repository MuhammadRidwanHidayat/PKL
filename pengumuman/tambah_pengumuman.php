<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ... (head section remains the same) ... -->
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- Include SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Pengumuman - SRAMBI PAUD</title>
    <link href="../../assets/img/srambipaudlogo.png" rel="icon">
    <link href="../../assets/img/srambipaudlogo.png" rel="apple-touch-icon">
</head>

<body class="sb-nav-fixed">
    <!-- ... (navbar and sidebar remain the same) ... -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Pengumuman</h1>
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="POST" action="simpan_pengumuman.php" id="formTambahPengumuman">
                            <input type="hidden" name="action" value="add"> <!-- Add the action parameter -->
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Pengumuman</label>
                                <input type="text" class="form-control" id="judul" name="judul" required>
                            </div>
                            <div class="mb-3">
                                <label for="file_pdf" class="form-label">File PDF Pengumuman</label>
                                <input type="file" class="form-control" id="file_pdf" name="file_pdf" accept=".pdf" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Tambahkan</button>
                                <a href="../index.php?page=pengumuman" class="btn btn-secondary ms-2">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
    <script>
        const formTambahPengumuman = document.getElementById('formTambahPengumuman');

        formTambahPengumuman.addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(formTambahPengumuman);

            try {
                const response = await fetch('simpan_pengumuman.php', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Pengumuman berhasil ditambahkan!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Redirect back to pengumuman.php
                    window.location.href = '../index.php?page=pengumuman';
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal menambah pengumuman.',
                        text: 'Terjadi kesalahan saat menyimpan pengumuman.',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menambah pengumuman.',
                    text: 'Terjadi kesalahan saat menghubungi server.',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
    <!-- ... (scripts remain the same) ... -->
</body>

</html>