<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Register - AutoMarket</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <div class="container navbar">
        <div class="logo">
            <a href="index.html">AutoMarket</a>
        </div>
        <nav>
            <ul>
                <li><a href="index.html">Kryefaqja</a></li>
                <li><a href="about.html">Rreth nesh</a></li>
                <li><a href="cars.html">Makina</a></li>
                <li><a href="login.html">Login</a></li>
                <li><a href="register.html">Register</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <div class="form-wrapper">
        <h2>Krijo llogari të re</h2>
        <form action="#" method="post">
            <div class="form-group">
                <label for="reg-name">Emri i plotë</label>
                <input type="text" id="reg-name" name="name" required>
            </div>
            <div class="form-group">
                <label for="reg-email">Email</label>
                <input type="email" id="reg-email" name="email" required>
            </div>
            <div class="form-group">
                <label for="reg-password">Fjalëkalimi</label>
                <input type="password" id="reg-password" name="password" required>
            </div>
            <div class="form-group">
                <label for="reg-confirm">Përsërit fjalëkalimin</label>
                <input type="password" id="reg-confirm" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-block">Register</button>
        </form>
    </div>
</main>

<footer>
    <div class="container">
        <p>&copy; 2025 AutoMarket.</p>
    </div>
</footer>
</body>
</html>
