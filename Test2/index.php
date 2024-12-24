<?php
require_once 'Database.php';
require_once 'Validation.php';
require_once 'TaskManager.php';
require_once 'API.php';

//echo 'hello';

$api = new API();
$api->handleRequest();
