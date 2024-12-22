<?php
require 'db.php';
require 'Mahasiswa.php';
require 'controller.php';
session_start(); // Memulai sesi

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Jika tidak, arahkan ke halaman login
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input dan Tabel Data Mahasiswa</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('https://tiangmas.com/_ipx/fit_cover&s_1200x630/img/pageassets/gerbang-itera.jpg'); 
            background-size: cover; 
            background-position: center; 
            padding: 20px;
            display: flex;
            flex-wrap: wrap; /* Allow wrapping for smaller screens */
        }

        .sidebar {
            width: 250px;
            background-color: #2d3748; /* Gray-800 */
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
            border-radius: 8px;
            margin-right: 20px;
            margin-left: -40px;
            margin-top: -40px;
            margin-bottom: -5px;
        }

        .sidebar h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #4a5568; /* Gray-700 */
        }

        .container {
            flex: 1; 
            max-width: 600px;
            margin: 0 auto; 
            margin-top: 20px; 
            margin-bottom: 20px;
            margin-left: 10px; 
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-y: auto; 
        }

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #2d3748;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #4a5568;
        }
        input[type="text"],
        select {
            width: 96%;
            padding: 10px;
            margin: 5px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f7fafc;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #4c51bf;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            width: 100%;
            text-align: center;
        }
        .btn:hover {
            background-color: #434190;
        }
        .error {
            color: red;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn-edit {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-edit:hover {
            background-color: #218838;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }

        footer {
            text-align: center;
            font-size: 14px;
            color: #ffffff;
            background-color: #4c51bf; 
            padding: 0px 0; 
            position: fixed; 
            bottom: 0; 
            left: 0; 
            right: 0; 
            width: 100%; 
            z-index: 1000; 
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%; /* Full width on small screens */
                margin-left: 0; /* Remove left margin */
                margin-right: 0; /* Remove right margin */
            }

            .container {
                max-width: 100%; /* Full width on small screens */
                margin-left: 0; /* Remove left margin */
            }

            body {
                flex-direction: column; /* Stack elements vertically */
            }
        }

        @media (max-width: 480px) {
            .sidebar h1 {
                font-size: 20px; /* Smaller font size for mobile */
            }

            h2 {
                font-size: 20px; /* Smaller font size for mobile */
            }

            .btn {
                padding: 8px; /* Smaller button padding */
            }

            table {
                font-size: 14px; /* Smaller font size for table */
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h1>Menu</h1>
    <nav class="nav">
        <a href="index.php">
            <i class="fas fa-user-plus" style="margin-right: 8px;"></i>
            Tambahkan Data Mahasiswa
        </a>
        <a href="dashboard.php">
            <i class="fas fa-tachometer-alt" style="margin-right: 8px;"></i>
            Dashboard Mahasiswa
        </a>
        <a href="logout.php">
            <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i>
            Logout
        </a>
    </nav>
</div>

<div class="container">
    <h2>Form Input Mahasiswa</h2>
    <form id="studentForm" method="POST">
        <input type="hidden" name="action" value="<?php echo isset($studentToEdit) ? 'edit' : 'add'; ?>">
        <?php if (isset($studentToEdit)): ?>
            <input type="hidden" name="id" value="<?php echo $studentToEdit['id']; ?>">
        <?php endif; ?>
        <div class="form-group">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($studentToEdit) ? $studentToEdit['nama'] : ''; ?>" required>
            <div class="error" id="nameError"></div>
        </div>
        <div class="form-group">
            <label for="nim">NIM:</label>
            <input type="text" id="nim" name="nim" value="<?php echo isset($studentToEdit) ? $studentToEdit['nim'] : ''; ?>" required>
            <div class="error" id="nimError"></div>
        </div>
        <div class="form-group">
            <label for="prodi">Prodi:</label>
            <input type="text" id="prodi" name="prodi" value="<?php echo isset($studentToEdit) ? $studentToEdit['prodi'] : ''; ?>" required>
            <div class="error" id="prodiError"></div>
        </div>
        <div class="form-group">
            <label>Gender:</label>
            <label><input type="radio" name="gender" value="Laki-laki" <?php echo (isset($studentToEdit) && $studentToEdit['gender'] === 'Laki-laki') ? 'checked' : ''; ?> required> Laki-laki</label>
            <label><input type="radio" name="gender" value="Perempuan" <?php echo (isset($studentToEdit) && $studentToEdit['gender'] === 'Perempuan') ? 'checked' : ''; ?> required> Perempuan</label>
            <div class="error" id="genderError"></div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn">Submit</button>
        </div>
    </form>
</div>

<div class="container">
    <h2>Data Mahasiswa</h2>
    <form method="POST" style="margin-bottom: 20px;">
        <input type="text" name="searchTerm" placeholder="Cari NIM atau Nama" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit" name="search" class="btn">Cari</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Prodi</th>
                <th>Aksi</th>
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
                        <td>
                            <a href="?edit=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                            <form method="POST" onSubmit="return confirm('Yakin ingin menghapus data ini?');" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada data.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('studentForm');
        const name = document.getElementById('name');
        const nim = document.getElementById('nim');
        const prodi = document.getElementById('prodi');
        const gender = document.getElementsByName('gender');

        function validateName() {
            const errorElement = document.getElementById('nameError');
            if (name.value.trim() === "" || /\d/.test(name.value)) {
                errorElement.textContent = "Nama tidak boleh kosong dan tidak boleh mengandung angka.";
                return false;
            }
            errorElement.textContent = "";
            return true;
        }

        function validateNim() {
            const errorElement = document.getElementById('nimError');
            if (nim.value.trim() === "") {
                errorElement.textContent = "NIM tidak boleh kosong.";
                return false;
            } else if (nim.value.trim().length < 4) {
                errorElement.textContent = "NIM harus lebih dari 3 karakter.";
                return false;
            }
            errorElement.textContent = "";
            return true;
        }

        function validateProdi() {
            const errorElement = document.getElementById('prodiError');
            if (prodi.value.trim() === "") {
                errorElement.textContent = "Prodi tidak boleh kosong.";
                return false;
            }
            errorElement.textContent = "";
            return true;
        }

        function validateGender() {
            const errorElement = document.getElementById('genderError');
            if (![...gender].some(radio => radio.checked)) {
                errorElement.textContent = "Gender harus dipilih.";
                return false;
            }
            errorElement.textContent = "";
            return true;
        }

        form.addEventListener('submit', function (e) {
            const validName = validateName();
            const validNim = validateNim();
            const validProdi = validateProdi();
            const validGender = validateGender();
            if (!validName || !validNim || !validProdi || !validGender) {
                e.preventDefault();
            }
        });

        // Add event listeners for real-time validation
        name.addEventListener('input', validateName);
        nim.addEventListener('input', validateNim);
        prodi.addEventListener('input', validateProdi);
        [...gender].forEach(radio => radio.addEventListener('change', validateGender ));
    });
</script>
</body>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Hagai Kopusi Sinulingga</p>
</footer>

</html>

<?php
$conn->close();
?>