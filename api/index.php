<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 30%;
            height: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .login-container h2 {
            display: block;
            margin-bottom: 20px;
            text-align: center;
            width: 75%;
        }

        .login-container label {
            display: block;
            margin-bottom: 5px;
            width: 75%;

        }

        .login-container input {
            display: block;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 75%;
        }

        .login-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .login-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Giriş Yap</h2>
        <form id="loginForm">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Giriş Yap">
            <div>
                <p>Hesabın yok mu? <a href="signup.php">Kayıt Ol</a< /p>
            </div>
        </form>
        <div class="error" id="error"></div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const savedUsername = localStorage.getItem('username');
            const savedPassword = localStorage.getItem('password');
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (savedUsername === username && savedPassword === password) {
                window.location.href = 'process.php';
            }
            else {
                document.getElementById('error').textContent = 'Hatalı kullanıcı adı veya şifre';
            }
        });
    </script>
</body>

</html>