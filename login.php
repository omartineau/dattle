<?php

include('includes/config.php');

$user = $_SESSION['user'];

$loginFailed = false;

if (!$user->logged && !empty($_POST['email']) && !empty($_POST['password']))
{
    $user->Auth($_POST['email'], $_POST['password']);
    if ($user->logged)
    {
        $_SESSION['user'] = $user;
    }
    else
    {
        $loginFailed = true;
    }
}

if ($user->logged)
{
    header("location:index.php");
}
else
{
    $template = $twig->loadTemplate('login.html.twig');
    echo $template->render(array(
        'user' => $user,
        'loginFailed' => $loginFailed
    ));
}
