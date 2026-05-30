<?php 
include 'koneksi.php'; 

$sukses = ''; $error = '';

if (isset($_POST['pinjam'])) {
    $nama_peminjam  = $_POST['nama_peminjam'];
    $id_buku        = $_POST['id_buku'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];

    if ($nama_peminjam && $id_buku && $tanggal_pinjam) {
        // Cek stok buku terlebih dahulu
        $cek_buku = mysqli_query($koneksi, "SELECT stok FROM buku WHERE id = '$id_buku'");
        $data_buku = mysqli_fetch_assoc($cek_buku);

        if ($data_buku['stok'] > 0) {
            // Jalankan transaksi peminjaman
            $sql_pinjam = "INSERT INTO peminjaman (nama_peminjam, id_buku, tanggal_pinjam, status) VALUES ('$nama_peminjam', '$id_buku', '$tanggal_pinjam', 'Dipinjam')";
            // Kurangi stok buku
            $sql_update_stok = "UPDATE buku SET stok = stok - 1 WHERE id = '$id_buku'";
            
            if (mysqli_query($koneksi, $sql_pinjam) && mysqli_query($koneksi, $sql_update_stok)) {
                $sukses = "Peminjaman berhasil dicatat!";
            } else {
                $error = "Gagal mencatat peminjaman.";
            }
        } else {
            $error = "Stok buku habis! Tidak bisa dipinjam.";
        }
    } else {
        $error = "Semua field formulir wajib diisi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Buku - Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container navbar">
            <h1 class="logo">Perpus<span>Takaan</span></h1>
            <nav>
                <ul>
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="buku.php">Data Buku</a></li>
                    <li><a href="pinjam.php" class="active">Peminjaman</a></li>
                    <li><a href="kembali.php">Pengembalian</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <h2>Transaksi Peminjaman Buku</h2>

        <?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?php if($sukses) echo "<div class='alert alert-success'>$sukses</div>"; ?>

        <div class="card form-container">
            <h3>Input Data Peminjam</h3>
            <form action="" method="POST">
                <div class="form-group">
                    <label>Nama Peminjam</label>
                    <input type="text" name="nama_peminjam" required>
                </div>
                <div class="form-group">
                    <label>Pilih Buku</label>
                    <select name="id_buku" required>
                        <option value="">-- Pilih Buku yang Tersedia --</option>
                        <?php 
                        $res_buku = mysqli_query($koneksi, "SELECT * FROM buku WHERE stok > 0");
                        while($b = mysqli_fetch_array($res_buku)) {
                            echo "<option value='".$b['id']."'>".$b['judul']." (Stok: ".$b['stok'].")</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <button type="submit" name="pinjam" class="btn btn-primary">Proses Pinjam</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Perpustakaan Sederhana. All Rights Reserved.</p>
    </footer>
</body>
</html>