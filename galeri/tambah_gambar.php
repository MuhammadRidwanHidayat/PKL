<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ... (head section remains the same) ... -->
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- Include SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Galeri - SRAMBI PAUD</title>
</head>

<body class="sb-nav-fixed">
    <!-- ... (navbar and sidebar remain the same) ... -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Gambar</h1>
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="POST" action="simpan_gambar.php" enctype="multipart/form-data" id="formTambahGambar">
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-control" id="kategori" name="kategori" required>
                                    <option value="indoor">Indoor</option>
                                    <option value="outdoor">Outdoor</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Tambahkan</button>
                                <a href="../index.php?page=galeri" class="btn btn-secondary ms-2">Batal</a>
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
        const formTambahGambar = document.getElementById('formTambahGambar');

        formTambahGambar.addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(formTambahGambar);

            try {
                const response = await fetch('simpan_gambar.php', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Gambar berhasil ditambahkan!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Redirect back to galeri.php
                    window.location.href = '../index.php?page=galeri';
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal menambah gambar.',
                        text: 'Terjadi kesalahan saat menyimpan gambar.',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menambah gambar.',
                    text: 'Terjadi kesalahan saat menghubungi server.',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
    <!-- ... (scripts remain the same) ... -->
</body>

</html>