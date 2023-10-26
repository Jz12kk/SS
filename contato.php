<?php
session_start();
require_once 'config.php';

// Checa se o usuario está logado
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $admin = $_SESSION['admin'];
    $image = $_SESSION['image'];
} else {
    $user_id = null;
    $username = null;
    $_SESSION['admin'] = null;
    $_SESSION['email'] = null;
    $_SESSION['image'] = null;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contate-nos</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <nav>
        <div class="navbar-header">
            <img src="logosalles.png" width="76px" height="9%" onclick="toggleimage()" class="navbar-toggle">
            <button type="button" class="navbar-toggle" id="navbar-toggle2" onclick="toggleMenu()">
                <span class="menu-icon"></span>
                <span class="menu-icon"></span>
                <span class="menu-icon"></span>
            </button>
        </div>
        <ul class="navbar-menu" id="navbar-menu">
            <li><img src="logosalles.png" class="image-logo"></li>
            <li><a href="index.php">Home</a></li>
            <li><a href="chat.php">Chat</a></li>
            <?php
            if ($user_id) { 
            echo '<li><a href="perfil.php?id='.$user_id.'">Perfil</a></li>';
            }
            else {
                echo '<li><a href="login.php">Logar</a></li>
                <li><a href="register.php">Registrar</a></li>';
            }
            ?>
            <li><a href="contato.php" id="backgroundblack">Contate-nos</a></li>
        </ul>
    </nav>

    <main>
        <h1 class="titulocontatomarcelo"><strong>Marcelo Salles</strong></h1>
        <h1 class="perito">Perito Judicial em Avaliação de Imóveis</h1>
        <h1 class="numero"> (14) 99623-2353 </h1>
        <img src="imagewhatsapp.png" class="icon"></img>

    </main>

    <footer>
        <p>&copy; 2010 Salles Corretoria. Todos os direitos reservados.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
</html>