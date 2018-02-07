<?php
use Workerman\Worker;
require_once dirname(__DIR__ ). '/Workerman/Autoloader.php';

$worker = new Worker('websocket://192.168.17.129:8484');
$worker->count = 4;
$worker->reusePort = true;
$worker->onMessage = function($connection, $data)
{
    $connection->send('ok');
};
// 运行worker
Worker::runAll();
