<?php
require __DIR__ . '/../vendor/autoload.php';

// This is global bootstrap for autoloading
$dotenv = new Dotenv\Dotenv(__DIR__."/../");
$dotenv->load();
