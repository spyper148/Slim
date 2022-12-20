<?php

use App\Controllers\PageController;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

ORM::configure('mysql:host=localhost;dbname=jobboard');//Объявление входа в базу данных
ORM::configure('username', 'root');// Ввод логина
ORM::configure('password', '');// Ввод пароля для входа в СУБД

// Создание экземпляров класса в системе

$app->get('/', [PageController::class, 'index']);
$app->get('/job/{id}', [PageController::class, 'job_details']);
$app->get('/jobs', [PageController::class, 'jobs']);
$app->post('/form', [PageController::class, 'form']);
//Запуск
$app->run();