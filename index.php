<!--
  Sistema de Base de Conhecimento
  Inspiração: WHMCS  
  Icones: Flaticon
  Desenvolvimento: Lucas Zambiasi
-->
<?php
    require_once "assets/db/settings.php"; 
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
                    <form method="get" action="busca.php">
                        <input placeholder="Busque respostas..." name="search" />
                        <i class="fas fa-search" name="env" value="post" type="submit" ></i>
                        <?php
                        if(isset($_GET['env']) && $_GET['env'] == "post"){
                            if($_POST['search']){
                            $duvida = $mysqli->real_escape_string($_GET['search']);

                            header("location: busca?search=$duvida");
                            exit;
                        } else{
                        echo "<div class='alert alert-danger'>Preencha todos os campos</div>";
                        }
                    }   
                    ?>
                    </form>
                </div>
            </div>
        </header>
        <main>
            <div class="container">
                <?php             
                $query = "SELECT * FROM categorias";
                $res = mysqli_query($link, $query);

            while ($row = mysqli_fetch_array($res)) { ?>
                <a href="categoria?id=<?php echo $row["id"] ?>" class="flex-link">
                    <div class="card flex-card mb-3">
                        <i class="<?php echo $row["icone"]?>" style="padding: 20px; font-size: 3em"></i>
                        <div>
                            <div class="title"><?php echo $row["nome"] ?> </div>
                            <div class="subtitle"><?php echo $row["numposts"] ?> artigos nesta coleção</div>
                        </div>
                    </div>
                </a>
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