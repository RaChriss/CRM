<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Système de Gestion Budgétaire</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-content">
                        <i class="fas fa-chart-line budget-icon"></i>
                        <h3>Connexion</h3>
                        <div class="system-name">Système de Gestion Budgétaire Départemental</div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <?= $error ?>
                        </div>
                    <?php endif; ?>
                    <form action="authenticate" method="post">
                        <div class="form-group">
                            <label for="name">Nom d'utilisateur</label>
                            <div class="input-group">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" name="name" id="name" class="form-control icon-input" required autocomplete="username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <div class="input-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" name="password" id="password" class="form-control icon-input" required autocomplete="current-password">
                                <div class="input-group-append">
                                    <span class="input-group-text password-toggle" onclick="togglePasswordVisibility()">
                                        <i class="fa fa-eye" id="password-icon"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/fontawesome.all.js"></script>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var passwordIcon = document.getElementById('password-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>