<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Controllers\TrajetController;
echo class_exists(TrajetController::class) ? 'OK' : 'NOT FOUND';