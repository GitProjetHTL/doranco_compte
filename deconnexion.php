<?php 

require_once 'inc/init.php';

debug($_SESSION);

//enlever le membre de la session
unset($_SESSION['membre']);

header("location:connexion.php");

exit;

