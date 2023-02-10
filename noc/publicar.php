<?php

require_once "../assets/db/settings.php";
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login");
    exit;
}

$pesquisa = "SELECT * FROM categorias";
$resultado_pesquisa = mysqli_query($link, $pesquisa);


if(mysqli_num_rows($resultado_pesquisa) < 1) {
  header("location: gerenciar");
  exit;
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
    <p>Base de conhecimento</p>
    <p>Usuário: <?php echo $_SESSION['username'] ?></p>
    <p><a href="admin">Voltar ao Início</a></p>

    <br><br>
    <div class="row">

    <div class="col-12">
    <h1 class="h3 mb-4 text-gray-800">Novo Artigo - Sistema de Suporte</h1>
          <form method="POST" enctype="multipart/form-data" id="form-publicar">
	          <label>Nome do Artigo</label>
	          <input type="text" name="titulo" class="form-control"><br>

	          <label>Pequena Descrição</label>
	          <input type="text" name="littledesc" class="form-control"><br>

	          <label>Artigo</label>
	          <textarea class="form-control" name="post" rows="5"></textarea><br>

            <label>Categoria</label>
            <select class="form-control" name="cat">
            <?php
            $pesquisa = "SELECT * FROM categorias";
            $resultado_pesquisa = mysqli_query($link, $pesquisa);
            
            while($row_buscas = mysqli_fetch_assoc($resultado_pesquisa)){ ?>
                <option name="cat" value="<?php echo $row_buscas['id'] ?>"><?php echo $row_buscas['nome'] ?></option>
            
            <?php } ?>
            </select>
	          <input type="submit" value="Criar Artigo" class="btn btn-outline-success btn-lg btn-block">
	          <input type="hidden" name="env" value="post">
          </form>
          <?php
	        if(isset($_POST['env']) && $_POST['env'] == "post"){
		        if($_POST['titulo'] && $_POST['littledesc']){
                date_default_timezone_set("Brazil/East");
                
                $data = date('d/m/Y');

                $idUser = $_SESSION['id'];
                $nome = $_SESSION['username'];
                $littledesc = $_POST['littledesc'];
		          	$titulo = $_POST['titulo'];
                $post = $_POST['post'];
                $stats = "1";
                $categoria = $_POST['cat'];


			          $query = $link->prepare("INSERT INTO artigos (id_postador, user_postador, titulo, data, categoria, artigo, status, pequenadesc) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
			          $query->bind_param("ssssssss", $idUser, $nome, $titulo, $data, $categoria, $post, $stats, $littledesc);
		          	$query->execute();

                $query2 = $link->prepare("UPDATE categorias SET `numposts` = `numposts` + 1 WHERE id=$categoria"); 
                $query2->execute();
                
		        if($query->affected_rows > 0 && $query2->affected_rows > 0) {
			        	echo "<div class='alert alert-success'>Artigo publicado com sucesso!</div>";
		      	}else{
			        	echo "<div class='alert alert-danger'>Erro ao enviar a publicação!</div>";
		      	}
        } else{
          echo "<div class='alert alert-danger'>Preencha todos os campos</div>";
        }
      } 
    	  
      ?>
    </div>

  </div>
</div>
