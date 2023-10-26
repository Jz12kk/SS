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
    <title>Nova Casa</title>
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
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['estado']<>"") {
    if ($_POST['cidade']<>"") {
    if ($_POST['rua']<>"") {
        if ($_POST['numcasa']<>"") {
        if ($_POST['casaitem']<>"") {
            if ($_POST['bairro']<>"") {
        if ($_POST['dormitorios']<>"") {
            if ($_POST['banheiros']<>"") {
                if ($_POST['preco']<>"") {
                    if ($_POST['area']<>"") {
                        if ($_POST['select'] <> "") {
                            if ($_POST['selectal'] <> "") {
                                if ($_POST['selectal'] == 0 and $_POST['select'] <> 0 or $_POST['selectal'] <> 0 and $_POST['select'] == 0)
                            $endereco = mysqli_real_escape_string($conn, $_POST['rua']);
                            $numcasa = mysqli_real_escape_string($conn, $_POST['numcasa']);
                            $endereco .= ', '.$numcasa;
                            $preco = mysqli_real_escape_string($conn, $_POST['preco']);
                            $area= mysqli_real_escape_string($conn, $_POST['area']);
                            $dormitorios = mysqli_real_escape_string($conn, $_POST['dormitorios']);
                            $suite = mysqli_real_escape_string($conn, $_POST['suite']);
                            $vagas = mysqli_real_escape_string($conn, $_POST['vagas']);
                            $banheiros = mysqli_real_escape_string($conn, $_POST['banheiros']);
                            $casaitem = mysqli_real_escape_string($conn, $_POST['casaitem']);
                            $bairro = mysqli_real_escape_string($conn, $_POST['bairro']);
                            $cidade = mysqli_real_escape_string($conn, $_POST['cidade']);
                            $estado = mysqli_real_escape_string($conn, $_POST['estado']);
                            $venda = mysqli_real_escape_string($conn, $_POST['venda']);  
                            $aluguel = mysqli_real_escape_string($conn, $_POST['aluguel']);    

                                $sql = "INSERT INTO casa (endereco, casa, bairro, banheiros, dormitorios, suite, vagas, preco, area, venda, aluguel, cidade, estado) VALUES ('$endereco', '$casaitem', '$bairro', '$banheiros', '$dormitorios', '$preco', '$area', '1', '$cidade', '$estado')";
                                $result = mysqli_query($conn, $sql);
                                
                                if (!$result) {
                                    echo '<p>Teve um erro criando a casa.</p>';
                                } else {
                                    echo '<p>A casa foi criado com sucesso.</p>';
                                }
                            }
                        }
                            mysqli_close($conn);
                        }
                    }
                }
            } 
        }
    }
}}}
}
    }
?>
    <main>
        <form method="post" autocomplete="off">
        <label for="cepInput">CEP:</label>
        <input type="number" id="cepInput" maxlength="8"><br>
        <button type="button" onclick="buscarCidadePorCEP()">Consultar</button><br>
        <div id="resultado">
        <br></div>
        <label>Banheiros:</label>
        <input type="number" name="banheiros" ></input>
        <br>
        <label>Dormitorios:</label>
        <input type="number" name="dormitorios"></input>
        <br>
        <label>Suites:</label>
        <input type="number" name="suite"></input>
        <br>
        <label>Vagas:</label>
        <input type="number" name="vagas"></input>
        <br>
        <select name="casaitem">
        <option value="" name="" selected>Tipo de Casa</option>
        <option value="Casa" name="">Casa</option>
        <option value="Sobrado" name="" >Sobrado</option>
        <option value="Apartamento" name="" >Apartamento</option>
        <option value="Condomínio" name="" >Condomínio</option>
        <option value="Fazenda" name="" >Fazenda</option>
        <option value="Chácara" name="" >Chácara</option>
        <option value="Terreno" name="" >Terreno</option>
        <option value="Sítio" name="" >Sítio</option>
        </select>
        <br>
        <label>Area:</label>
        <input type="real" name="area"></input>
        <br>
        <label>Venda:</label>
        <select name="select" id="select" onclick="vendavalorzin()">
        <option value="" selected>Selecione Uma Opcao</option>
        <option value="0" name="aluguel">Nao</option>
        <option value="1" name="venda">Sim</option>
        </select>
        <div id="vendavalor"></div>
            <br>
        <label>Aluguel:</label>
        <select name="selectal" onchange="aluguelvalorzin()">
        <option value="">Selecione Uma Opcao</option>
        <option value="0" name="aluguel" onchange="aluguelvalornao()">Nao</option>
        <option value="1" name="venda" id="simaluguel">Sim</option>
        </select>
        <div id="aluguelvalor"></div>

        <input type="submit" value="Salvar" name="POST"></form>
    </main>

    <footer>
        <p>&copy; 2010 Salles Corretoria. Todos os direitos reservados.</p>
    </footer>
    <script>

