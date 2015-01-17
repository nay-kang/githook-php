<?php
require 'GithubHook.php';
$hook = new GithubHook();
$hook->hookPull(var_export($_POST,true));
?>
