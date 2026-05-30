<?php 
include 'koneksi.php'; 

$sukses = ''; $error = '';

if (isset($_GET['op']) && $_GET['op'] == 'kembali') {
    $id_pinjam = $_GET['id'];
    
    // Ambil id_buku dari data peminjaman
    $cek_pinjam = mysqli_query($koneksi, "SELECT id_buku FROM peminjaman WHERE id = '$id_pinjam' AND status='Dipinjam'");
    $data_pinjam = mysqli_fetch_assoc($cek_pinjam);

    if ($data_pinjam) {
        $id_buku = $data_pinjam['id_buku'];
        
        // Update status jadi dikembalikan
        $sql_kembali = "UPDATE peminjaman SET status = 'Dikembalikan' WHERE id = '$id_pinjam'";
        // Tambahkan kembali stok buku
        $sql_update_stok = "UPDATE buku SET stok = stok + 1 WHERE id = '$id_buku'";

        if (mysqli_query($koneksi, $sql_kembali) && mysqli_query($koneksi, $sql_update_stok)) {
            $sukses = "Buku berhasil dikembalikan! Stok bertambah.";
            header("refresh:1;url=kembali.php");
        } else {
            $error = "Proses pengembalian gagal.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Buku - Perpustakaan</title>
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
                    <li><a href="pinjam.php">Peminjaman</a></li>
                    <li><a href="kembali.php" class="active">Pengembalian</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <h2>Pengembalian Buku</h2>

        <?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?php if($sukses) echo "<div class='alert alert-success'>$sukses</div>"; ?>

        <div class="card table-container">
            <h3>Daftar Buku Yang Sedang Dipinjam</h3>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT peminjaman.*, buku.judul FROM peminjaman 
                                JOIN buku ON peminjaman.id_buku = buku.id 
                                WHERE peminjaman.status = 'Dipinjam' 
                                ORDER BY peminjaman.id DESC";
                        $q = mysqli_query($koneksi, $sql);
                        $urut = 1;
                        if(mysqli_num_rows($q) == 0){
                            echo "<tr><td colspan='6' style='text-align:center;'>Tidak ada buku yang sedang dipinjam.</td></tr>";
                        }
                        while($r = mysqli_fetch_array($q)){
                        ?>
                        <tr>
                            <td><?php echo $urut++; ?></td>
                            <td><?php echo $r['nama_peminjam']; ?></td>
                            <td><?php echo $r['judul']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($r['tanggal_pinjam'])); ?></td>
                            <td><span class="badge badge-warning"><?php echo $r['status']; ?></span></td>
                            <td>
                                <a href="kembali.php?op=kembali&id=<?php echo $r['id']; ?>" class="btn-sm btn-success" onclick="return confirm('Konfirmasi pengembalian buku ini?')">Kembalikan Buku</a>
                            </td>
                        </tr>
                        <?php } ?>
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