<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('html_errors', 1);

require_once __DIR__ . '/../bootstrap/app.php';

$container->get('emitter')->emit($response);