<?php

include('includes/config.php');

$user = $_SESSION['user'];

if (!$user->logged && !empty($_POST['email']) && !empty($_POST['password']))
{
    $user->Auth($_POST['email'], $_POST['password']);
    $_SESSION['user'] = $user;
}

header("location:index.php");
