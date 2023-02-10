<?php
require_once "../assets/db/settings.php";

$id = "";
$id_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["identificacao"]))){
      $id_error = "Coloque uma ID válida.";     
  } else{
      $id = trim($_POST["identificacao"]);
  }
 
  if(empty($id_error)) {
      $sql = "DELETE FROM categorias WHERE id = ?";
       
      if($stmt = mysqli_prepare($link, $sql)){
          mysqli_stmt_bind_param($stmt, "i", $param_id);
          $param_id = $id;
          
          if(mysqli_stmt_execute($stmt)){
              header("location: gerenciar");
          } else{
              echo "O sistema está fora do ar. Tente novamente mais tarde";
          }
      mysqli_stmt_close($stmt);
      }else {
  echo "ERRO: " . mysqli_error($link);
}
  }
  mysqli_close($link);
}
?>