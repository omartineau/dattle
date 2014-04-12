<?php

include('includes/config.php');

session_destroy();

$_SESSION['user'] = new User();

header("location:index.php");


