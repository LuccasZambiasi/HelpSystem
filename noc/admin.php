<?php
require_once "../assets/db/settings.php";
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Base de Conhecimento</title>
        <link rel="icon" href="../assets/favicon.png" sizes="64x64" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-shims.min.css" media="all">
        <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all">
        <script src="https://kit.fontawesome.com/4cfd508d4f.js"></script>
        <link rel="stylesheet" href="estilo.css" />
    </head>
        <header class="header">
            <div class="content">
                <div class="container">
                    <h1>
                        Área Administrativa
                    </h1>
                </div>
            </div>
        </header>

<div class="container">
    <br>
    <hr>
    <p><b>Usuário:</b> <?php echo $_SESSION['username']; ?></p>
    <p><b>Email:</b> <?php echo $_SESSION['email']; ?></p>
    <?php echo'<a class="btn btn-info" href="logout?token='.md5(session_id()).'">Deslogar-se</a>' ?>
    <hr>
  <div class="row">
      <div class="col-12">
        <form name="createcategory" action="gerenciar">
          <button type="submit" name="createcategory" class="btn btn-outline-primary">Criar nova categoria</button>
          <br><br>
        </form>
        <form name="create" action="publicar">
          <button type="submit" name="create"class="btn btn-outline-primary">Criar novo artigo</button>
          <br><br>
        </form>
        <hr>
      </div>
      
      <div class="col-12">
      <span style="font-size: 30px; color: darkblue"><b>Categorias e Artigos</b></span><br><br>
        <?php
        $query = "SELECT * FROM categorias";
        $res = mysqli_query($link, $query);

        while ($row = mysqli_fetch_array($res)) {
            echo '<span style="font-size: 25px;"><b>' . $row['id'] . ' | ' . $row['nome'] . '</b></span><br>';

            $query2 = "SELECT * FROM artigos WHERE categoria = '" . $row['id'] . "'";
            $res2 = mysqli_query($link, $query2);

            while ($row2 = mysqli_fetch_array($res2)) {
                echo '- <a href="topico?id=' . $row2['id'] . '">' . $row2['titulo'] . '</a><br>';
            }
            echo '<hr>';
        }
        ?>
        </p>
  </div>
  </div>
</div>
