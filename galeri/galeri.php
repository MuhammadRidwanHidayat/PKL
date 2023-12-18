<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Galeri - SRAMBI PAUD</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.css">

    <style>
        /* ... your existing CSS styles ... */
        .card-container {
            display: flex;
            flex-wrap: wrap;
        }

        .card-container .card {
            flex: 1 0 calc(33.333% - 20px);
            /* Adjust the width as needed */
            margin: 10px;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <div>
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Daftar Gambar Galeri</h1>
                <a href="galeri/tambah_gambar.php" class="btn btn-primary mb-3">
                    <i class="fas fa-plus-circle"></i> Tambah Gambar
                </a>
                <?php
                require_once('koneksi.php');

                $query = "SELECT * FROM galeri"; // Sesuaikan dengan nama tabel galeri
                $stmt = $conn->prepare($query);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo '
                    <div class="row card-container">';

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $imagePath = 'assets/img/' . $row['gambar'];
                        $category = $row['kategori'];
                        $id = $row['id'];
                        echo "<div class='col-md-4'>
                                <div class='card'>
                                    <img src='$imagePath' class='card-img-top' alt='...'>
                                    
                                    <div class='card-body'>
                                        <p class='card-text'>Kategori: $category</p>
                                        <div class='d-flex justify-content-between'>
                                            <button class='btn btn-danger btn-hapus' data-id='$id'>
                                                <i class='fas fa-trash'></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                    }

                    echo '
                    </div>';
                } else {
                    echo '<p>Tidak ada gambar saat ini.</p>';
                }
                ?>

            </div>
        </main>
    </div>
    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Attach an event listener to all "Hapus" buttons
        const deleteButtons = document.querySelectorAll('.btn-hapus');
        deleteButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();

                const id = button.getAttribute('data-id');

                // Show SweetAlert2 confirmation dialog
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Anda yakin ingin menghapus gambar ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If user confirms, proceed to delete
                        deleteGambar(id);
                    }
                });
            });
        });

        // Function to delete gambar
        function deleteGambar(id) {
            // Send AJAX request to hapus_gambar.php
            fetch(`galeri/hapus_gambar.php?id=${id}`)
                .then(response => response.text())
                .then(data => {
                    if (data === 'Success') {
                        Swal.fire({
                            title: 'Gambar Terhapus',
                            text: 'Gambar telah berhasil dihapus.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // Reload the page
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Gagal menghapus gambar.',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menghubungi server.',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
        }
        const editButtons = document.querySelectorAll('.btn-edit');
        const modal = new bootstrap.Modal(document.getElementById('editModal'), {});

        editButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const id = button.getAttribute('data-id');
                // Set the selected option based on the current category
                const category = button.parentElement.parentElement.querySelector('.card-text').textContent.trim();
                const select = document.getElementById('kategori');
                Array.from(select.options).forEach(option => {
                    option.selected = option.value === category;
                });
                document.getElementById('gambarId').value = id;
                modal.show();
            });
        });
    </script>
</body>

</html>