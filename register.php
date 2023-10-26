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
}else {
    $user_id = null;
    $username = null;
    $_SESSION['admin'] = null;
    $_SESSION['email'] = null;
    $_SESSION['image'] = null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nome'])) {
        if (isset($_POST['email'])) {
            if (isset($_POST['senha'])) { 
                header('Location:  index.php');
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Casas</title>
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
            <li><a href="index.php" id="backgroundblack">Home</a></li>
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
            <li><a href="contato.php">Contate-nos</a></li>
        </ul>
    </nav>

    <main>
        <form>
        <div id="nome" style="display:block;" >Nome:<br><input type="text" placeholder="Coloque seu nome aqui" name="nome"></div>
        <div id="email" style="display:none;">CPF:<input type="text" name="cpf" onblur="formataCPF(this)" pattern="[0-9]{11}" placeholder="Digite um CPF no formato: xxx.xxx.xxx-xx">
</div>
        <div id="senha" style="display:none;" >Senha:<br><input type="password"placeholder="Coloque sua senha aqui" name="senha"></div>
        <input type="submit" method="POST" style="display:none;" id="buttonsub" value="Finalizar">
        </form>
        <input type="submit" onclick="prox()" id="buttonsubs" style="display:block;">
    </main>

    <footer>
        <p>&copy; 2010 Salles Corretoria. Todos os direitos reservados.</p>
    </footer>
    <script type="text/javascript">
function prox() {
        var nome = document.getElementById('nome').style.display;
        var email = document.getElementById('email').style.display;
        var senha = document.getElementById('email').style.display;
        var buttonsub = document.getElementById('buttonsub').style.display;
        var buttonsubs = document.getElementById('buttonsubs').style.display;
        if(nome == "block") {
            document.getElementById('nome').style.display = 'none';
            document.getElementById('email').style.display = 'block';
        } if (email == "block") {
            document.getElementById('email').style.display = 'none';
            document.getElementById('senha').style.display = 'block';
            document.getElementById('buttonsub').style.display = 'block';
            document.getElementById('buttonsubs').style.display = 'none';
        } if (senha == "block") {
            document.getElementById('email').style.display = 'none';
            document.getElementById('senha').style.display = 'block';
        }
        
    }
function formataCPF(cpf) {
const elementoAlvo = cpf
const cpfAtual = cpf.value   

let cpfAtualizado;

cpfAtualizado = cpfAtual.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, 
 function( regex, argumento1, argumento2, argumento3, argumento4 ) {
        return argumento1 + '.' + argumento2 + '.' + argumento3 + '-' + argumento4;
})  
elementoAlvo.value = cpfAtualizado; 
}    
    </script>
    <script src="script.js"></script>
</body>
</html>
</html>