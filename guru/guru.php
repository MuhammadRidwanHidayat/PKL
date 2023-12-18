<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Guru - SRAMBI PAUD</title>
    <!-- ... (head section remains the same) ... -->
    <style>
        /* ... (CSS yang sudah ada) ... */

        /* Tambahkan garis vertikal */
        table {
            border-collapse: collapse;
            width: 100%;
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
            text-align: center;
        }

        /* Tambahkan jarak antara tombol aksi */
        .action-buttons {
            height: auto;
            gap: 5px;
            justify-content: center;
            display: auto;
            flex-wrap: wrap;
        }

        .action-buttons a {
            margin: 5px;
        }

        /* Mengubah ukuran gambar guru */
        .img-thumbnail {
            display: block;
            max-width: 150px;
            height: auto;
            margin: 0 auto;
        }
    </style>

</head>

<body class="sb-nav-fixed">
    <!-- ... (navbar and sidebar remain the same) ... -->
    <div>
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Data Guru</h1>
                <a href="guru/tambah_guru.php" class="btn btn-primary mb-3">
                    <i class="fas fa-plus-circle"></i> Tambah Guru
                </a>
                <?php
                require_once('../koneksi.php');

                $query = "SELECT * FROM guru";
                $stmt = $conn->prepare($query);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo '
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Foto</th>
                                <th>Deskripsi Pekerjaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>';

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>{$row['nama']}</td>";

                        // Mengubah ukuran foto guru
                        $fotoPath = 'assets/img/guru&karyawan/' . $row['foto'];
                        $ukuranFoto = getimagesize($fotoPath);
                        $lebarFoto = $ukuranFoto[0];
                        $tinggiFoto = $ukuranFoto[1];
                        $maxLebar = 150; // Lebar maksimum yang diinginkan
                        $maxTinggi = ($tinggiFoto / $lebarFoto) * $maxLebar; // Menghitung tinggi berdasarkan lebar maksimum
                        echo "<td><img src='{$fotoPath}' alt='Foto Guru' class='img-thumbnail' width='{$maxLebar}' height='{$maxTinggi}'></td>";

                        echo "<td>{$row['deskripsi_pekerjaan']}</td>";
                        echo "<td class='action-buttons'>";
                        echo "<a href='guru/edit_guru.php?id={$row['id']}' class='btn btn-info'><i class='fas fa-edit'></i> Edit</a>";
                        echo "<a href='guru/hapus_guru.php?id={$row['id']}' class='btn btn-danger' data-id='{$row['id']}'><i class='fas fa-trash'></i> Hapus</a>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    echo '
                        </tbody>
                    </table>';
                } else {
                    echo '<p>Tidak ada data guru saat ini.</p>';
                }
                ?>
                </tbody>
                </table>
            </div>
        </main>
    </div>
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
                    text: 'Anda yakin ingin menghapus data guru ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If user confirms, proceed to delete
                        deleteGuru(id);
                    }
                });
            });
        });

        // Function to delete guru
        function deleteGuru(id) {
            // Send AJAX request to hapus_guru.php
            fetch(`guru/hapus_guru.php?id=${id}`)
                .then(response => response.text())
                .then(data => {
                    if (data === 'Success') {
                        Swal.fire({
                            title: 'Data Guru Terhapus',
                            text: 'Data guru telah berhasil dihapus.',
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
                            text: 'Gagal menghapus data guru.',
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

</html>