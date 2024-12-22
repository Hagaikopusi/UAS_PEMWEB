<?php
session_start(); // Memulai sesi untuk menyimpan data pengguna
require 'db.php'; // Mengimpor file koneksi database

// Memeriksa apakah permintaan adalah metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; // Mengambil username dari form
    $password = $_POST['password']; // Mengambil password dari form

    // Menyiapkan pernyataan SQL untuk mengambil data pengguna berdasarkan username
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username); // Mengikat parameter untuk mencegah SQL injection
    $stmt->execute(); // Menjalankan pernyataan
    $result = $stmt->get_result(); // Mendapatkan hasil dari pernyataan

    // Memeriksa apakah pengguna ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Mengambil data pengguna
        // Memverifikasi password
        if (password_verify($password, $user['password'])) {
            // Jika password benar, simpan data pengguna dalam sesi
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php"); // Arahkan ke halaman dashboard
            exit; // Menghentikan eksekusi script
        } else {
            echo "<script>alert('Password salah.');</script>"; // Menampilkan pesan jika password salah
        }
    } else {
        echo "<script>alert('Username tidak ditemukan.');</script>"; // Menampilkan pesan jika username tidak ditemukan
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dosen</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        /* Gaya untuk body dan container */
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('https://www.itera.ac.id/wp-content/uploads/2020/01/3.jpg');
            background-size: cover; 
            background-position-y: -200px; 
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        /* Gaya untuk logo */
        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .logo img {
            width: 100px;
            height: 100px;
        }
        h2 {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }
        /* Gaya untuk input dan button */
        .input-group {
            display: flex;
            align-items: center;
            border: 1px solid #cbd5e0; /* Gray-300 */
            border-radius: 0.375rem;
            margin-bottom: 1rem; /* Mengurangi jarak bawah */
        }
        .input-group span {
            padding: 0.5rem;
            color: #a0aec0; /* Gray-500 */
        }
        input {
            flex: 1;
            padding: 0.5rem;
            border: none;
            outline: none;
            border-radius: 0 0.375rem 0.375rem 0;
        }
        input:focus {
            border: 2px solid #3182ce; /* Blue-500 */
        }
        .password-group {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #a0aec0; /* Gray-500 */
        }
        button {
            width: 100%;
            background-color: #3182ce; /* Blue-600 */
            color: white;
            padding: 0.75rem; /* Increased padding for better button size */
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem; /* Increased font size */
            transition: background-color 0.3s; /* Smooth transition */
        }
        button:hover {
            background-color: #2b6cb0; /* Blue-700 */
        }
        .footer {
            text-align: center;
            color: #718096; /* Gray-600 */
            margin-top: 1.5rem;
        }
        .footer a {
            color: #3182ce; /* Blue-600 */
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .requirements {
            color: red; /* Warna merah untuk syarat */
            font-size: 0.9rem;
            display: none; /* Sembunyikan secara default */
            margin-top: -0.5rem;
            margin-bottom: 2px;
        }

        .checkbox-group {
            margin-bottom: 10px;
            margin-top: 10px;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img alt="Logo universitas" src="https://www.unukaltim.ac.id/wp-content/uploads/2019/12/graduate-icon-png-28-2.png"/>
        </div>
        <h2>Login Dosen</h2>
        <form id="loginForm" method="POST" onsubmit="return validateForm()">
            <div class="input-group">
                <span><i class="fas fa-envelope"></i></span>
                <input type="text" name="username" id="username" placeholder="Username" required oninput="showRequirements()"/>
            </div>
            <div class="requirements" id="usernameRequirements">Username harus lebih dari 3 karakter.</div>
            <div class="input-group password-group">
                <span><i class="fas fa-lock"></i></span>
                <input type="password" name="password" id="password" placeholder="Password" required oninput="showRequirements()"/>
                <span class="toggle-password" onclick="togglePassword()">
                    <i class="fas fa-eye" id="eye-icon"></i>
                </span>
            </div>
            <div class="requirements" id="passwordRequirements">Password harus terdiri dari minimal 6 karakter.</div>
            <div class="checkbox-group">
                <div>
                    <input id="agree" type="checkbox" required/>
                    <label for="agree">Saya setuju dengan syarat dan ketentuan</label>
                </div>
            </div>
            <button type="submit">Login</button>
            <div class="footer">
                Belum punya akun? <a href="register.php">Daftar di sini</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text'; // Mengubah tipe input menjadi teks
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash'); // Mengubah ikon mata
            } else {
                passwordInput.type = 'password'; // Mengubah kembali tipe input menjadi password
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye'); // Mengubah ikon mata kembali
            }
        }

        function showRequirements() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            // Tampilkan syarat untuk username
            const usernameRequirements = document.getElementById('usernameRequirements');
            usernameRequirements.style.display = username.length <= 3 ? 'block' : 'none';

            // Tampilkan syarat untuk password
            const passwordRequirements = document.getElementById('passwordRequirements');
            passwordRequirements.style.display = password.length < 6 ? 'block' : 'none';
        }

        function validateForm() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            // Validasi username
            if (username.length <= 3) {
                alert("Username harus lebih dari 3 karakter."); // Pesan kesalahan untuk username
                return false;
            }

            // Validasi password
            if ( password.length < 6) {
                alert("Password harus terdiri dari minimal 6 karakter."); // Pesan kesalahan untuk password
                return false;
            }

            // Jika semua validasi lulus
            return true; // Mengizinkan form untuk disubmit
        }
    </script>
</body>
</html>

<?php
$conn->close(); // Menutup koneksi database
?>
