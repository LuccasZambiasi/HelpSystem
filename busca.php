<?php  
    require_once "assets/db/settings.php";
    $search = $_GET["search"];
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
                $query = "SELECT * FROM artigos WHERE artigo LIKE '%$search%' AND status = '1'";
                $res = mysqli_query($link, $query);

                if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_array($res)) { 
                $id = $row['id'];
                ?>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Base de conhecimento</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span class="first"><?php echo $search?></span>
                        </li>
                    </ol>
                </nav>
                <div class="card card-category">
                    <ul class="cards">
                        <li onclick="location.href = 'artigo?id=<?php echo $id ?>'">
                            <h5 class="cards-title"><?php echo $row['titulo'] ?></h5>
                            <p class="cards-resume">
                                <?php echo $row['pequenadesc'] ?>
                            </p>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } else { 
                    echo "Sem resultados!";
                } ?>
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