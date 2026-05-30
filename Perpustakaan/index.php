<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Sederhana</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container navbar">
            <h1 class="logo">Perpus<span>Takaan</span></h1>
            <nav>
                <ul>
                    <li><a href="index.php" class="active">Dashboard</a></li>
                    <li><a href="buku.php">Data Buku</a></li>
                    <li><a href="pinjam.php">Peminjaman</a></li>
                    <li><a href="kembali.php">Pengembalian</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="welcome">
            <h2>Selamat Datang di Sistem Perpustakaan</h2>
            <p>Kelola data buku, peminjaman, dan pengembalian dengan cepat dan mudah.</p>
        </section>

        <section class="stats">
            <div class="card">
                <h3>Total Buku</h3>
                <?php 
                $res = mysqli_query($koneksi, "SELECT SUM(stok) as total FROM buku");
                $data = mysqli_fetch_assoc($res);
                echo "p" ? "<h4>" . ($data['total'] ?? 0) . " Buku</h4>" : "<h4>0</h4>";
                ?>
            </div>
            <div class="card">
                <h3>Sedang Dipinjam</h3>
                <?php 
                $res = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM peminjaman WHERE status='Dipinjam'");
                $data = mysqli_fetch_assoc($res);
                echo "<h4>" . $data['total'] . " Transaksi</h4>";
                ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Perpustakaan Sederhana. All Rights Reserved.</p>
    </footer>
</body>
</html>