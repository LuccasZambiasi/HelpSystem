<?php
session_start();
 
require_once "../assets/db/settings.php";

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: admin");
        exit;
}
 
$email = $password = "";
$email_err = $password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
     if(empty(trim($_POST["email"]))){
        $email_err = "Coloque um email.";
    } else{
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Coloque sua senha.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($email_err) && empty($password_err)){
        $sql = "SELECT id, username, email, username, password FROM users WHERE email = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            $param_email = $email;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                  if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $email, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $email;                      
                            
                            header("location: admin");
                        } else {
                            $password_err = "Senha incorreta.";
                        }
                    }
                } else{
                    $email_err = "Não existe uma conta com esse email.";
                }
            } else{
                echo "Oops! O sistema está fora do ar.";
            }
        }
        mysqli_stmt_close($stmt);
    } else {
    echo "ERRO: " . mysqli_error($link);
}
mysqli_close($link);
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-shims.min.css" media="all" />
        <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all" />
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
        <div class="row">
            <div class="col-12">
                <div class="card-body">
                    <div class="h6 font-weight-bold text-body mb-4 mt-3">Entre usando sua conta</div>
                    <form method="post" name="post_login">
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label for="email">E-mail</label>
                            <input id="email" type="email" name="email" value="<?php echo $email; ?>" class="form-control" required />
                            <span class="help-block"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label for="password">Senha</label>
                            <input id="password" type="password" value="<?php echo $password; ?>" name="password" class="form-control" required />
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div>
                        <button class="btn btn-primary btn-lg btn-rounded btn-block mt-4 mb-4" type="submit" name="post_login">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</html>
