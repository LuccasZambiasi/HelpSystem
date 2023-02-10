<?php  
  require_once "assets/db/settings.php";
  $id = $_GET["id"];
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Base de Conhecimento</title>
        <link rel="icon" href="assets/favicon.png" sizes="64x64" />
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/styles.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    </head>
    <style>
        img {
            max-width: 722px;
            border-radius: 3px;
        }
        .test {
            text-transform: capitalize;
            display: inline-block;
        }
    </style>
    <body>
        <header class="header">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="assets/logo.png" class="img-fluid" alt="Logo" />
                        </div>
                    </div>
                    <h1>
                    Guia de dúvidas e respostas (FAQ)
                    </h1>
                    <form method="get" action="https://help.battlehost.com.br/find.php">
                        <input placeholder="Pesquise por algo específico" name="search" value="" />
                        <i class="fas fa-search"></i>
                    </form>
                </div>
            </div>
        </header>
        <main>
            <div class="container">
            <?php             
                $query = "SELECT * FROM categorias INNER JOIN artigos WHERE artigos.id = $id AND categorias.id = artigos.categoria";
                $res = mysqli_query($link, $query);

            while ($row = mysqli_fetch_array($res)) { ?>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Base de conhecimento</a></li>
                        <li class="breadcrumb-item"><?php echo $row['nome'] ?></li>
                        <?php 
                        $query2 = "SELECT * FROM artigos WHERE id = $id";
                        $res2 = mysqli_query($link, $query2);
        
                        while ($row2 = mysqli_fetch_array($res2)) {
                            $id2 = $row2['id'];
                        ?>                        
                        <li class="breadcrumb-item active" aria-current="page">
                            <?php echo $row2['titulo'] ?>
                        </li>
                    </ol>
                </nav>
                <div class="card card-article">
                    <h1><?php echo $row2['titulo'] ?></h1>
                    <h2><?php echo $row2['pequenadesc'] ?></h2>
                    <br />
                    <div style="color: #616161;">
                      <?php echo $row2['artigo'] ?>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </main>
        <footer class="footer">
            <div class="container">
                <h5>Sistema de Suporte</h5>
                <p><a href="noc/login">Login Administrativo</a><br>
                Feito com o <i class="fa-solid fa-heart" style="color: red"></i> por <a href="https://github.com/LuccasZambiasi">Lucas Zambiasi</a></p>
            </div>
        </footer>
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>