<?php
session_start(); // Memulai sesi
if (!isset($_SESSION['user_id'])) { // Memeriksa apakah pengguna sudah login
    header("Location: login.php"); // Jika tidak, arahkan ke halaman login
    exit; // Hentikan eksekusi script
}

require_once 'db.php'; // Menghubungkan ke database
require_once 'Mahasiswa.php'; // Menghubungkan ke kelas Mahasiswa

$mahasiswa = new Mahasiswa($conn);

// Ambil semua data mahasiswa
$result = $mahasiswa->getAllMahasiswa();
$totalMahasiswa = $result->num_rows;

// Ambil data mahasiswa berdasarkan gender
$totalLakiLaki = 0;
$totalPerempuan = 0;

while ($row = $result->fetch_assoc()) {
    if ($row['gender'] === 'Laki-laki') {
        $totalLakiLaki++;
    } elseif ($row['gender'] === 'Perempuan') {
        $totalPerempuan++;
    }
}

// Hitung jumlah mahasiswa baru (misalnya, mahasiswa yang terdaftar tahun ini)
$newStudents = 0; // Inisialisasi
$currentYear = date("Y");
$result->data_seek(0); // Reset pointer hasil query
while ($row = $result->fetch_assoc()) {
    // Misalkan ada kolom 'created_at' di tabel mahasiswa
    if (isset($row['created_at']) && date('Y', strtotime($row['created_at'])) == $currentYear) {
        $newStudents++;
    }
}

// Hitung jumlah mahasiswa berdasarkan program studi
$studentsByProgram = []; // Inisialisasi array
$result->data_seek(0); // Reset pointer hasil query
while ($row = $result->fetch_assoc()) {
    $program = $row['prodi'];
    if (!isset($studentsByProgram[$program])) {
        $studentsByProgram[$program] = 0;
    }
    $studentsByProgram[$program]++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url('https://www.itera.ac.id/wp-content/uploads/2024/06/DJI_007222.jpg'); 
            background-size: cover; 
            background-position: center; 
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px; /* Menambahkan padding lebih banyak */
        }
        h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 32px; /* Menambahkan margin bawah lebih banyak */
            text-align: center;
        }
        .welcome-message {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5); /* Putih dengan transparansi 50% */
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: white; /* Warna teks */
        }
        .button-container {
            display: flex;
            justify-content: center; /* Menyusun tombol di tengah */
            margin-bottom: 20px; /* Menambahkan margin bawah */
            margin-right: 2px;
        }
        .button {
            background-color: #4299e1;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
            font-size: 1rem;
            text-decoration: none; /* Remove underline */
            margin: 0 10px; /* Menambahkan margin horizontal antar tombol */
        }
        .button:hover {
            background-color: black; /* Warna saat hover */
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px; /* Menambahkan jarak antar grid */
            margin-top: 20px;
        }
        .card {
            background-color: white;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            transition: transform 0.2s;
            margin-bottom: 20px; /* Menambahkan margin bawah pada card */
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .icon {
            width: 64px;
            height: 64px;
            background-color: #4299e1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
        }
        .icon i {
            color: white;
            font-size: 2rem;
        }
        h2 {
            font-size: 1.25rem;
            font-weight: bold;
            margin: 0;
        }
        p {
            font-size: 1.5rem;
            margin: 0;
            color: black; /* Warna teks */
        }
        .statistics {
            margin-top: 20px;
            text-align: center;
            color: black;
            font-family: 'Roboto', sans-serif;
            font-size: 24px;
            background-color: #4A90E2; /* Warna latar belakang elemen statistik */
            padding: 20px; /* Ruang di dalam elemen */
            border-radius: 10px; /* Sudut membulat */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Bayangan kotak */
            transition: transform 0.3s; /* Transisi untuk efek hover */
        }
        .statistics:hover {
            transform: scale(1.05); /* Membesar saat hover */
        }
        .program-list {
            list-style-type: none; /* Menghilangkan bullet points */
            padding: 0; /* Menghilangkan padding default */
            margin: 0; /* Menghilangkan margin default */
        }
        .program-list li {
            background-color: rgba(255, 255, 255, 0.8); /* Latar belakang putih dengan transparansi */
            padding: 10px; /* Ruang di dalam elemen */
            border-radius: 5px; /* Sudut membulat */
            margin: 5px 0; /* Jarak antar item */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Bayangan kotak */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard Mahasiswa</h1>
        <div class="welcome-message">
            Selamat datang di dashboard mahasiswa! Di sini Anda dapat melihat statistik dan informasi terkait mahasiswa.
        </div>
        <div class="button-container">
            <a href="index.php" class="button">
                <i class="fas fa-plus mr-2"></i> Tambahkan Data Mahasiswa
            </a>
            <a href="view_students.php" class="button">
                <i class="fas fa-eye"></i> Lihat Data Mahasiswa
            </a>
            <a href="logout.php" class="button">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
        <div class="grid">
            <div class="card">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h2>Total Students</h2>
                    <p><?php echo $totalMahasiswa; ?></p>
                </div>
            </div>
            <div class="card">
                <div class="icon" style="background-color: #48bb78;">
                    <i class="fas fa-male"></i>
                </div>
                <div>
                    <h2>Male Students</h2>
                    <p><?php echo $totalLakiLaki; ?></p>
                </div>
            </div>
            <div class="card">
                <div class="icon" style="background-color: #ed64a6;">
                    <i class="fas fa-female"></i>
                </div>
                <div>
                    <h2>Female Students</h2>
                    <p><?php echo $totalPerempuan; ?></p>
                </div>
            </div>
        </div>
        <div class="statistics">
            <h2>Statistik Tambahan</h2>
            <p>Jumlah mahasiswa baru tahun ini: <strong><?php echo $newStudents; ?></strong></p>
            <p>Jumlah mahasiswa berdasarkan program studi:</p>
            <ul class="program-list">
                <?php foreach ($studentsByProgram as $program => $count): ?>
                    <li><?php echo $program . ': ' . $count; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>