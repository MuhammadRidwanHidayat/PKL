<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ... (head section remains the same) ... -->
    <!-- Include Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">

    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.css">
    <title>Pengumuman - SRAMBI PAUD</title>
</head>

<body class="sb-nav-fixed">
    <!-- ... (navbar and sidebar remain the same) ... -->
    <div>
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Daftar Pengumuman</h1>
                <a href="pengumuman/tambah_pengumuman.php" class="btn btn-primary mb-3">
                    <i class="fas fa-plus-circle"></i> Tambah Pengumuman
                </a>

                <!-- Daftar Pengumuman -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">Tanggal Publikasi</th>
                                <th style="width: 40%;">Judul Pengumuman</th>
                                <th style="width: 20%; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once('koneksi.php');

                            $query = "SELECT * FROM pengumuman";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();

                            if ($stmt->rowCount() === 0) {
                                echo '<tr><td colspan="4" style="text-align: center;">Tidak ada pengumuman saat ini.</td></tr>';
                            } else {
                                $count = 1;
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $count; ?></td>
                                        <td style="text-align: center;"><?php echo $row['tanggal']; ?></td>
                                        <td><?php echo $row['judul']; ?></td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-danger btn-hapus" data-id="<?php echo $row['id']; ?>">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                            <?php
                                    $count++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- Include SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.js"></script>

    <!-- Script to handle delete confirmation and actions -->
    <script>
        // Function to delete pengumuman
        async function deletePengumuman(id) {
            try {
                const response = await fetch(`pengumuman/hapus_pengumuman.php?id=${id}`);
                return response.text();
            } catch (error) {
                console.error('Error:', error);
                return 'Error';
            }
        }

        // Attach an event listener to all "Hapus" buttons
        const deleteButtons = document.querySelectorAll('.btn-hapus');
        deleteButtons.forEach(button => {
            button.addEventListener('click', async (event) => {
                event.preventDefault();

                const id = button.getAttribute('data-id');

                // Show SweetAlert2 confirmation dialog
                const result = await Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Anda yakin ingin menghapus pengumuman ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                });

                if (result.isConfirmed) {
                    // If user confirms, proceed to delete
                    const response = await deletePengumuman(id);
                    if (response === 'Success') {
                        Swal.fire({
                            title: 'Pengumuman Terhapus',
                            text: 'Pengumuman telah berhasil dihapus.',
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
                            text: 'Gagal menghapus pengumuman.',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            });
        });
    </script>
</body>

</html>