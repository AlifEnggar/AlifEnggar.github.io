<?php 
include 'koneksi.php'; 

$id = ''; $judul = ''; $penulis = ''; $stok = ''; $sukses = ''; $error = '';

// Proses Simpan / Edit Data
if (isset($_POST['simpan'])) {
    $judul   = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $stok    = $_POST['stok'];
    $id      = $_POST['id'];

    if ($judul && $penulis && $stok !== '') {
        if ($id != '') { // Edit
            $sql = "UPDATE buku SET judul='$judul', penulis='$penulis', stok='$stok' WHERE id='$id'";
        } else { // Tambah Baru
            $sql = "INSERT INTO buku (judul, penulis, stok) VALUES ('$judul', '$penulis', '$stok')";
        }
        if (mysqli_query($koneksi, $sql)) {
            $sukses = "Data buku berhasil diperbarui/disimpan.";
            header("refresh:1;url=buku.php");
        } else {
            $error = "Gagal memproses data.";
        }
    } else {
        $error = "Semua kolom harus diisi!";
    }
}

// Ambil data untuk Edit
if (isset($_GET['op']) && $_GET['op'] == 'edit') {
    $id = $_GET['id'];
    $sql = "SELECT * FROM buku WHERE id = '$id'";
    $q = mysqli_query($koneksi, $sql);
    $r = mysqli_fetch_array($q);
    if ($r) {
        $judul   = $r['judul'];
        $penulis = $r['penulis'];
        $stok    = $r['stok'];
    } else {
        $error = "Data tidak ditemukan";
    }
}

// Proses Hapus
if (isset($_GET['op']) && $_GET['op'] == 'delete') {
    $id = $_GET['id'];
    $sql = "DELETE FROM buku WHERE id = '$id'";
    if (mysqli_query($koneksi, $sql)) {
        $sukses = "Data berhasil dihapus.";
        header("refresh:1;url=buku.php");
    } else {
        $error = "Gagal menghapus data.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku - Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container navbar">
            <h1 class="logo">Perpus<span>Takaan</span></h1>
            <nav>
                <ul>
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="buku.php" class="active">Data Buku</a></li>
                    <li><a href="pinjam.php">Peminjaman</a></li>
                    <li><a href="kembali.php">Pengembalian</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <h2>Kelola Data Buku</h2>

        <?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?php if($sukses) echo "<div class='alert alert-success'>$sukses</div>"; ?>

        <div class="card form-container">
            <h3>Formulir Buku</h3>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" value="<?php echo $judul; ?>" required>
                </div>
                <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="penulis" value="<?php echo $penulis; ?>" required>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stok" value="<?php echo $stok; ?>" min="0" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
                <?php if($id != '') echo "<a href='buku.php' class='btn btn-secondary'>Batal</a>"; ?>
            </form>
        </div>

        <div class="card table-container">
            <h3>Daftar Buku Tersedia</h3>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2 = "SELECT * FROM buku ORDER BY id DESC";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            ?>
                            <tr>
                                <td><?php echo $urut++; ?></td>
                                <td><?php echo $r2['judul']; ?></td>
                                <td><?php echo $r2['penulis']; ?></td>
                                <td><?php echo $r2['stok']; ?></td>
                                <td>
                                    <a href="buku.php?op=edit&id=<?php echo $r2['id']; ?>" class="btn-sm btn-warning">Edit</a>
                                    <a href="buku.php?op=delete&id=<?php echo $r2['id']; ?>" class="btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Perpustakaan Sederhana. All Rights Reserved.</p>
    </footer>
</body>
</html>