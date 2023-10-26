
<?php
session_start();
require_once 'config.php';

// Checa se o usuario está logado
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $nome = $_SESSION['nome'];
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

// Define a quantidade de posts por página
$posts_per_page = 6;

// Pega o número da página atual
if (isset($_GET['page'])) {
    $page_number = intval($_GET['page']);
} else {
    $page_number = 1;
}

// Define o índice do primeiro post da página atual
$start_index = ($page_number - 1) * $posts_per_page;

// Pega todos os posts do banco de dados, limitados pela quantidade de posts por página e ordenados pela data
$sql = "SELECT casa.id, casa.endereco, casa.precovenda, casa.precoal, casa.acombinar, casa.dormitorios, casa.suite, casa.casa, casa.bairro , casa.banheiros, casa.venda, casa.cidade, casa.area, casa.estado, casa.enabled, casa.vagas, casa.aluguel
        FROM casa
        ORDER BY casa.id DESC LIMIT $start_index, $posts_per_page";
$result = mysqli_query($conn, $sql);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $casas = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        // Não há resultados na consulta
        $casas = array();
    }
} else {
    // Tratar o erro da consulta SQL
    die(mysqli_error($conn));
}

// Pega o número total de posts
$sql = "SELECT COUNT(*) AS count FROM casa";
$result = mysqli_query($conn, $sql);
$count_row = mysqli_fetch_assoc($result);
$post_count = $count_row['count'];

// Calcula o número total de páginas
$page_count = ceil($post_count / $posts_per_page);
?>
<?php
//Logins 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["nome"])) {
    if ($_POST["nome"]<>"") {
        if ($_POST["email"]<>"") {
            if ($_POST["senha"]<>"") {
                $nome = $_POST["nome"];
                $email = $_POST["email"];
                $senha = $_POST["senha"];
            
                $sqll = "INSERT INTO usuario (nome, email, senha, admin, image_path) VALUES ('$nome', '$email', '$senha', '0', 'avatars.png')";
                $resultt = mysqli_query($conn, $sqll);
                
                if (!$result) {
                    echo '<p>Teve um erro criando o Usuario.</p>';
                } else {
                    $sqll = "SELECT * FROM usuario WHERE nome=$nome";
                    $resultt = mysqli_query($conn, $sqll);
                    $iduser = mysqli_fetch_all($resultt, MYSQLI_ASSOC);
                    foreach ($iduser as $user) {
                        $user_id = $user["id"];
                    }
                    $_SESSION["nome"] = $nome;
                    $_SESSION["email"] = $email;
                    $_SESSION["admin"] = 0;
                    $_SESSION["image"] = "avatars.png";
                    $_SESSION["user_id"] = $user_id;
                    echo '';
                }
            }   
            else {
                echo "Erro! Senha Não Inserida";
            } 
        }
        else {
            echo "Erro! Email Não Inserido";
        } 
    }
    else {
        echo "Erro! Nome Não Inserido";
    } 
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["login"])) {
    if ($_POST["login"]<>"") {
        if ($_POST["senha"]<>"") {
            $nome = $_POST["login"];
            $senha = $_POST["senha"];
        }
        else {
            echo "Erro! Senha Não Inserida";
        } 
    }
    else {
        echo "Erro! Login Não Inserido";
    } 
}
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .formm {
            display: flex;
            flex-direction: row;
        }
        :root {
            --laranja: rgb(255, 136, 0)
        }

        article {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: white;
            box-shadow: black 0px 0px 25px 2px;
            text-align: center;
            min-width: 400px;
            width: 30%;
            border-radius: 20px;
            overflow: hidden;
            margin: 1em;
            padding: 0px 0 10px 0;
        }

        article .title {
            width: 100%;
            padding: 10px;
            font-size: 1.2em;
            font-family: Arial, Helvetica, sans-serif;
            background-color: var(--laranja);
            color: white;
        }

        article img {
            width: 100%;
        }

        article h3 {
            font-size: 1.2em;
            font-family: Arial, Helvetica, sans-serif;
            margin: .5em 0;
        }

        article ul {
            width: 100%;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-evenly;
            margin: 1em 0;
        }

        article ul li {
            text-decoration: none;
            list-style: none;
        }

        article p {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            width: 50%;
            flex-wrap: wrap;
            padding: 10px;
            border-radius: 20px;
        }

        article p span {
            border-radius: 7px;
            padding: 5px;
            background: var(--laranja);
            font-size: 1.2em;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
            margin: .5em 0;
        }

        article a {
            width: 95%;
            font-size: 1.2em;
            padding: 10px;
            border-radius: 5px;
            background: var(--laranja);
            text-align: center;
            text-decoration: none;
            color: white;
        }

        article .side-inputs {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 3.5em;
            margin: .5em;
        }

        article input {
            display: flex;
            flex-direction: row;
            align-items: center;
            font-size: 1.6em;
            padding: 5px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            color: white;
        }

        .remove {
            background-color: red;
        }

        .mod {
            background-color: rgb(57, 243, 57);
        }
        .Adicionar {
            background-color: rgb(26, 125, 255);
        }
    </style>
    <title>Navbar</title>
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
            echo '<li><a href="logout.php">Sair</a></li>';
            }
            else {
                echo '<li><a href="#" onclick="login()">Logar</a></li>
                <li><a href="#" onclick="register()">Registrar</a></li>';
            }
            ?>
            <li><a href="contato.php">Contate-nos</a></li>
        </ul>
    </nav>

    <main>
