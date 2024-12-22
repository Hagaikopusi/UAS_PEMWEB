<?php
session_start(); // Memulai sesi
if (!isset($_SESSION['user_id'])) { // Memeriksa apakah pengguna sudah login
    header("Location: login.php"); // Jika tidak, arahkan ke halaman login
    exit; // Hentikan eksekusi script
}

require_once 'db.php'; // Menghubungkan ke database
require_once 'Mahasiswa.php'; // Menghubungkan ke kelas Mahasiswa

$mahasiswa = new Mahasiswa($conn);

// Inisialisasi variabel pencarian
$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];
    $result = $mahasiswa->searchMahasiswa($searchTerm); // Mengambil data berdasarkan pencarian
} else {
    $result = $mahasiswa->getAllMahasiswa(); // Ambil semua data mahasiswa jika tidak ada pencarian
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url('https://masuk-ptn.com/images/product/368b1d936cf9be5ef1d7c936bc793c306655880f.jpg'); 
            background-size: 100%; 
            background-position: center;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px;
            background-color: #ffffff; /* Warna latar belakang kontainer */
            border-radius: 8px; /* Sudut melengkung */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Bayangan halus */
        }
        h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 32px;
            text-align: center;
            color: #2d3748; /* Warna teks */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4299e1; /* Warna latar belakang header tabel */
            color: white; /* Warna teks header tabel */
        }
        tr:nth-child(even) {
            background-color: #f7fafc; /* Warna latar belakang baris genap */
        }
        tr:hover {
            background-color: #e2e8f0; /* Warna latar belakang saat hover */
        }
        .button-container {
            margin-top: 20px;
            text-align: center;
        }
        .button {
            background-color: #4299e1; /* Warna tombol */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none; /* Menghilangkan garis bawah */
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #3182ce; /* Warna tombol saat hover */
        }
        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }
        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 300px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4299e1;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #3182ce;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Data Mahasiswa</h1>
        <div class="search-container">
            <form method="POST">
                <input type="text" name="searchTerm" placeholder="Cari mahasiswa..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                <input type="submit" name="search" value="Cari">
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Prodi</th>
                    <th>Gender</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['nim']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['prodi']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada data mahasiswa.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="button-container">
            <a href="dashboard.php" class="button">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>