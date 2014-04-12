<?php
include('config.php');

echo "<pre>";

echo "create empty user\n";
$u = new User();
var_dump($u);
echo "\n";

echo "try to auth toto@mail.com:bad-pwd";
$u->Auth('toto@mail.com', 'bad-pwd');
var_dump($u);
echo "\n";

echo "try to create toto@mail.com:pwd (toto)";
$u->Create('toto@mail.com', 'pwd', 'toto');
var_dump($u);
echo "\n";

echo "</pre>";