<?php
    foreach ($casas as $casa) {
            if ($casa['enabled'] == 1) {
            } else {
            $casa_id = $casa['id'];
            if ($casa['aluguel'] == 1) { $alugueles = "Aluguel";} else {$alugueles = "";}
            if ($casa['venda']==1){
                $vendaes = "Venda";
                if ($casa['aluguel'] == 1) { $alugueles = ", Aluguel";} else {$alugueles = "";}
            }
            else {
                $vendaes = "";
            }
            if ($casa["dormitorios"] == 0) {
                $dorm = "---";
            } else {
                $dorm = $casa["dormitorios"];        
            }
            if ($casa["suite"] == 0) {
                $suite = "---";
            } else {
                $suite = $casa["suite"];        
            }
            if ($casa["vagas"] == 0) {
                $vagas = "---";
            } else {
                $vagas = $casa["vagas"];        
            }
            if ($casa["banheiros"] == 0) {
                $banheiros = "---";
            } else {
                $banheiros = $casa["banheiros"];        
            }
            if ($casa["area"] == 0) {
                $area = "---";
            } else {
                $area = $casa["area"];        
            }
            echo '<form class="formm">
            <article>
                <span class="title">OPORTUNIDADE</span>
                <img src="https://vault.imob.online/resized/u1936/properties/photos/17330769/vXPoHgcoXDZsalZ5AhuZoV3h-whatsapp-image-2023-06-03-at-130445-1.jpg/klarge.jpg"
                    alt="Apartamento, código 2461 em Santos, bairro Gonzaga">
                <h3>'. $casa["casa"].' para <b>'. $vendaes .''. $alugueles.'</b><br> em <b>'. $casa["cidade"].'</b>
                </h3>
                <ul>
                    <li><i></i><br><span>Dorm.</span><br><b>'.$dorm.'</b></li>
                    <li><i></i><br><span>Suítes</span><br><b>'.$suite.'</b></li>
                    <li><i></i><br><span>Vagas</span><br><b>'.$vagas.'</b></li>
                    <li><i></i><br><span>Banheiros</span><br><b>'.$banheiros.'</b></li>
                    <li><i></i><br><span>Área </span><br><b>'.$area.'m2</b></li>
                </ul>';
                if ($vendaes <> "") {
                echo '<p> <span>Venda </span><b>'.$casa['precovenda'].'</b> </p>';
                }
                if ($alugueles <> "") {
                echo '<p> <span>Aluguel </span><b>'.$casa['precoal'].'</b> </p>';
                } echo '
                <p> </p>
        
                <div class="side-inputs">
                </div>
                <a href="casa.php/?id='.$casa_id.'">Saiba mais informações</a>
            </article>
            </form>'; }}
echo '</div>';

    if ($page_count > 1) {
       echo '<nav class="pagination"> 
       <ul>';
           if ($page_number > 1) { 
           echo '<li class="prev"> <a href="index.php?page='. $page_number - 1 . '">Anterior</a></li>';
}
for ($i = 1; $i <= $page_count; $i++) {
    if ($i == 1 || $i == $page_count || abs ($i - $page_number) <=2) {
    echo '<li>
          <a href="index.php?page='. $i . '">'.$i.'</a>
          </li>';
}
    elseif ($i == 2 && $page_number > 4) {
        echo '<li>...</li>';              
}
    elseif ($i == $page_count - 1 && $page_number < $page_count - 3) {
        echo '<li>...</li>';
}
}
if ($page_number < $page_count) {
    echo '<li class="next"> <a href="index.php?page='. $page_number + 1 . '">Próximo</a></li>';
}
echo '</ul>
      </nav>';
}
?>
</div>
    </main>

    <footer>
        <p>&copy; 2010 Salles Corretoria. Todos os direitos reservados.</p>
    </footer>
    <script>
    };
</script>
    <script src="script.js"></script>
                    <?php
    foreach ($casas as $casa) {
        echo  '<form>
                <a href="casas.php?id='.$casa['id'].'"> 
                <article border="1px">
                
                <h2>'. $casa["casa"]. ' '.$casa["bairro"].' com '.$casa["area"].' m²</h2>
                <p>'. $casa["endereco"]. '</p>
                
                <div class="image-slider">';
                $id_imovel = $casa['id'];
        $sql = "SELECT image_path FROM Imagem WHERE id_imovel = $id_imovel";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_imovel);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Loop para exibir as imagens em HTML
        while ($row = $result->fetch_assoc()) {
            $imagePath = $row['image_path'];
            echo "<div><img src='$imagePath' alt='Imagem'></div>";
        }
        
        echo '</div>
              </article>
              </a>
              </form>';
        
        // Feche a conexão com o banco de dados
        $stmt->close();
        $conn->close();
    }

    
    echo '</div>';

    if ($page_count > 1) {
       echo '<nav class="pagination"> 
       <ul>';
           if ($page_number > 1) { 
           echo '<li class="prev"> <a href="index.php?page='. $page_number - 1 . '">Anterior</a></li>';
}
for ($i = 1; $i <= $page_count; $i++) {
    if ($i == 1 || $i == $page_count || abs ($i - $page_number) <=2) {
    echo '<li>
          <a href="index.php?page='. $i . '">'.$i.'</a>
          </li>';
}
    elseif ($i == 2 && $page_number > 4) {
        echo '<li>...</li>';              
}
    elseif ($i == $page_count - 1 && $page_number < $page_count - 3) {
        echo '<li>...</li>';
}
}
if ($page_number < $page_count) {
    echo '<li class="next"> <a href="index.php?page='. $page_number + 1 . '">Próximo</a></li>';
}
echo '</ul>
      </nav>';
}
?>`
        document.getElementById('resultadologin').innerHTML = resultado;
        }
        </script>
</body>
</html>