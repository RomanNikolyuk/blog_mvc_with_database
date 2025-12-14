<?php

require __DIR__ . '/vendor/autoload.php';

$query = isset($_GET['q']) ? trim((string)$_GET['q']) : '';

$controller = new BlogController();
$controller->showAllPosts($query);