const scta = document.querySelector('#selectal')
scta.onclick = (event) => {
    event.preventDefault();
    alert(scta.value);
    var vass = scta.value;
    if (vass=0) {
        let ress = ``;}
        else {
        document.getElementById('aluguelvalor').innerHTML = ress;
    }
    let ress = `<br>Valor da Locacao:<input type="real" name="valoral">`
    document.getElementById('aluguelvalor').innerHTML = ress;
}





function buscarCidadePorCEP() {
  const cep = document.getElementById('cepInput').value;
  const url = `https://viacep.com.br/ws/${cep}/json/`;

  fetch(url)
    .then(response => response.json())
    .then(data => {
      if (data.erro) {
        let resultado = '';
        resultado += `CEP não encontrado<br>
        Rua:<input type="text" name="rua"><br>Número:<input type="text" name="numcasa"><br>
        Bairro:<input type="text" name="bairro"><br>
        Cidade:<input type="text" name="cidade"><br>
        Estado:<input type="text" name="Estado"><br>`;
        document.getElementById('resultado').innerHTML = resultado;
      } else {
        const cep = data.cep;
        const logradouro = data.logradouro;
        const bairro = data.bairro;
        const cidade = data.localidade;
        const estado = data.uf;

        // Exibir os dados na página
        let resultado = '';
        if (cep) {
            resultado += `Cep:<input type="text" readonly value="${cep}" name="cep"><br>`;
        }
        if (logradouro) {
          resultado += `Rua:<input type="text" readonly value="${logradouro}" name="rua"><br>Número:<input type="text" name="numcasa"><br>`;
        }else {
            resultado += `Rua:<input type="text" name="rua"><br>Número:<input type="text" name="numcasa"><br>`
        }
        if (bairro) {
            resultado += `Bairro:<input type="text" readonly value="${bairro}" name="bairro"><br>`;
        }else if (bairro=='') {
            resultado += `Bairro:<input type="text" name="bairro"><br>`
        }
        if (cidade) {
          resultado += `Cidade:<input type="text" readonly value="${cidade}" name="cidade"><br>`;
        }else {
            resultado += `Cidade:<input type="text" name="cidade"><br>`
        }
        if (estado) {
          resultado += `Estado:<input type="text" readonly value="${estado}" name="estado">`;
        }else {
            resultado += `Estado:<input type="text" name="Estado"><br>`
        }
        document.getElementById('resultado').innerHTML = resultado;
        console.log (`${estado}, ${cidade}, ${bairro}, ${logradouro}, ${cep}`);
      }
    })
    .catch(error => {
        let resultado = '';
$resultado = `CEP não encontrado<br>
Rua:<input type="text" name="rua"><br>Número:<input type="text" name="numcasa"><br>
Bairro:<input type="text" name="bairro"><br>
Cidade:<input type="text" name="cidade"><br>
Estado:<input type="text" name="estado"><br>`;
      console.log('Erro ao consultar o CEP:', error);
      document.getElementById('resultado').innerHTML = resultado;
    });
}
    </script>
    <script src="script.js"></script>
</body>
</html>
</html>