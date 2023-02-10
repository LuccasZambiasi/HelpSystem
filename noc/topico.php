<?php

require_once "../assets/db/settings.php";
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login");
    exit;
}

$id = $_GET["id"];

$query = "SELECT * FROM artigos where id = $id";
$res = mysqli_query($link, $query);

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
          <form method="POST" enctype="multipart/form-data" id="form-edit">
            <?php while ($row = mysqli_fetch_array($res)) { ?>
	          <label>Nome do Artigo</label>
	          <input type="text" name="titulo" value="<?php echo $row['titulo'] ?>" class="form-control"><br>

	          <label>Pequena descrição</label>
	          <input type="text" name="littledesc" value="<?php echo $row['pequenadesc'] ?>" class="form-control"><br>

            <label>Artigo</label>
	          <textarea name="texto" class="form-control" rows="10"><?php echo $row['artigo'] ?></textarea><br>

            <label>Visibilidade</label>
	          <input type="text" name="sdfsdf" value="<?php 
            if($row['status'] == 1) {
              echo "Artigo Visível!";
              } else {
              echo "Artigo Invisível!";
            }?>" disabled class="form-control"><br>

            <label>Categoria</label>
            <select class="form-control" name="cat">
            <?php
            $pesquisa = "SELECT * FROM categorias";
            $resultado_pesquisa = mysqli_query($link, $pesquisa);
            
            while($row_buscas = mysqli_fetch_assoc($resultado_pesquisa)){ ?>
                <option name="cat" value="<?php echo $row_buscas['id'] ?>"><?php echo $row_buscas['nome'] ?></option>
            
            <?php } ?>
            </select><br>

	          <input type="submit" value="Atualizar" class="btn btn-outline-success btn-lg btn-block">
	          <input type="hidden" name="env" value="post">
          </form>
          <?php
	        if(isset($_POST['env']) && $_POST['env'] == "post"){
		        if($_POST['titulo'] && $_POST['texto']){
		          	$titulo = $_POST['titulo'];
                $pequenadesc = $_POST['littledesc'];
                $artigo = $_POST['texto'];
                $categoria = $_POST['cat'];

			          $query = $link->prepare("UPDATE artigos SET titulo=?, pequenadesc=?, artigo=?, categoria=? WHERE id = $id");
			          $query->bind_param("ssss", $titulo, $pequenadesc, $artigo, $categoria);
		          	$query->execute();
                
		        if($query->affected_rows > 0) {
              header("location: topico?id=$id");
		      	}else{
			        	echo "<div class='alert alert-danger'>Erro ao enviar a publicação!</div>";
		      	}
        } else{
          echo "<div class='alert alert-danger'>Preencha todos os campos!</div>";
        }
      }
    ?>
    <br>
    <form method="POST" enctype="multipart/form-data" id="form-delete">
	          <input type="submit" value="Deletar Artigo" class="btn btn-outline-danger btn-lg btn-block">
	          <input type="hidden" name="enviar" value="post">
    </form>
    <?php
	        if(isset($_POST['enviar']) && $_POST['enviar'] == "post"){
			          $query = $link->prepare("DELETE FROM artigos WHERE id=$id");
		          	$query->execute();

                $cate = $row['categoria'];
                $query2 = $link->prepare("UPDATE categorias SET `numposts` = `numposts` - 1 WHERE id=$cate"); 
                $query2->execute();
                
		        if($query->affected_rows > 0 && $query2->affected_rows > 0) {
              header("location: admin");
		      	}else{
			        	echo "<div class='alert alert-danger'>Erro!</div>";
		      	}
      } 
      ?>
      <form method="POST" enctype="multipart/form-data" id="form-visibility">
        <?php 
          if($row['status'] == 1) {
            echo '<input type="submit" value="Desabilitar Artigo" class="btn btn-outline-info btn-lg btn-block">';
            } else {
              echo '<input type="submit" value="Habilitar Artigo" class="btn btn-outline-info btn-lg btn-block">';
          }
        ?>
	          <input type="hidden" name="sttsenviar" value="post">
    </form>
    <?php
	        if(isset($_POST['sttsenviar']) && $_POST['sttsenviar'] == "post"){
                
            if($row['status'] == 1) {
              $stts = 0;
            } else {
              $stts = 1;
            }
			          $query = $link->prepare("UPDATE artigos SET status=? WHERE id = $id");
                $query->bind_param("s", $stts);
		          	$query->execute();
                
		        if($query->affected_rows > 0) {
              echo "<div class='alert alert-success'>Sucesso! Visibilidade alterada!</div>";
		      	}else{
			        	echo "<div class='alert alert-danger'>Erro!</div>";
		      	}
      } 
      ?>
    <?php } ?>
    </div>
    <br><br>
  </div>
</div>
