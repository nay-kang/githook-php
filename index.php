<?php
require_once 'GitHook.php';
require_once 'GitRequest.php';

$request = GitRequest::createRequestFromGlobal('Github');
$hook = new GitHook();
$request->setHandler($hook);
$request->handleRequest();
?>
