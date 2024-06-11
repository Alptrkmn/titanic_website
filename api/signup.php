<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .signup-container {
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
        .signup-container h2 {
            display: block;
            margin-bottom: 20px;
            text-align: center;
            width: 75%;
        }
        .signup-container label {
            display: block;
            margin-bottom: 5px;
            width: 75%;

        }
        .signup-container input {
            display: block;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 75%;
        }
        .signup-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .signup-container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Kayıt Ol</h2>
        <form id="signupForm">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Kayıt Ol">
            <div>
                <p><a href="index.php">Giriş</a</p>
            </div>
        </form>
        <div class="error" id="error"></div>
    </div>

    <script>
        document.getElementById('signupForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            await localStorage.setItem('username', username)

            await localStorage.setItem('password', password)
            window.location.href = 'index.php'

            
            // const correctUsername = 'admin';
            // const correctPassword = '12345';
            
            // const username = document.getElementById('username').value;
            // const password = document.getElementById('password').value;

            // if (username === correctUsername && password === correctPassword) {
            //     // Giriş başarılı
            //     window.location.href = 'process.php';
            // } else {
            //     // Giriş başarısız
            //     document.getElementById('error').textContent = 'Hatalı kullanıcı adı veya şifre';
            // }
        });
    </script>
</body>
</html>
