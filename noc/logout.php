<?php
session_start();
$token = md5(session_id());
if(isset($_GET['token']) && $_GET['token'] === $token) {
   session_destroy();
   header("location: login");
   exit();
} else {
   echo '<a href="logout?token='.$token.'>Clique AQUI para confirmar o logout</a>';
}
?>