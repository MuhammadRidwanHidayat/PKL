<!DOCTYPE html>
<html lang="en">

<head>
    <link href="../../assets/img/srambipaudlogo.png" rel="icon">
    <link href="../../assets/img/srambipaudlogo.png" rel="apple-touch-icon">
    <!-- ... (head section remains the same) ... -->
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- Include SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Tambah Berita - SRAMBI PAUD</title>
</head>

<body class="sb-nav-fixed">
    <!-- ... (navbar and sidebar remain the same) ... -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Berita</h1>
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="POST" action="simpan_berita.php" enctype="multipart/form-data" id="formTambahBerita">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Berita</label>
                                <input type="text" class="form-control" id="judul" name="judul" required>
                            </div>
                            <div class="mb-3">
                                <label for="isi" class="form-label">Isi Berita</label>
                                <textarea class="form-control" id="isi" name="isi" rows="5" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar Berita</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Tambahkan</button>
                                <a href="../index.php?page=berita" class="btn btn-secondary ms-2">Batal</a>
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
        const formTambahBerita = document.getElementById('formTambahBerita');

        formTambahBerita.addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(formTambahBerita);

            try {
                const response = await fetch('simpan_berita.php', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Berita berhasil ditambahkan!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Redirect back to berita.php
                    window.location.href = '../index.php?page=berita';
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal menambah berita.',
                        text: 'Terjadi kesalahan saat menyimpan berita.',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menambah berita.',
                    text: 'Terjadi kesalahan saat menghubungi server.',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
    <!-- ... (scripts remain the same) ... -->
</body>

</html>