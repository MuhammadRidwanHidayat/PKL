<!DOCTYPE html>
<html lang="en">

<head>
    <link href="../../assets/img/srambipaudlogo.png" rel="icon">
    <link href="../../assets/img/srambipaudlogo.png" rel="apple-touch-icon">
    <title>Detail Berita - SRAMBI PAUD</title>
    <!-- ... your head section ... -->
    <style>
        /* Add additional styling here */

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .detail-header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .detail-header h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .detail-header p {
            color: #888;
            font-size: 14px;
            margin: 5px 0;
        }

        .detail-content {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .detail-content img {
            max-width: 100%;
            height: auto;
            margin: 10px 0;
        }

        .edit-button,
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .edit-button {
            background-color: #3498db;
            color: #fff;
            border: none;
            margin-right: 10px;
            /* Add margin to separate buttons */
        }

        .edit-button:hover {
            background-color: #2980b9;
        }

        .back-button {
            background-color: #ddd;
            color: #333;
            border: none;
        }

        .back-button:hover {
            background-color: #ccc;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- ... your navigation or header ... -->

    <div class="container">
        <div class="detail-header">
            <?php
            require_once('../koneksi.php');

            // Get the ID of the news item from the URL parameter
            $id = $_GET['id'];

            $query = "SELECT * FROM berita WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                echo "<h2>{$row['judul']}</h2>";
                echo "<p><strong>Tanggal Publikasi:</strong> {$row['tanggal_publikasi']}</p>";
                if (!empty($row['tanggal_edit'])) {
                    echo "<p><strong>Tanggal Edit:</strong> {$row['tanggal_edit']}</p>";
                }
            } else {
                echo "<p>Berita tidak ditemukan.</p>";
            }

            ?>
        </div>

        <div class="detail-content" style="text-align: justify; text-justify: inter-word;">
            <?php
            if ($row) {
                echo "<img src='../assets/img/{$row['gambar']}' alt='Foto Berita'>";
                echo "<div>{$row['isi']}</div>";
            }
            ?>
        </div>

        <div class="button-container">
            <a href="edit_berita.php?id=<?php echo $row['id']; ?>" class="edit-button">Edit Berita</a>
            <a href="../index.php?page=berita" class="back-button">Kembali ke Daftar Berita</a>
        </div>
    </div>

    <!-- ... your footer ... -->
</body>

</html>