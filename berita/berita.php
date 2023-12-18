<!DOCTYPE html>
<html lang="en">

<head>
    <title>Berita - SRAMBI PAUD</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- ... (head section remains the same) ... -->
    <style>
        /* ... your existing CSS styles ... */
        /* You can add any additional styling specific to this page here */

        /* Add vertical borders between table cells */
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 100%;
            /* Set maximum width for responsiveness */
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            /* Optional: Add background color to table header */
            text-align: center;
            /* Center align header text */
        }

        /* Adjust column widths */
        th:nth-child(4),
        td:nth-child(4) {
            width: 120px;
            /* Adjust as needed */
        }

        /* Adjust column widths */
        th:nth-child(2),
        td:nth-child(2) {
            width: 25%;
            /* Perkecil ukuran kolom konten tanggal publikasi */
            /* Adjust as needed */
        }

        /* Adjust column widths */
        th:nth-child(3),
        td:nth-child(3),
        th:last-child,
        td:last-child {
            width: 18%;
            /* Samakan ukuran kolom tanggal publikasi dan tanggal edit */
            /* Adjust as needed */
        }

        /* Flexbox for action buttons */
        .action-buttons {
            height: auto;
            gap: 5px;
            justify-content: center;
            /* Center the buttons */
            flex-wrap: wrap;
            /* Allow buttons to wrap if needed */
        }

        /* Add margin to buttons for spacing */
        .action-buttons a {
            margin: 5px;
        }

        /* Larger image size */
        .img-thumbnail {
            display: block;
            max-width: 150px;
            height: auto;
            margin: 0 auto;
            /* Center the image horizontally */
        }
    </style>

</head>

<body class="sb-nav-fixed">
    <!-- ... (navbar and sidebar remain the same) ... -->
    <div>
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Daftar Berita</h1>
                <a href="berita/tambah_berita.php" class="btn btn-primary mb-3">
                    <i class="fas fa-plus-circle"></i> Tambah Berita
                </a>
                <?php
                require_once('koneksi.php');

                $query = "SELECT * FROM berita";
                $stmt = $conn->prepare($query);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo '
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Foto</th>
                                <th>Tanggal Publikasi</th>
                                <th>Tanggal Edit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>';

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>{$row['judul']}</td>";
                        echo "<td><img src='assets/img/{$row['gambar']}' alt='Foto Berita' class='img-thumbnail'></td>";
                        echo "<td>{$row['tanggal_publikasi']}</td>";
                        echo "<td>{$row['tanggal_edit']}</td>";
                        echo "<td class='action-buttons'>";
                        echo "<a href='berita/detail_berita.php?id={$row['id']}' class='btn btn-info'><i class='fas fa-info-circle'></i> Detail</a>";
                        echo "<a href='berita/hapus_berita.php?id={$row['id']}' class='btn btn-danger' data-id='{$row['id']}'><i class='fas fa-trash'></i> Hapus</a>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    echo '
                        </tbody>
                    </table>';
                } else {
                    echo '<p>Tidak ada berita saat ini.</p>';
                }
                ?>
                </tbody>
                </table>
            </div>
        </main>
    </div>
    <script>
        // Attach an event listener to all "Hapus" buttons
        const deleteButton = document.querySelectorAll('.btn-danger');
        deleteButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();

                const id = button.getAttribute('data-id');

                // Show SweetAlert2 confirmation dialog
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Anda yakin ingin menghapus berita ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If user confirms, proceed to delete
                        deleteBerita(id);
                    }
                });
            });
        });

        // Function to delete berita
        function deleteBerita(id) {
            // Send AJAX request to hapus_berita.php
            fetch(`berita/hapus_berita.php?id=${id}`)
                .then(response => response.text())
                .then(data => {
                    if (data === 'Success') {
                        Swal.fire({
                            title: 'Berita Terhapus',
                            text: 'Berita telah berhasil dihapus.',
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
                            text: 'Gagal menghapus berita.',
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
    </script>
</body>

<!-- Script to handle delete confirmation -->
<script>
    // Attach an event listener to all "Hapus" buttons
    const deleteButtons = document.querySelectorAll('.btn-danger');
    deleteButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();

            const id = button.getAttribute('data-id');

            // Show SweetAlert2 confirmation dialog
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Anda yakin ingin menghapus berita ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, proceed to delete
                    deleteBerita(id);
                }
            });
        });
    });

    // Function to delete berita
    function deleteBerita(id) {
        // Send AJAX request to delete_berita.php
        fetch(`berita/hapus_berita.php?id=${id}`)
            .then(response => response.text())
            .then(data => {
                if (data === 'Success') {
                    Swal.fire({
                        title: 'Berita Terhapus',
                        text: 'Berita telah berhasil dihapus.',
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
                        text: 'Gagal menghapus berita.',
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
</script>

</html>