<?php
require_once "../assets/db/settings.php";
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login");
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
    <div class="col-12" style="border: 1px solid black">
    <h1 class="h3 mb-4 text-gray-800">Nova Categoria</h1>
          <form method="POST" enctype="multipart/form-data" id="form-publicar">
	          <label>Nome da Categoria</label>
	          <input type="text" name="titulo" class="form-control"><br>

	          <label>Icone da Categoria (https://fontawesome.com/icons)</label>
	          <input type="text" name="icone" class="form-control"><br>

	          <input type="submit" value="Criar Categoria" class="btn btn-outline-success btn-lg btn-block">
	          <input type="hidden" name="env" value="post">
          </form>
          <?php
	        if(isset($_POST['env']) && $_POST['env'] == "post"){
		        if($_POST['titulo'] && $_POST['icone']){
		          	$titulo = $_POST['titulo'];
                $icone = $_POST['icone'];
                $num = 0;

			          $query = $link->prepare("INSERT INTO categorias (nome, icone, numposts) VALUES (?, ?, ?)");
			          $query->bind_param("sss", $titulo, $icone, $num);
		          	$query->execute();
                
		        if($query->affected_rows > 0) {
			        	echo "<div class='alert alert-success'>Categoria criada com sucesso!</div>";
		      	}else{
			        	echo "<div class='alert alert-danger'>Erro ao criar a categoria!</div>";
		      	}
        } else{
          echo "<div class='alert alert-danger'>Preencha todos os campos</div>";
        }
      } 
    	  
      ?>
    </div>

    <br><br>
    <div class="col-12" style="border: 1px solid black">
  <form class="user" action="excluircat.php" method="post"> 
  <div class="form-group">
  <h1 class="h3 mb-4 text-gray-800">Excluir Categoria</h1>

    <div class="form-group">  
      <input type="number" name="identificacao" value="" class="form-control form-control-user" placeholder="Identificação (exemplo: 1)">
      <span class="help-block">OBS: Essa ação não pode ser desfeita.</span>
    </div>
  </div>
  <input type="submit" name="submit" class="btn btn-outline-primary btn-lg btn-block" value="Excluir" />
</form>
    </div>

  </div>
</div>
